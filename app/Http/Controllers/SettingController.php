<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Settings::all();
        return view('admin.pages.setting.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $fields = $request->get('fields'); // ex: fields=site_name,site_description
        if (!$fields) {
            $settings = Settings::all();
        } else {
            $fields = explode(',', $fields);
            $settings = Settings::whereIn('name', $fields)->get();
        }

        if (request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $settings
            ]);
        }

        return view('admin.pages.setting.index', compact('settings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'array|required',
        ]);

        foreach ($validated['name'] as $key => $value) {
            if ($value === null) {
                continue;
            }
            Settings::updateOrCreate([
                'name' => $key
            ], [
                'value' => $value
            ]);
        }

        return redirect()->back()->with('success', 'Settings updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
