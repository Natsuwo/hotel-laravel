<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomTypeRequest;
use App\Models\RoomTypes;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RoomTypesController extends Controller
{
    public function create()
    {
        $facilities = DB::table('facilities')->get();
        $features = DB::table('features')
            ->where('type', 'feature')
            ->get();
        $amenities = DB::table('features')
            ->where('type', 'amenity')
            ->get();
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
                    'facility_id' => $facility
                ]);
            }
        }

        if (count($request->amenities) > 0) {
            foreach ($request->amenities as $amenity) {
                DB::table('room_amenities')->insert([
                    'room_type_id' => $roomType->id,
                    'amenity_id' => $amenity
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
        $search = request()->query('search');
        $filter = request()->query('filter');
        $roomsQuery = DB::table('room_types');

        if ($filter == 'room_id' || $search) {
            $roomsQuery->join('rooms', 'room_types.id', '=', 'rooms.room_type_id')
                ->where('rooms.room_number', 'like', "%$search%");
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
                    return $gallery->path;
                });
            $room->amenities = DB::table('room_amenities')
                ->where('room_type_id', $room->id)
                ->get()
                ->map(function ($record) {
                    return DB::table('features')->where('id', $record->amenity_id)->first();
                });
            $room->facilities = DB::table('room_facilities')
                ->where('room_type_id', $room->id)
                ->get()
                ->map(function ($record) {
                    return DB::table('facilities')->where('id', $record->facility_id)->first();
                });
            $room->features = DB::table('room_features')
                ->where('room_type_id', $room->id)
                ->get()
                ->map(function ($record) {
                    return DB::table('features')->where('id', $record->feature_id)->first();
                });
        });

        return view('admin.pages.room_types.index', compact('rooms'));
    }

    public function getRoomById($id)
    {
        $room = DB::table('room_types')->where('id', $id)->first();
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
                return $gallery->path;
            });

        $room->facilities = DB::table('room_facilities')
            ->where('room_type_id', $room->id)
            ->get()
            ->map(function ($record) {
                return DB::table('facilities')->where('id', $record->facility_id)->first();
            });

        $room->amenities = DB::table('room_amenities')
            ->where('room_type_id', $room->id)
            ->get()
            ->map(function ($record) {
                return DB::table('features')->where('id', $record->amenity_id)->first();
            });
        $room->features = DB::table('room_features')
            ->where('room_type_id', $room->id)
            ->get()
            ->map(function ($record) {
                return DB::table('features')->where('id', $record->feature_id)->first();
            });
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
                $facility = DB::table('facilities')->where('id', $record->facility_id)->first();
                return $facility ? $facility->id : null;
            });

        $room->amenities = DB::table('room_amenities')
            ->where('room_type_id', $room->id)
            ->get()
            ->map(function ($record) {
                $amenity = DB::table('features')->where('id', $record->amenity_id)->first();
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
                return $gallery->path;
            });

        $room->thumbnails = $thumbnails;
        $facilities = DB::table('facilities')->get();
        $amenities = DB::table('features')
            ->where('type', 'amenity')
            ->get();
        $features = DB::table('features')
            ->where('type', 'feature')
            ->get();
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

        DB::table('room_types')->where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'bed_type' => $request->bed_type,
            'bed_count' => $request->bed_count,
            'acreage' => $request->acreage,
            'guest_count' => $request->guest_count,
            'features' => json_encode($request->features),
            'facilities' => json_encode($request->facilities),
            'amenities' => json_encode($request->amenities),
            'images' => json_encode($uniqueImages),
            'price_per_night' => $request->price_per_night,
            'price_per_hour' => $request->price_per_hour,
        ]);

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
