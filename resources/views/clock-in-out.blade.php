<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl sm:text-2xl text-gray-800 leading-tight">
            {{ __('Attendance') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-6 px-4">
        <!-- Clock Section -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Clock In / Break / Clock Out</h3>

            @php
                $log = $timeLogs->first();
            @endphp

            @if(!$log)
                <!-- Not clocked in -->
                <form method="POST" action="{{ route('clock-in') }}">
                    @csrf
                    <button type="submit"
                        class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition">
                        Clock In
                    </button>
                </form>
                <p class="mt-4 text-sm text-gray-600">Click "Clock In" to start your work session.</p>

            @elseif($log && !$log->break_in)
                <!-- Show Break In button -->
                <form method="POST" action="{{ route('break-in') }}">
                    @csrf
                    <button type="submit"
                        class="bg-yellow-500 text-white px-6 py-2 rounded-md hover:bg-yellow-600 transition">
                        Break In
                    </button>
                </form>

            @elseif($log && $log->break_in && !$log->break_out)
                <!-- Show Break Out button -->
                <form method="POST" action="{{ route('break-out') }}">
                    @csrf
                    <button type="submit"
                        class="bg-yellow-600 text-white px-6 py-2 rounded-md hover:bg-yellow-700 transition">
                        Break Out
                    </button>
                </form>

            @elseif($log && !$log->clock_out)
                <!-- Show Clock Out button -->
                <form method="POST" action="{{ route('clock-out') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-600 transition">
                        Clock Out
                    </button>
                </form>
                <p class="mt-4 text-sm text-gray-600">You're currently clocked in. Please clock out when you're done.</p>

            @else
                <p class="text-sm text-gray-600">✅ You’ve already clocked in and out today.</p>
            @endif

            @if(session('success'))
                <div class="mt-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="mt-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded-md">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- Time Logs -->
        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200 overflow-x-auto">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Your Time Log Records</h3>

            <table class="min-w-full text-sm text-left text-gray-700 border-collapse">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Clock In</th>
                        <th class="px-6 py-3">Break In</th>
                        <th class="px-6 py-3">Break Out</th>
                        <th class="px-6 py-3">Clock Out</th>
                        <th class="px-6 py-3">Duration</th>
                        <th class="px-6 py-3">Overtime</th>
                        <th class="px-6 py-3">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($timeLogs as $log)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4">{{ $log->clock_in->format('d-m-Y') }}</td>
                                            <td class="px-6 py-4">{{ $log->clock_in->format('H:i:s') }}</td>
                                            <td class="px-6 py-4">
                                                {{ $log->break_in ? $log->break_in->format('H:i:s') : '—' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $log->break_out ? $log->break_out->format('H:i:s') : '—' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $log->clock_out ? $log->clock_out->format('H:i:s') : 'Not clocked out' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($log->clock_out)
                                                    {{ $log->clock_in->diff($log->clock_out)->format('%Hh %Im %Ss') }}
                                                @else
                                                    <span class="text-gray-500 italic">N/A</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $log->overtime }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $remark = '';

                                                    // Default Clock In remark
                                                    if ($log->clock_in) {
                                                        $remark = 'Clocked In';

                                                        // Check for late
                                                        $lateTime = \Carbon\Carbon::parse($log->clock_in->format('Y-m-d') . ' 08:00:00');
                                                        if ($log->clock_in->greaterThan($lateTime)) {
                                                            $remark .= ' - <strong class="text-red-500">LATE</strong>';
                                                        }
                                                    }

                                                    // Break remarks
                                                    if ($log->break_in && $log->break_out) {
                                                        $breakDuration = $log->break_in->diffInMinutes($log->break_out);
                                                        $remark = $breakDuration > 60 ? 'Overbreak' : 'On Break';
                                                    } elseif ($log->break_in && !$log->break_out) {
                                                        $remark = 'On Break';
                                                    }

                                                    // Clock Out remarks
                                                    if ($log->clock_in && $log->clock_out) {
                                                        $workMinutes = $log->clock_in->diffInMinutes($log->clock_out);
                                                        $breakMinutes = ($log->break_in && $log->break_out) ? $log->break_in->diffInMinutes($log->break_out) : 0;
                                                        $totalMinutes = $workMinutes - $breakMinutes;

                                                        $remark = $totalMinutes > 540 ? 'Overtime' : 'Clocked Out';

                                                        // Check if also late at clock in
                                                        $lateTime = \Carbon\Carbon::parse($log->clock_in->format('Y-m-d') . ' 08:00:00');
                                                        if ($log->clock_in->greaterThan($lateTime)) {
                                                            $remark .= ' - <strong class="text-red-500">LATE</strong>';
                                                        }
                                                    }
                                                @endphp

                                                {!! $remark !!}
                                            </td>
                                        </tr>
                    @endforeach

                    @if ($timeLogs->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center px-6 py-4 text-gray-500">No logs available.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-layout>