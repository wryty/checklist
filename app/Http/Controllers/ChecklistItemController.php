<?php

namespace App\Http\Controllers;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;

class ChecklistItemController extends Controller
{
    public function show($id)
    {
        $item = ChecklistItem::with('subItems')->find($id);

        return view('checklist-items.show', compact('item'));
    }

    public function toggleItem(Request $request, $id)
    {
        $item = ChecklistItem::find($id);
        $item->update(['completed' => !$item->completed]);

        return back();
    }
}
