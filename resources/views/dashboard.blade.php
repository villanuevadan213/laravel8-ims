<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-6 px-4 sm:px-6 lg:px-8">
        <!-- Inventory Overview Section -->
        <div
            class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
            <h3 class="text-2xl font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 12m-9 0a9 9 0 1 0 18 0 9 9 0 1 0-18 0z"></path>
                </svg>
                Inventory Overview
            </h3>
            <p class="text-lg text-gray-600">
                Total Products: <span class="font-bold text-gray-900 text-xl">{{ $totalProducts }}</span>
            </p>
        </div>

        <!-- Low Stock Alerts Section -->
        <div
            class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
            <h3 class="text-2xl font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.104 0-2 .896-2 2v4c0 1.104.896 2 2 2s2-.896 2-2V10c0-1.104-.896-2-2-2zm0 6h.01M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2z">
                    </path>
                </svg>
                Low Stock Alerts
            </h3>
            @if($lowStock->count() > 0)
                <ul class="list-disc pl-6 space-y-2 text-gray-700">
                    @foreach ($lowStock as $product)
                        <li class="flex justify-between items-center hover:bg-gray-50 transition-colors p-2 rounded-lg">
                            <div>
                                <span class="font-semibold text-gray-900">{{ $product->name }}</span>
                                <span class="text-sm text-gray-600">(SKU: {{ $product->sku }})</span>
                            </div>
                            <span class="text-red-500 font-semibold">{{ $product->quantity }} in stock</span>
                        </li>
                    @endforeach
                </ul>

                <!-- Pagination Links -->
                <div class="mt-6 flex justify-center">
                    {{ $lowStock->links() }}
                </div>
            @else
                <p class="text-gray-600 text-center py-4">No products are below the reorder level.</p>
            @endif
        </div>

        <!-- Recent Stock Movements Section -->
        <div
            class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
            <h3 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
                Recent Stock Movements
            </h3>
            <table class="min-w-full bg-white text-gray-700 table-auto border-collapse">
                <thead class="bg-gray-100 border-b border-gray-300">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Product Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Type</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Quantity</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Reference</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentMovements as $movement)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm">{{ $movement->product->name }}</td>
                            <td class="px-6 py-4 text-sm capitalize">{{ $movement->type }}</td>
                            <td class="px-6 py-4 text-sm">{{ $movement->quantity }}</td>
                            <td class="px-6 py-4 text-sm">{{ $movement->reference }}</td>
                            <td class="px-6 py-4 text-sm">{{ $movement->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>