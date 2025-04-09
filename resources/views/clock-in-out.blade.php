<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clock In/Clock Out') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-6 px-4">
        <!-- Clock In/Clock Out Section -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Clock In/Clock Out</h3>

            @if($timeLogs->isEmpty())
                <!-- If the user has neither clocked in nor clocked out today -->
                <form method="POST" action="{{ route('clock-in') }}">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                        Clock In
                    </button>
                </form>
                <p class="mt-4 text-sm text-gray-600">Click "Clock In" to start your work session.</p>
            @elseif($timeLogs->count() == 1 && !$timeLogs->first()->clock_out)
                <!-- If the user has clocked in but not clocked out yet -->
                <form method="POST" action="{{ route('clock-out') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                        Clock Out
                    </button>
                </form>
                <p class="mt-4 text-sm text-gray-600">You are currently clocked in. Please clock out when you're done.</p>
            @elseif($timeLogs->count() == 1 && $timeLogs->first()->clock_out)
                <!-- If the user has already clocked in and clocked out today -->
                <p class="mt-4 text-sm text-gray-600">You have already clocked in and clocked out today.</p>
            @endif

            @if(session('success'))
                <div class="text-green-500 mt-4">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="text-red-500 mt-4">{{ session('error') }}</div>
            @endif
        </div>

        <!-- Time Logs Section -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Your Time Log Records</h3>

            <table class="min-w-full bg-white text-gray-700 table-auto border-collapse">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Date</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Clock In</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Clock Out</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Duration</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($timeLogs as $log)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm">{{ $log->clock_in->format('d-m-Y') }}</td>
                            <td class="px-6 py-4 text-sm">{{ $log->clock_in->format('H:i:s') }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($log->clock_out)
                                    {{ $log->clock_out->format('H:i:s') }}
                                @else
                                    <span class="text-red-500">Not clocked out yet</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($log->clock_out)
                                    {{ $log->clock_in->diff($log->clock_out)->format('%H:%I:%S') }}
                                @else
                                    <span class="text-gray-500">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>