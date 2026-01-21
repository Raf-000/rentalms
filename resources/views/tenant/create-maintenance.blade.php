<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Report Maintenance Issue
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('tenant.store-maintenance') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Describe the Issue</label>
                            <textarea name="description" rows="5" required 
                                      class="w-full border-gray-300 rounded-md"
                                      placeholder="E.g., Bathroom sink is clogged, WiFi not working, light bulb broken..."></textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Upload Photo (Optional)</label>
                            <input type="file" name="photo" accept="image/*" 
                                   class="w-full border-gray-300 rounded-md">
                            <p class="text-xs text-gray-500 mt-1">Upload a photo of the issue if applicable</p>
                            @error('photo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Submit Request
                            </button>
                            <a href="{{ route('tenant.dashboard') }}" 
                               class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>