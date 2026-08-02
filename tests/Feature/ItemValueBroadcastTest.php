<?php

use App\Events\ItemValueUpdated;
use App\Models\Item;
use Illuminate\Support\Facades\Event;

test('updating an item value broadcasts an event', function () {
    $item = Item::factory()->create(['value' => 10]);
    Event::fake(ItemValueUpdated::class);

    $item->update(['value' => 20]);

    Event::assertDispatched(ItemValueUpdated::class, fn (ItemValueUpdated $event) => $event->item->is($item) && $event->item->value === 20);
});

test('updating an item without changing its value does not broadcast', function () {
    $item = Item::factory()->create(['value' => 10, 'name' => 'Original']);
    Event::fake(ItemValueUpdated::class);

    $item->update(['name' => 'Renamed']);

    Event::assertNotDispatched(ItemValueUpdated::class);
});

test('the update endpoint updates the item value', function () {
    $item = Item::factory()->create(['value' => 10]);

    $response = $this->patch(route('items.update', $item), ['value' => 42]);

    $response->assertRedirect(route('items.index'));
    expect($item->fresh()->value)->toBe(42);
});
