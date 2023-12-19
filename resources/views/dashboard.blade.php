<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-4">{{ __("Checklists") }}</h3>
                <ul class="list-group mb-4">
                    @foreach($checklists as $checklist)
                        <li class="list-group-item mb-2">
                            <a href="{{ route('checklists.show', $checklist->id) }}" class="text-blue-500">{{ $checklist->name }}</a>
                        </li>
                    @endforeach
                </ul>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createChecklistModal">
                    Create Checklist
                </button>

                <div class="modal fade" id="createChecklistModal" tabindex="-1" aria-labelledby="createChecklistModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createChecklistModalLabel">Create Checklist</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('checklists.store') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="checklist_name" class="form-label">Checklist Name:</label>
                                        <input type="text" id="checklist_name" name="name" required class="form-control">
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Create Checklist</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
