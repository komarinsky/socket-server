<?php

namespace App\Observers;

use App\Events\ItemValueUpdated;
use App\Models\Item;

class ItemObserver
{
    /**
     * Handle the Item "updated" event.
     */
    public function updated(Item $item): void
    {
        if ($item->wasChanged('value')) {
            event(new ItemValueUpdated($item));
        }
    }
}
