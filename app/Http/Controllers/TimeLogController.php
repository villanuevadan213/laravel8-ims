<?php

namespace App\Http\Controllers;

use App\Models\TimeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeLogController extends Controller
{
    public function clockInOut()
    {
        $timeLogs = TimeLog::where('user_id', auth()->id())
                           ->whereDate('clock_in', now()->toDateString()) 
                           ->get();
    
        // Compute overtime for each log
        $timeLogs = $timeLogs->map(function ($log) {
            $regularHours = 8;
            
            if ($log->clock_out) {
                $totalHours = $log->clock_in->diffInHours($log->clock_out);
                
                $overtimeHours = $totalHours > $regularHours ? $totalHours - $regularHours : 0;
    
                $log->overtime = gmdate('H:i:s', $overtimeHours * 3600);
            } else {
                $log->overtime = '';
            }
    
            return $log;
        });
    
        return view('clock-in-out', compact('timeLogs'));
    }

    public function clockIn(Request $request)
    {
        $existingClockIn = TimeLog::where('user_id', auth()->id())
                                  ->whereDate('clock_in', now()->toDateString())
                                  ->first();

        if ($existingClockIn) {
            return redirect()->route('clock-in-out')->with('error', 'You have already clocked in today!');
        }

        $timeLog = new TimeLog();
        $timeLog->user_id = auth()->id();
        $timeLog->clock_in = now();
        $timeLog->save();

        return redirect()->route('clock-in-out')->with('success', 'You have successfully clocked in!');
    }

    public function breakIn(Request $request)
    {
        $attendance = TimeLog::where('user_id', auth()->id())->whereDate('created_at', now()->toDateString())->first();
        if ($attendance) {
            $attendance->break_in = now();
            $attendance->save();
        }
        return back()->with('success', 'Break started.');
    }

    public function breakOut(Request $request)
    {
        $attendance = TimeLog::where('user_id', auth()->id())->whereDate('created_at', now()->toDateString())->first();
        if ($attendance) {
            $attendance->break_out = now();
            $attendance->save();
        }
        return back()->with('success', 'Break ended.');
    }

    public function clockOut(Request $request)
    {
        $existingClockOut = TimeLog::where('user_id', auth()->id())
                                   ->whereDate('clock_in', now()->toDateString())
                                   ->whereNotNull('clock_out') 
                                   ->first();

        if ($existingClockOut) {
            return redirect()->route('clock-in-out')->with('error', 'You have already clocked out today!');
        }

        $timeLog = TimeLog::where('user_id', auth()->id())
                         ->whereDate('clock_in', now()->toDateString())
                         ->whereNull('clock_out')
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
