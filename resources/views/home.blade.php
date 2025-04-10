<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-200">
        <h3 class="text-2xl font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
            To-Do List
        </h3>
        <ul class="list-disc pl-5 space-y-3">
            <li class="text-gray-700">
                Implement user roles and permissions
            </li>
        </ul>
    </div>

</x-layout>