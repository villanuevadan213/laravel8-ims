<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventory') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-4 px-4">
        <a href="{{ route('inventory.create') }}"
            class="inline-block px-6 py-3 mb-6 bg-green-500 text-white rounded-md hover:bg-green-600">
            Add New Product
        </a>

        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">SKU</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Category</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Quantity</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($products as $product)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $product->sku }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $product->category->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $product->quantity }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 space-x-2">
                                <a href="{{ route('inventory.show', $product->id) }}"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">View</a>
                                <a href="{{ route('inventory.edit', $product->id) }}"
                                    class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('inventory.destroy', $product->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>