<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 text-gray-900 min-h-screen p-8">
        <div class="max-w-xl mx-auto">
            <h1 class="text-2xl font-semibold mb-1">Items</h1>
            <p class="text-sm text-gray-500 mb-6">
                Values update live over WebSockets whenever they change in the database.
            </p>

            <table class="w-full border border-gray-200 rounded-md overflow-hidden bg-white">
                <thead class="bg-gray-100 text-left text-sm">
                    <tr>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Value</th>
                        <th class="px-4 py-2">Update</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr class="border-t border-gray-200" data-item-row="{{ $item->id }}">
                            <td class="px-4 py-2">{{ $item->name }}</td>
                            <td class="px-4 py-2 font-mono" data-item-value="{{ $item->id }}">{{ $item->value }}</td>
                            <td class="px-4 py-2">
                                <form method="POST" action="{{ route('items.update', $item) }}" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input
                                        type="number"
                                        name="value"
                                        value="{{ $item->value }}"
                                        class="w-24 rounded-sm border border-gray-300 px-2 py-1 text-sm"
                                    >
                                    <button type="submit" class="rounded-sm bg-gray-900 px-3 py-1 text-sm text-white">
                                        Save
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script type="module">
            window.Echo.channel('items').listen('.item.value.updated', (e) => {
                const cell = document.querySelector(`[data-item-value="${e.id}"]`);

                if (cell) {
                    cell.textContent = e.value;
                    cell.classList.add('bg-yellow-200');
                    setTimeout(() => cell.classList.remove('bg-yellow-200'), 700);
                }
            });
        </script>
    </body>
</html>