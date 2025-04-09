<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl sm:text-2xl text-gray-800 leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-4 px-4">
        <!-- Product Info Section -->
        <div class="mb-4 bg-white p-4 sm:p-6 rounded-lg shadow">
            <h3 class="text-lg sm:text-xl font-medium text-gray-800 mb-2">Product Information</h3>
            <div class="text-sm sm:text-base text-gray-700 space-y-1">
                <p><span class="font-semibold">Name:</span> {{ $product->name }}</p>
                <p><span class="font-semibold">SKU:</span> {{ $product->sku }}</p>
                <p><span class="font-semibold">Quantity:</span> {{ $product->quantity }}</p>
                <p><span class="font-semibold">Unit:</span> {{ $product->unit }}</p>
                <p><span class="font-semibold">Category:</span> {{ $product->category->name }}</p>
            </div>
        </div>

        <!-- Stock Movement History Section -->
        <div class="mb-4 bg-white p-4 sm:p-6 rounded-lg shadow">
            <h3 class="text-lg sm:text-xl font-medium text-gray-800 mb-4">Stock Movement History</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm sm:text-base border border-gray-300 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-700 font-medium">Type</th>
                            <th class="px-4 py-2 text-left text-gray-700 font-medium">Quantity</th>
                            <th class="px-4 py-2 text-left text-gray-700 font-medium">Reference</th>
                            <th class="px-4 py-2 text-left text-gray-700 font-medium">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($product->stockMovements as $movement)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-2">{{ ucfirst($movement->type) }}</td>
                                <td class="px-4 py-2">{{ $movement->quantity }}</td>
                                <td class="px-4 py-2">{{ $movement->reference }}</td>
                                <td class="px-4 py-2">{{ $movement->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>