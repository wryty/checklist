<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Checklist') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('checklists.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Checklist Name:</label>
                        <input type="text" id="name" name="name" required class="mt-1 p-2 block w-full border border-gray-300 dark:border-gray-600 rounded-md">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description:</label>
                        <textarea id="description" name="description" rows="4" class="mt-1 p-2 block w-full border border-gray-300 dark:border-gray-600 rounded-md"></textarea>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-full">Create Checklist</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
