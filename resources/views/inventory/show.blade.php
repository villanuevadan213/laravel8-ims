<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-4 px-4">
        <div class="bg-white shadow-md rounded-lg p-6">
            <table class="w-full">
                <tr>
                    <th class="text-left text-sm font-medium text-gray-700">Name</th>
                    <td class="text-sm text-gray-900">{{ $product->name }}</td>
                </tr>
                <tr>
                    <th class="text-left text-sm font-medium text-gray-700">SKU</th>
                    <td class="text-sm text-gray-900">{{ $product->sku }}</td>
                </tr>
                <tr>
                    <th class="text-left text-sm font-medium text-gray-700">Category</th>
                    <td class="text-sm text-gray-900">{{ $product->category->name }}</td>
                </tr>
                <tr>
                    <th class="text-left text-sm font-medium text-gray-700">Quantity</th>
                    <td class="text-sm text-gray-900">{{ $product->quantity }}</td>
                </tr>
                <tr>
                    <th class="text-left text-sm font-medium text-gray-700">Reorder Level</th>
                    <td class="text-sm text-gray-900">{{ $product->reorder_level }}</td>
                </tr>
            </table>

            <div class="mt-4 flex space-x-2">
                <a href="{{ route('inventory.edit', $product->id) }}"
                    class="px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600">Edit</a>
                <form action="{{ route('inventory.destroy', $product->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-6 py-3 bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>