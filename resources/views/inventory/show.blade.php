<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-4 px-4">
        <div class="mb-4">
            <h3 class="text-lg font-medium text-gray-800">Product Information</h3>
            <p>Name: {{ $product->name }}</p>
            <p>SKU: {{ $product->sku }}</p>
            <p>Quantity: {{ $product->quantity }}</p>
            <p>Unit: {{ $product->unit }}</p>
            <p>Category: {{ $product->category->name }}</p>
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-medium text-gray-800">Stock Movement History</h3>
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Type</th>
                        <th class="px-4 py-2 text-left">Quantity</th>
                        <th class="px-4 py-2 text-left">Reference</th>
                        <th class="px-4 py-2 text-left">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product->stockMovements as $movement)
                        <tr>
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
</x-layout>