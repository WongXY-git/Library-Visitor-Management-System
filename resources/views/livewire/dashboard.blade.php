<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Search and Filter Section -->
                    <div class="mb-6">
                        <div class="flex space-x-4">
                            <div class="flex-1">
                                <input 
                                    wire:model.live="search"
                                    type="search"
                                    class="w-full rounded-md bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                                    placeholder="Search by name, card number, or ID..."
                                />
                            </div>
                            <x-secondary-button class="px-4 py-2">
                                {{ __('Filter') }}
                            </x-secondary-button>
                        </div>
                    </div>

                    <!-- Visitors Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($visitors as $visitor)
                            <x-visitor-photo-card 
                                :name="$visitor->name"
                                :visitor-id="$visitor->id"
                            />
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                        @if($visitors->onFirstPage())
                            <span class="text-gray-400 dark:text-gray-600">Previous</span>
                        @else
                            <button wire:click="previousPage" class="hover:text-gray-700 dark:hover:text-gray-300">Previous</button>
                        @endif

                        <span>Page {{ $visitors->currentPage() }} of {{ $visitors->lastPage() }}</span>

                        @if($visitors->hasMorePages())
                            <button wire:click="nextPage" class="hover:text-gray-700 dark:hover:text-gray-300">Next</button>
                        @else
                            <span class="text-gray-400 dark:text-gray-600">Next</span>
                        @endif
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>