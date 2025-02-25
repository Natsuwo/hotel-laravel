<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $perPage = 12;
        $records = DB::table(Gallery::TABLE_NAME)
            ->orderBy('id', 'desc')
            ->paginate($perPage);
        return view('admin.pages.gallery.index', [
            'records' => $records,
        ]);
    }

    public function upload(Request $request)
    {

        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $file = $request->file('image');
        // clearstatcache();
        $filePath = 'uploads/' . time() . '_' . $file->getClientOriginalName();
        if (!Storage::disk('r2')->exists($filePath)) {
            Storage::disk('r2')->put($filePath, file_get_contents($file), 'public');
        }
        $imageSize = @getimagesize($file);
        $fileSize = $file->getSize();

        $imageWidth = $imageSize ? $imageSize[0] : null;
        $imageHeight = $imageSize ? $imageSize[1] : null;
        $isChoose = $request->isChoose ? true : false;

        $id =  DB::table(Gallery::TABLE_NAME)->insertGetId([
            'title' => $file->getClientOriginalName(),
            'path' => $filePath,
            'size' => $fileSize,
            'width' => $imageWidth,
            'height' => $imageHeight,
        ]);

        $html = view('components.gallery-card', [
            'image' => (object)[
                'id' => $id,
                'title' => $file->getClientOriginalName(),
                'path' => $filePath,
                'size' => $fileSize,
                'width' => $imageWidth,
                'height' => $imageHeight,
            ],
            'url' => Storage::disk('r2')->temporaryUrl($filePath, now()->addMinutes(5)),
            'isChoose' => $isChoose,
            'selectable' => $isChoose,
        ])->render();

        return response()->json([
            'success' => 'Upload successful!',
            'html' => $html,
        ]);
    }
    public function delete(Request $request)
    {
        $id = $request->id;
        $record = DB::table(Gallery::TABLE_NAME)->where('id', $id)->first();

        if ($record) {
            Storage::disk('r2')->delete($record->path);
            DB::table(Gallery::TABLE_NAME)->where('id', $id)->delete();
            return response()->json([
                'message' => 'Delete successful!',
            ]);
        }

        return response()->json([
            'message' => 'Record not found!',
        ], 404);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $disk = Storage::disk('r2');
        $records = DB::table(Gallery::TABLE_NAME)
            ->where('title', 'like', '%' . $search . '%')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($record) use ($disk) {
                $record->path = $disk->temporaryUrl($record->path, now()->addMinutes(5));
                return $record;
            });
        $html = '';
        foreach ($records as $record) {
            $html .= view('components.gallery-card', [
                'image' => $record,
                'url' => $record->path,
                'selectable' => true,
            ])->render();
        }

        return response()->json([
            'result' => $html,
        ]);
    }

    public function modal()
    {
        $perPage = 12;
        $records = DB::table(Gallery::TABLE_NAME)
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        $html = view('admin.pages.gallery.modal', [
            'records' => $records,
            'isChoose' => true,
        ])->render();

        return response()->json([
            'html' => $html,
        ]);
    }
}
