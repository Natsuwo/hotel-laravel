<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomTypeRequest;
use App\Models\Rooms;
use App\Models\RoomTypes;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RoomTypesController extends Controller
{
    public function create()
    {
        $featuresAll = DB::table('features')->get();
        $amenities = $featuresAll->filter(function ($feature) {
            return $feature->type === 'amenity';
        });
        $facilities = $featuresAll->filter(function ($feature) {
            return $feature->type === 'facility';
        });
        $features = $featuresAll->filter(function ($feature) {
            return $feature->type === 'feature';
        });
        return view('admin.pages.room_types.create', [
            'facilities' => $facilities,
            'features' => $features,
            'amenities' => $amenities
        ]);
    }

    public function store(StoreRoomTypeRequest $request)
    {
        $images = $request->images;
        $uniqueImages = array_unique($images);
        // remove duplicate values
        $uniqueImages = array_filter($uniqueImages, function ($value) {
            return $value !== null;
        });

        $roomType =  RoomTypes::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'bed_type' => $request->bed_type,
            'bed_count' => $request->bed_count,
            'acreage' => $request->acreage,
            'guest_count' => $request->guest_count,
            'price_per_night' => $request->price_per_night,
            'price_per_hour' => $request->price_per_hour,
            'discount' => $request->discount,
        ]);

        // add gallery_id to room_gallery table

        if (count($uniqueImages) > 0) {
            foreach ($uniqueImages as $image) {
                DB::table('room_galleries')->insert([
                    'room_type_id' => $roomType->id,
                    'gallery_id' => $image
                ]);
            }
        }

        if (count($request->facilities) > 0) {
            foreach ($request->facilities as $facility) {
                DB::table('room_facilities')->insert([
                    'room_type_id' => $roomType->id,
                    'feature_id' => $facility
                ]);
            }
        }

        if (count($request->amenities) > 0) {
            foreach ($request->amenities as $amenity) {
                DB::table('room_amenities')->insert([
                    'room_type_id' => $roomType->id,
                    'feature_id' => $amenity
                ]);
            }
        }

        if (count($request->features) > 0) {
            foreach ($request->features as $feature) {
                DB::table('room_features')->insert([
                    'room_type_id' => $roomType->id,
                    'feature_id' => $feature
                ]);
            }
        }

        return redirect()->route('admin.room_types.index');
    }

    public function index()
    {
        $search = request()->query('search') ?? '';
        $filter = request()->query('filter');
        $check_in = request()->query('check_in');
        $check_out = request()->query('check_out');
        $roomsQuery = DB::table('room_types');
        $perPage = 20;

        if ($filter == 'room_id') {
            $room_filter = request()->query('room_filter');
            $sort = request()->query('sort') === 'desc' ? 'desc' : 'asc';
            $rooms =  $roomsQuery->join('rooms', 'room_types.id', '=', 'rooms.room_type_id')
                ->leftJoin('floors', 'rooms.floor_id', '=', 'floors.id')
                ->where('rooms.room_number', 'like', "%$search%")
                ->orderBy(DB::raw('LENGTH(rooms.room_number)'), $sort)
                ->orderBy('rooms.room_number', $sort)
                ->select(
                    'room_types.*',
                    'rooms.id as room_id',
                    'rooms.room_number',
                    'rooms.status',
                    'floors.floor_number'
                );
            if ($room_filter && $room_filter !== 'all') {
                $rooms->where('rooms.status', $room_filter);
            }
            $rooms = $rooms->paginate($perPage);
        } else {
            if ($search) {
                $roomsQuery->where('title', 'like', "%$search%");
            } else if ($check_in && $check_out) {
                $reservations = DB::table('reservations')
                    ->where(function ($query) use ($check_in, $check_out) {
                        $query->whereBetween('check_in', [$check_in, $check_out])
                            ->orWhereBetween('check_out', [$check_in, $check_out])
                            ->orWhere(function ($query) use ($check_in, $check_out) {
                                $query->where('check_in', '<=', $check_in)
                                    ->where('check_out', '>=', $check_out);
                            });
                    })
                    ->get();

                $roomIds = $reservations->pluck('room_id')->unique();

                $reservedRoomIds = $roomsQuery->get()->filter(function ($item) use ($roomIds) {
                    $rooms = DB::table('rooms')->where('room_type_id', $item->id);
                    $total = $rooms->count();
                    $roomOccupied = $rooms->whereIn('id', $roomIds)->count();
                    // if ($item->title == 'Presidential') {
                    //     dd($total, $roomOccupied);
                    // }
                    return $total === $roomOccupied;
                })->pluck('id');


                $roomsQuery->whereNotIn('id', $reservedRoomIds);
            }

            $rooms = $roomsQuery->get();
            $rooms->each(function ($room) {
                $room->available_rooms = DB::table('rooms')
                    ->where('room_type_id', $room->id)
                    ->where('status', 'available')
                    ->count();
                $room->total_rooms = DB::table('rooms')
                    ->where('room_type_id', $room->id)
                    ->count();
                $room->thumbnails = DB::table('room_galleries')
                    ->where('room_type_id', $room->id)
                    ->get()
                    ->map(function ($record) {
                        $gallery = DB::table('galleries')->where('id', $record->gallery_id)->first();
                        if (!$gallery) return null;
                        $disk = Storage::disk('r2'); // Assuming you are using S3
                        $gallery->path = $disk->temporaryUrl($gallery->path, now()->addMinutes(5));
                        return [
                            'id' => $gallery->id,
                            'url' => $gallery->path
                        ];
                    });
                $room->amenities = DB::table('room_amenities')
                    ->where('room_type_id', $room->id)
                    ->get()
                    ->map(function ($record) {
                        return DB::table('features')->where('id', $record->feature_id)->first();
                    });
                $room->facilities = DB::table('room_facilities')
                    ->where('room_type_id', $room->id)
                    ->get()
                    ->map(function ($record) {
                        return DB::table('features')->where('id', $record->feature_id)->first();
                    });
                $room->features = DB::table('room_features')
                    ->where('room_type_id', $room->id)
                    ->get()
                    ->map(function ($record) {
                        return DB::table('features')->where('id', $record->feature_id)->first();
                    });
            });
        }

        if (request()->is('api/*')) {
            return response()->json(['success' => true, 'data' => $rooms]);
        }
        return view('admin.pages.room_types.index', compact('rooms'));
    }

    public function getRoomById($id)
    {
        // $room = DB::table('room_types')->where('id', $id)
        //     ->orWhere('slug', $id)
        //     ->first();
        $room = Rooms::where('id', $id)
            ->with('roomType')
            ->first();
        $room->available_rooms = DB::table('rooms')
            ->where('room_type_id', $room?->room_type_id)
            ->where('status', 'available')
            ->count();
        $room->total_rooms = DB::table('rooms')
            ->where('room_type_id', $room->room_type_id)
            ->count();

        $room->thumbnails = DB::table('room_galleries')
            ->where('room_type_id', $room->room_type_id)
            ->get()
            ->map(function ($record) {
                $gallery = DB::table('galleries')->where('id', $record->gallery_id)->first();
                if (!$gallery) return null;
                $disk = Storage::disk('r2'); // Assuming you are using S3
                $gallery->path = $disk->temporaryUrl($gallery->path, now()->addMinutes(5));
                return [
                    'id' => $gallery->id,
                    'url' => $gallery->path
                ];
            });

        $room->facilities = DB::table('room_facilities')
            ->where('room_type_id', $room->room_type_id)
            ->get()
            ->map(function ($record) {
                return DB::table('features')->where('id', $record->feature_id)->first();
            });

        $room->amenities = DB::table('room_amenities')
            ->where('room_type_id', $room->room_type_id)
            ->get()
            ->map(function ($record) {
                return DB::table('features')->where('id', $record->feature_id)->first();
            });
        $room->features = DB::table('room_features')
            ->where('room_type_id', $room->room_type_id)
            ->get()
            ->map(function ($record) {
                return DB::table('features')->where('id', $record->feature_id)->first();
            });

        if (request()->is('api/*')) {
            return response()->json(['success' => true, 'data' => $room]);
        }
        $result = view('components.room-detail-sidebar', ['room' => $room])->render();
        return response()->json(['html' => $result]);
    }

    public function getRoomTypesById($id)
    {
        $room = DB::table('room_types')->where('id', $id)
            ->orWhere('slug', $id)
            ->first();
        // $room = Rooms::where('id', $id)
        //     ->with('roomType')
        //     ->first();
        $room->available_rooms = DB::table('rooms')
            ->where('room_type_id', $room?->id)
            ->where('status', 'available')
            ->count();
        $room->total_rooms = DB::table('rooms')
            ->where('room_type_id', $room->id)
            ->count();

        $room->thumbnails = DB::table('room_galleries')
            ->where('room_type_id', $room->id)
            ->get()
            ->map(function ($record) {
                $gallery = DB::table('galleries')->where('id', $record->gallery_id)->first();
                if (!$gallery) return null;
                $disk = Storage::disk('r2'); // Assuming you are using S3
                $gallery->path = $disk->temporaryUrl($gallery->path, now()->addMinutes(5));
                return [
                    'id' => $gallery->id,
                    'url' => $gallery->path
                ];
            });

        $room->facilities = DB::table('room_facilities')
            ->where('room_type_id', $room->id)
            ->get()
            ->map(function ($record) {
                return DB::table('features')->where('id', $record->feature_id)->first();
            });

        $room->amenities = DB::table('room_amenities')
            ->where('room_type_id', $room->id)
            ->get()
            ->map(function ($record) {
                return DB::table('features')->where('id', $record->feature_id)->first();
            });
        $room->features = DB::table('room_features')
            ->where('room_type_id', $room->id)
            ->get()
            ->map(function ($record) {
                return DB::table('features')->where('id', $record->feature_id)->first();
            });

        if (request()->is('api/*')) {
            return response()->json(['success' => true, 'data' => $room]);
        }
        $result = view('components.room-detail-sidebar', ['room' => $room])->render();
        return response()->json(['html' => $result]);
    }

    public function edit($id)
    {
        $room = RoomTypes::find($id);
        $room->features = DB::table('room_features')
            ->where('room_type_id', $room->id)
            ->get()
            ->map(function ($record) {
                $feature = DB::table('features')->where('id', $record->feature_id)->first();
                return $feature ? $feature->id : null;
            });

        $room->facilities = DB::table('room_facilities')
            ->where('room_type_id', $room->id)
            ->get()
            ->map(function ($record) {
                $facility = DB::table('features')->where('id', $record->feature_id)->first();
                return $facility ? $facility->id : null;
            });

        $room->amenities = DB::table('room_amenities')
            ->where('room_type_id', $room->id)
            ->get()
            ->map(function ($record) {
                $amenity = DB::table('features')->where('id', $record->feature_id)->first();
                return $amenity ? $amenity->id : null;
            });



        $thumbnails = DB::table('room_galleries')
            ->where('room_type_id', $room->id)
            ->get()
            ->map(function ($record) {
                $gallery = DB::table('galleries')->where('id', $record->gallery_id)->first();
                if (!$gallery) return null;
                $disk = Storage::disk('r2'); // Assuming you are using S3
                $gallery->path = $disk->temporaryUrl($gallery->path, now()->addMinutes(5));
                return [
                    'id' => $gallery->id,
                    'url' => $gallery->path
                ];
            });

        $room->thumbnails = $thumbnails;
        $featuresAll = DB::table('features')->get();
        $amenities = $featuresAll->filter(function ($feature) {
            return $feature->type === 'amenity';
        });
        $facilities = $featuresAll->filter(function ($feature) {
            return $feature->type === 'facility';
        });
        $features = $featuresAll->filter(function ($feature) {
            return $feature->type === 'feature';
        });
        return view('admin.pages.room_types.edit', [
            'record' => $room,
            'facilities' => $facilities,
            'amenities' => $amenities,
            'features' => $features
        ]);
    }

    public function update(StoreRoomTypeRequest $request, $id)
    {
        // validate duplicate id in images
        $images = $request->images;
        $uniqueImages = array_unique($images);
        // remove duplicate values
        $uniqueImages = array_filter($uniqueImages, function ($value) {
            return $value !== null;
        });

        // update room type

        RoomTypes::where('id', $id)
            ->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'description' => $request->description,
                'bed_type' => $request->bed_type,
                'bed_count' => $request->bed_count,
                'acreage' => $request->acreage,
                'guest_count' => $request->guest_count,
                'price_per_night' => $request->price_per_night,
                'price_per_hour' => $request->price_per_hour,
            ]);

        // update gallery_id in room_gallery table

        DB::table('room_galleries')->where('room_type_id', $id)->delete();
        if (count($uniqueImages) > 0) {
            foreach ($uniqueImages as $image) {
                DB::table('room_galleries')->insert([
                    'room_type_id' => $id,
                    'gallery_id' => $image
                ]);
            }
        }

        // update facilities

        DB::table('room_facilities')->where('room_type_id', $id)->delete();
        if (count($request->facilities) > 0) {
            foreach ($request->facilities as $facility) {
                DB::table('room_facilities')->insert([
                    'room_type_id' => $id,
                    'feature_id' => $facility
                ]);
            }
        }

        // update amenities

        DB::table('room_amenities')->where('room_type_id', $id)->delete();
        if (count($request->amenities) > 0) {
            foreach ($request->amenities as $amenity) {
                DB::table('room_amenities')->insert([
                    'room_type_id' => $id,
                    'feature_id' => $amenity
                ]);
            }
        }

        // update features

        DB::table('room_features')->where('room_type_id', $id)->delete();
        if (count($request->features) > 0) {
            foreach ($request->features as $feature) {
                DB::table('room_features')->insert([
                    'room_type_id' => $id,
                    'feature_id' => $feature
                ]);
            }
        }


        return redirect()->route('admin.room_types.index');
    }

    public function destroy($id)
    {
        $check = DB::table('room_types')->where('id', $id)->delete();
        return redirect()->route('admin.room_types.index')
            ->with(
                $check ? 'success' : 'error',
                $check ? 'Delete room successfully' : 'Delete room failed'
            );
    }

    public function checkSlug(Request $request)
    {
        $slug = Str::slug($request->slug);
        $counter = 1;
        while (DB::table('room_types')->where('slug', $slug)->exists()) {
            $slug = $slug . '-' . $counter;
            $counter++;
        }
        return response()->json(['exists' => $counter > 1, 'slug' => $slug]);
    }
}
