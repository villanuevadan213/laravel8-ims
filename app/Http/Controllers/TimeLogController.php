<?php

namespace App\Http\Controllers;

use App\Models\TimeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeLogController extends Controller
{
    // Method to show the clock-in/out page
    public function clockInOut()
    {
        // Get the user's time logs for the current date
        $timeLogs = TimeLog::where('user_id', auth()->id())
                           ->whereDate('clock_in', now()->toDateString()) // Filter by today's date
                           ->get();

        return view('clock-in-out', compact('timeLogs'));
    }

    // Method for Clocking In
    public function clockIn(Request $request)
    {
        // Check if the user has already clocked in today
        $existingClockIn = TimeLog::where('user_id', auth()->id())
                                  ->whereDate('clock_in', now()->toDateString()) // Filter by today's date
                                  ->first();

        if ($existingClockIn) {
            return redirect()->route('clock-in-out')->with('error', 'You have already clocked in today!');
        }

        // Create a new clock-in record
        $timeLog = new TimeLog();
        $timeLog->user_id = auth()->id();
        $timeLog->clock_in = now();
        $timeLog->save();

        return redirect()->route('clock-in-out')->with('success', 'You have successfully clocked in!');
    }

    // Method for Clocking Out
    public function clockOut(Request $request)
    {
        // Check if the user has already clocked out today
        $existingClockOut = TimeLog::where('user_id', auth()->id())
                                   ->whereDate('clock_in', now()->toDateString()) // Filter by today's date
                                   ->whereNotNull('clock_out') // Check if clock_out exists
                                   ->first();

        if ($existingClockOut) {
            return redirect()->route('clock-in-out')->with('error', 'You have already clocked out today!');
        }

        // Check if the user has clocked in but not clocked out yet
        $timeLog = TimeLog::where('user_id', auth()->id())
                         ->whereDate('clock_in', now()->toDateString()) // Filter by today's date
                         ->whereNull('clock_out') // Ensure there's no clock-out yet
                         ->latest()
                         ->first();

        if ($timeLog) {
            $timeLog->clock_out = now();
            $timeLog->save();

            return redirect()->route('clock-in-out')->with('success', 'You have successfully clocked out!');
        }

        return redirect()->route('clock-in-out')->with('error', 'You need to clock in first before you can clock out!');
    }
}
