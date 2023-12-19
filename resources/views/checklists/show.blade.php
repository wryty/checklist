<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ $checklist->name }}
        </h2>
        <p class="text-white dark:text-gray-300">{{ $checklist->description }}</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-4 text-white">{{ __("Items") }}</h3>

                @forelse($checklist->items as $item)
                    <div class="mb-2 flex items-center">
                        <form action="{{ route('checklists.toggleItem', $item->id) }}" method="post">
                            @csrf
                            <input type="checkbox" {{ $item->completed ? 'checked' : '' }} onchange="this.form.submit()" class="mr-2">
                        </form>
                        <span class="{{ $item->completed ? 'line-through text-gray-500' : 'text-white' }}">{{ $item->name }}</span>
                        <form action="{{ route('checklists.items.destroy', [$checklist->id, $item->id]) }}" method="post" class="ml-auto">
                            @csrf
                            @method('delete')
                            <button type="submit" class="text-2xl text-white  ml-2">Delete</button>
                        </form>
                    </div>
                @empty
                    <p class="text-white">No items available.</p>
                @endforelse

                <hr class="my-4">

                <h3 class="text-2xl font-bold mb-4 text-white">{{ __("Create Item") }}</h3>
                <form action="{{ route('checklists.items.store', $checklist->id) }}" method="post" class="mb-4">
                    @csrf
                    <div class="flex">
                        <input type="text" id="item_name" name="name" required class="mr-2 flex-1 p-2 border border-gray-300 dark:border-gray-600 rounded-md">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
