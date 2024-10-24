<x-filament-widgets::widget>
    <x-filament::section>
        <div class="text-center">
            @if (isset(Auth::user()->area_id))
                <span>Pertenezco a <b>{{ Auth::user()->area->name }}</b></span>
            @else
                <span>Primero tiene que tener un área asignada</span>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
