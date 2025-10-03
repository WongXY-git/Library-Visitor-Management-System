<?php

use App\Models\SenseVisitor;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\Volt\Component;

new class extends Component {
    use WithPagination;

    public string $search = '';
    
    // Dummy data for development
    #[Computed]
    public function visitors()
    {
        return [
            [
                'id' => '123456789',
                'name' => 'John Doe',
                'card_no' => 'V12345',
                'sense_id' => '987654',
                'photo' => null,
            ],
            [
                'id' => '987654321',
                'name' => 'Jane Smith',
                'card_no' => 'V67890',
                'sense_id' => '123456',
                'photo' => null,
            ]
        ];
    }
}; ?>

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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Search and Filter Section -->
                    <div class="mb-6">
                        <div class="flex space-x-4">
                            <div class="flex-1">
                                <x-text-input 
                                    wire:model.live="search"
                                    type="search"
                                    class="w-full"
                                    placeholder="Search by name, card number, or ID..."
                                />
                            </div>
                            <x-secondary-button>
                                {{ __('Filter') }}
                            </x-secondary-button>
                        </div>
                    </div>

                    <!-- Visitors Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($this->visitors as $visitor)
                            <x-visitor-photo-card 
                                :name="$visitor['name']"
                                :visitor-id="$visitor['id']"
                                :photo-url="$visitor['photo']"
                                editable
                            />
                        @endforeach
                    </div>

                    <!-- Pagination Placeholder -->
                    <div class="mt-6">
                        <nav class="flex justify-between items-center">
                            <button class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 disabled:opacity-50">
                                Previous
                            </button>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                Page 1 of 1
                            </span>
                            <button class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 disabled:opacity-50">
                                Next
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
