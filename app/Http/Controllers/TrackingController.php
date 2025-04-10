<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        // Logic to display tracking information
        return view('tracking.index');
    }
    public function create()
    {
        // Logic to show form for creating new tracking information
        return view('tracking.create');
    }
    public function store(Request $request)
    {
        // Logic to store new tracking information
        // Validate and save the data
        return redirect()->route('tracking.index')->with('success', 'Tracking information created successfully.');
    }
    public function show($id)
    {
        // Logic to display specific tracking information
        return view('tracking.show', compact('id'));
    }
    public function edit($id)
    {
        // Logic to show form for editing tracking information
        return view('tracking.edit', compact('id'));
    }
    public function update(Request $request, $id)
    {
        // Logic to update tracking information
        // Validate and save the data
        return redirect()->route('tracking.index')->with('success', 'Tracking information updated successfully.');
    }
    public function destroy($id)
    {
        // Logic to delete tracking information
        return redirect()->route('tracking.index')->with('success', 'Tracking information deleted successfully.');
    }
}
