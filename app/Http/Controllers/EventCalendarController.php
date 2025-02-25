<?php

namespace App\Http\Controllers;

use App\Models\EventCalendar;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;

class EventCalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $events = [];
        if ($request->query('type') === 'json') {
            $start = $request->query('start');
            $end = $request->query('end');
            $events = EventCalendar::whereBetween('start', [$start, $end])->get();
            return response()->json($events);
        }
        return view('admin.pages.event_calendar.index', compact('events'));
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
        $request->validate([
            'title' => 'string|required',
            'start' => 'date|required',
            'end' => 'date|required',
            'color' => 'string|required',
        ]);

        $event = [
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'color' => $request->color,
        ];
        $event = EventCalendar::create($event);
        return response()->json($event);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $request->validate([
            'title' => 'string|required',
            'start' => 'date|required',
            'end' => 'date|required',
            'color' => 'string|required',
        ]);

        $event = EventCalendar::find($request->id);
        $event->title = $request->title;
        $event->start = $request->start;
        $event->end = $request->end;
        $event->color = $request->color;
        $event->save();
        return response()->json($event);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $event = EventCalendar::find($request->id);
        $event->delete();
        return response()->json($event);
    }
}
