<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateItemValueRequest;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(): View
    {
        return view('items.index', [
            'items' => Item::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateItemValueRequest $request, Item $item): RedirectResponse
    {
        $item->update($request->validated());

        return redirect()->route('items.index');
    }
}
