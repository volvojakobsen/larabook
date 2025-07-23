<x-layout>
    <x-slot:heading>
        Profile
    </x-slot:heading>

    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-2xl mt-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    {{ $user->first_name }} {{ $user->last_name }}
                </h1>
                <p class="text-gray-500 text-sm">{{ $user->email }}</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <span class="inline-block px-4 py-2 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                    {{ $user->company }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <h2 class="text-sm text-gray-600">Address</h2>
                <p class="text-gray-900">{{ $user->address }}</p>
            </div>

            <div>
                <h2 class="text-sm text-gray-600">City</h2>
                <p class="text-gray-900">{{ $user->city }}</p>
            </div>

            <div>
                <h2 class="text-sm text-gray-600">Postal Code</h2>
                <p class="text-gray-900">{{ $user->postal }}</p>
            </div>

            <div>
                <h2 class="text-sm text-gray-600">Phone</h2>
                <p class="text-gray-900">{{ $user->phone }}</p>
            </div>
        </div>
    </div>
</x-layout>