<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checklists') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">{{ __("Your Checklists") }}</h3>

                    <a href="{{ route('checklists.create') }}" class="text-green-500 hover:underline mb-4">
                        <i class="fas fa-plus-circle"></i> Create a New Checklist
                    </a>

                    @forelse($checklists as $checklist)
                        <div class="mb-4 flex justify-between items-center border-b border-gray-300 pb-2">
                            <a href="{{ route('checklists.show', $checklist->id) }}" class="text-blue-500 hover:underline">
                                <i class="fas fa-list-alt"></i> {{ $checklist->name }}
                            </a>
                            <form action="{{ route('checklists.destroy', $checklist->id) }}" method="post" class="inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="text-red-500 hover:underline ml-2">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </div>
                    @empty
                        <p>No checklists available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
