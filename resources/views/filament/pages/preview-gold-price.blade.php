<x-filament::page>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">@lang('messages.preview_gold_price')</h2>

        <x-filament::button
            tag="a"
            href="{{ url('prices/gold-prices') }}"
            color="primary"
            icon="heroicon-o-eye"
        >
            @lang('messages.preview_items', ['items' => trans('messages.gold_prices')])
        </x-filament::button>
    </div>

    {{ $this->table }}
</x-filament::page>
