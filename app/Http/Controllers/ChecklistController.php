<?php

namespace App\Http\Controllers;
use App\Models\Checklist;
use Illuminate\Http\Request;
use App\Models\ChecklistItem;
use App\Models\ChecklistSubitem;
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
            'description' => 'nullable|string',
        ]);

        $checklist = Checklist::findOrFail($checklistId);

        $item = $checklist->items()->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return back()->with('success', 'Item created successfully!');
    }

    public function destroy($id)
    {
        $checklist = Checklist::findOrFail($id);
        $checklistItems = $checklist->items();
        foreach ($checklistItems as $item) {
            $item->delete();
        }
        $checklist->delete();

        return redirect()->route('dashboard')->with('success', 'Checklist deleted successfully!');
    }

    public function destroyItem($checklistId, $itemId)
    {
        $item = ChecklistItem::findOrFail($itemId);
        $item->delete();

        return back()->with('success', 'Item deleted successfully!');
    }

    public function showSubitems($checklistId, $itemId)
    {
        $checklist = Checklist::findOrFail($checklistId);
        $item = ChecklistItem::findOrFail($itemId);
        return view('checklists.subitems.show', compact('checklist', 'item'));
    }

    public function storeSubitem(Request $request, $checklistId, $itemId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $item = ChecklistItem::findOrFail($itemId);

        $subitem = $item->subItems()->create([
            'name' => $request->input('name'),
        ]);

        return back()->with('success', 'Subitem created successfully!');
    }

    public function toggleSubitem($checklistId, $itemId, $subitemId)
    {
        $subitem = ChecklistSubitem::findOrFail($subitemId);
        $subitem->update(['completed' => !$subitem->completed]);

        return back()->with('success', 'Subitem updated successfully!');
    }

    public function destroySubitem($checklistId, $itemId, $subitemId)
    {
        $subitem = ChecklistSubitem::findOrFail($subitemId);
        $subitem->delete();

        return back()->with('success', 'Subitem deleted successfully!');
    }
}

