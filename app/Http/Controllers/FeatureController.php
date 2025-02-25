<?php

namespace App\Http\Controllers;

use App\Http\Requests\Feature\StoreRequest;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeatureController extends Controller
{

    public function index()
    {
        $perPage = 10;
        $records = DB::table(Feature::TABLE_NAME)
            ->orderBy('id', 'desc')
            ->paginate($perPage);
        return view('admin.pages.feature.index', [
            'records' => $records,
        ]);
    }

    public function create()
    {
        return view('admin.pages.feature.create');
    }

    public function store(StoreRequest $request)
    {
        $check = DB::table(Feature::TABLE_NAME)->insert([
            'type' => $request->type,
            'name' => $request->name,
            'icon' => $request->icon,
        ]);

        return redirect()->route('admin.feature.index')
            ->with(
                $check ? 'message' : 'error',
                $check ? 'Data added successfully' : 'Failed to add data'
            );
    }

    public function update(StoreRequest $request, $id)
    {

        $check = DB::table(Feature::TABLE_NAME)
            ->where('id', $id)
            ->update([
                'type' => $request->type,
                'name' => $request->name,
                'icon' => $request->icon,
            ]);

        return redirect()->route('admin.feature.index')
            ->with(
                $check ? 'message' : 'error',
                $check ? 'Data updated successfully' : 'Failed to update data'
            );
    }

    public function edit($id)
    {
        $record = DB::table(Feature::TABLE_NAME)->where('id', $id)->first();
        return view('admin.pages.feature.edit', [
            'record' => $record,
        ]);
    }

    public function destroy($id)
    {
        $check = DB::table(Feature::TABLE_NAME)->where('id', $id)->delete();
        return redirect()->route('admin.feature.index')
            ->with(
                $check ? 'message' : 'error',
                $check ? 'Data deleted successfully' : 'Failed to delete data'
            );
    }
}
