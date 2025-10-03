<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Library Visitor Management') }}
            </h2>
            <div class="flex space-x-4">
                <x-secondary-button wire:click="refresh">
                    {{ __('Sync Data') }}
                </x-secondary-button>
            </div>
        </div>
    </x-slot>

    <livewire:dashboard />
</x-app-layout>
