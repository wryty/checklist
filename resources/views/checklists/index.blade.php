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
                        <div class="mb-4 border-b border-gray-300 pb-2">
                            <div class="flex justify-between items-center">
                                <a href="{{ route('checklists.show', $checklist->id) }}" class="text-blue-500 hover:underline">
                                    <i class="fas fa-list-alt"></i> {{ $checklist->name }} - {{ $checklist->description }}
                                </a>
                                <form action="{{ route('checklists.destroy', $checklist->id) }}" method="post" class="inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="text-red-500 hover:underline ml-2">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                                <button class="toggle-checklist text-gray-500" data-checklist-id="{{ $checklist->id }}">
                                    Подробнее
                                </button>
                            </div>
                            <div class="checklist-items hidden pl-6" id="checklist-{{ $checklist->id }}">
                                @forelse($checklist->items as $item)
                                    <div class="mb-2 flex items-center">
                                        <form action="{{ route('checklists.toggleItem', $item->id) }}" method="post">
                                            @csrf
                                            <input type="checkbox" {{ $item->completed ? 'checked' : '' }} class="checkbox-toggle mr-2"
                                                   data-item-id="{{ $item->id }}" data-checklist-id="{{ $checklist->id }}" onchange="this.form.submit()">
                                        </form>
                                        <span class="{{ $item->completed ? 'line-through text-gray-500' : 'text-black font-semibold' }}">{{ $item->name }}</span>
                                        <span class="text-gray-600 ml-2">{{ $item->description }}</span>
                                        <form action="{{ route('checklists.items.destroy', [$checklist->id, $item->id]) }}" method="post" class="ml-auto">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="text-red-500 ml-2">Delete</button>
                                        </form>

                                        <button class="toggle-subitems text-gray-500 ml-2" data-item-id="{{ $item->id }}" data-checklist-id="{{ $checklist->id }}">
                                            Подробнее
                                        </button>
                                    </div>

                                    <div class="subitems hidden pl-8" id="subitems-{{ $checklist->id }}-{{ $item->id }}">
                                        <p class="text-white">Description: </p> {!! $item->description !!}
                                        @forelse($item->subItems as $subitem)
                                            <div class="mb-2 flex items-center">
                                                <form action="{{ route('checklists.items.subitems.toggle', [$checklist->id, $item->id, $subitem->id]) }}" method="post">
                                                    @csrf
                                                    <input type="checkbox" {{ $subitem->completed ? 'checked' : '' }} class="subitem-toggle mr-2" onchange="this.form.submit()">
                                                </form>
                                                <span class="{{ $subitem->completed ? 'line-through text-gray-500' : 'text-black font-semibold' }}">{{ $subitem->name }}</span>
                                                <span class="text-gray-600 ml-2">{{ $subitem->description }}</span>
                                                <form action="{{ route('checklists.items.subitems.destroy', [$checklist->id, $item->id, $subitem->id]) }}" method="post" class="ml-auto">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="text-red-500 ml-2">Delete</button>
                                                </form>
                                            </div>
                                        @empty
                                            <p class="text-gray-600 ml-8">No subitems available.</p>
                                        @endforelse
                                    </div>
                                @empty
                                    <p class="text-gray-600 ml-6">No items available.</p>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <p>No checklists available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let activeChecklistId = localStorage.getItem('activeChecklistId');
            let checklistStates = JSON.parse(localStorage.getItem('checklistStates')) || {};

            if (activeChecklistId && checklistStates[activeChecklistId]) {
                let activeChecklistItems = document.getElementById("checklist-" + activeChecklistId);
                if (activeChecklistItems) {
                    let activeChecklistDescription = activeChecklistItems.previousElementSibling;

                    activeChecklistItems.classList.remove("hidden");
                    activeChecklistDescription.classList.remove("hidden");
                }
            }

            document.querySelectorAll(".toggle-checklist").forEach(function (button) {
                button.addEventListener("click", function () {
                    let checklistId = this.getAttribute("data-checklist-id");
                    let checklistItems = document.getElementById("checklist-" + checklistId);

                    localStorage.setItem('activeChecklistId', checklistId);

                    if (checklistItems) {
                        checklistItems.classList.toggle("hidden");
                    }

                    checklistStates[checklistId] = checklistItems ? !checklistItems.classList.contains("hidden") : false;

                    let areAllChecklistsClosed = !Object.values(checklistStates).includes(true);

                    if (areAllChecklistsClosed) {
                        localStorage.removeItem('activeChecklistId');
                    }

                    localStorage.setItem('checklistStates', JSON.stringify(checklistStates));
                });
            });

            document.querySelectorAll(".toggle-subitems").forEach(function (button) {
                button.addEventListener("click", function () {
                    let checklistId = this.getAttribute("data-checklist-id");
                    let itemId = this.getAttribute("data-item-id");
                    let subitems = document.getElementById("subitems-" + checklistId + "-" + itemId);

                    if (subitems) {
                        subitems.classList.toggle("hidden");
                    }
                });
            });

            document.querySelectorAll(".checkbox-toggle").forEach(function (checkbox) {
                checkbox.addEventListener("change", function (event) {
                    event.preventDefault();

                    let itemId = this.getAttribute("data-item-id");
                    let checklistId = this.getAttribute("data-checklist-id");
                    let isChecked = this.checked;

                    if (typeof jQuery !== 'undefined') {
                        $.ajax({
                            url: '/checklists/' + checklistId + '/items/' + itemId + '/toggle',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                completed: isChecked
                            },
                            success: function (response) {
                                console.log('Item state updated successfully.');
                            },
                            error: function (error) {
                                console.error('Error updating item state:', error);
                            }
                        });
                    } else {
                        console.error('jQuery is not loaded. Make sure it is included in your project.');
                    }
                });
            });
        });
    </script>
</x-app-layout>
