<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight"> <!-- fixed (h1)!-->
            {{ $checklist->name }}
        </h1>
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
                        <span class="{{ $item->completed ? 'line-through text-gray-500' : 'text-white' }}">
                            {{ $item->name }} - {{ $item->description }}

                        </span>
                        <button class="toggle-subitems text-gray-500 ml-2" data-item-id="{{ $item->id }}">
                            Подробнее
                        </button>
                        <form action="{{ route('checklists.items.destroy', [$checklist->id, $item->id]) }}" method="post" class="ml-auto">
                            @csrf
                            @method('delete')
                            <button type="submit" class="text-2xl text-white  ml-2">Delete</button>
                        </form>
                    </div>
                    <div class="subitems hidden pl-6" id="subitems-{{ $checklist->id }}-{{ $item->id }}">
                        <p class="text-white">Description: </p> {!! $item->description !!}
                        @forelse(optional($item->subItems)->all() ?? [] as $subitem)
                            <div class="mb-2 flex items-center">
                                <form action="{{ route('checklists.items.subitems.toggle', [$checklist->id, $item->id, $subitem->id]) }}" method="post">
                                    @csrf
                                    <input type="checkbox" {{ $subitem->completed ? 'checked' : '' }} class="subitem-toggle mr-2" onchange="this.form.submit()">
                                </form>
                                <span class="{{ $subitem->completed ? 'line-through text-gray-500' : 'text-black' }}">{{ $subitem->name }}</span>
                                <form action="{{ route('checklists.items.subitems.destroy', [$checklist->id, $item->id, $subitem->id]) }}" method="post" class="ml-auto">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="text-red-500 ml-2">Delete</button>
                                </form>
                            </div>
                        @empty
                            <p>No subitems available.</p>
                        @endforelse
                        <hr class="my-4">
                        <h4 class="text-xl font-bold mb-2 text-white">{{ __("Create Subitem") }}</h4>
                        <form action="{{ route('checklists.items.subitems.store', [$checklist->id, $item->id]) }}" method="post">
                            @csrf
                            <div class="flex">
                                <input type="text" id="subitem_name" name="name" required class="mr-2 flex-1 p-2 border border-gray-300 dark:border-gray-600 rounded-md">
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Create Subitem</button>
                            </div>
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
                        <textarea id="item_description" name="description" class="mr-2 flex-1 p-2 border border-gray-300 dark:border-gray-600 rounded-md" placeholder="Description"></textarea>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            document.querySelectorAll(".toggle-subitems").forEach(function (button) {
                button.addEventListener("click", function () {
                    let itemId = this.getAttribute("data-item-id");
                    let checklistId = {{ $checklist->id }};
                    let subitems = document.getElementById("subitems-" + checklistId + "-" + itemId);
                    subitems.classList.toggle("hidden");
                });
            });
        });
    </script>
</x-app-layout>
