<?php

namespace App\Http\Controllers;
use App\Models\Checklist;
use Illuminate\Http\Request;
use App\Models\ChecklistItem;
class ChecklistController extends Controller
{

    public function index()
    {
        $checklists = Checklist::where('user_id', auth()->id())->get();
        return view('checklists.index', compact('checklists'));
    }
    public function create()
    {
        return view('checklists.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $checklist = Checklist::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('checklists.show', $checklist->id)
            ->with('success', 'Checklist created successfully!');
    }


    public function show($id)
    {
        $checklist = Checklist::findOrFail($id);
        return view('checklists.show', compact('checklist'));
    }

    public function toggleItem(Request $request, $id)
    {
        $item = ChecklistItem::findOrFail($id);
        $item->update(['completed' => !$item->completed]);

        return back()->with('success', 'Item updated successfully!');
    }

    public function storeItem(Request $request, $checklistId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $checklist = Checklist::findOrFail($checklistId);

        $item = $checklist->items()->create([
            'name' => $request->input('name'),
        ]);

        return back()->with('success', 'Item created successfully!');
    }

    public function destroy($id)
    {
        $checklist = Checklist::findOrFail($id);
        $checklist->delete();

        return redirect()->route('checklists.index')->with('success', 'Checklist deleted successfully!');
    }

    public function destroyItem($checklistId, $itemId)
    {
        $item = ChecklistItem::findOrFail($itemId);
        $item->delete();

        return back()->with('success', 'Item deleted successfully!');
    }
}

