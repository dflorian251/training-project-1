<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    public function getPage()
    {
        if (! Gate::allows('data-entry')) {
            abort(403);
        }
        return Inertia::render('Data');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'name' => 'required',
        //     'publicity_chechbox' => 'required',
        //     'date' => 'required',
        //     'people_attended' => 'required'
        // ]);

        // $name = $validated['name'];
        // $publicity = $validated['publicity_chechbox'];
        // $date = $validated['date'];
        // $people_attended = $validated['people_attended'];
        $name = $request->input('name');
        if ($request->input('publicity') === 'public') {
            $eventVisibility = 1;
        } else {
            $eventVisibility = 0;
        }
        $date = $request->input('date');
        $people_attended = $request->input('people_attended');

        $event = new Event([
            'name' => $name,
            'public' => $eventVisibility,
            'date' => $date,
            'people_attended' => $people_attended
        ]);

        if ($event->save()) {
            return ['redirect' => route('data')];
        } else {
            return response()->json(['message' => 'Problem occurred']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function index()
    {
        $events = Event::orderBy('date', 'desc')->get(['date', 'people_attended']);

        return $events;
    }

}
