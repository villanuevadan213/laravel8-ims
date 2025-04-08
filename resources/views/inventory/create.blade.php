<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Product') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-4 px-4">
        <form action="{{ route('inventory.store') }}" method="POST"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @csrf

            <div class="col-span-1 sm:col-span-2 lg:col-span-1">
                <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    name="name" id="name" required>
            </div>

            <div class="col-span-1 sm:col-span-2 lg:col-span-1">
                <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
                <input type="text"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    name="sku" id="sku" required>
            </div>

            <div class="col-span-1 sm:col-span-2 lg:col-span-1">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" id="category_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-1 sm:col-span-2 lg:col-span-1">
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    name="quantity" id="quantity" required>
            </div>

            <div class="col-span-1 sm:col-span-2 lg:col-span-1">
                <label for="unit" class="block text-sm font-medium text-gray-700">Unit</label>
                <input type="text"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    name="unit" id="unit" required>
            </div>

            <div class="col-span-1 sm:col-span-2 lg:col-span-1">
                <label for="reorder_level" class="block text-sm font-medium text-gray-700">Reorder Level</label>
                <input type="number"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    name="reorder_level" id="reorder_level" required>
            </div>

            <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                <button type="submit" class="w-full px-6 py-3 bg-green-500 text-white rounded-md hover:bg-green-600">
                    Save Product
                </button>
            </div>
        </form>
    </div>
</x-layout>