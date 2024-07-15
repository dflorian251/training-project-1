<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
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
        $public = 1;
        $date = $request->input('date');
        $people_attended = $request->input('people_attended');

        $event = new Event([
            'name' => $name,
            'public' => $public,
            'date' => $date,
            'people_attended' => $people_attended
        ]);

        if ($event->save()) {
            return response()->json(['message' => 'Form submitted successfully']);
        } else {
            return response()->json(['message' => 'Problem occurred']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

}
