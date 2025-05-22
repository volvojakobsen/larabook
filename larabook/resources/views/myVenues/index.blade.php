<x-layout>
    <x-slot:heading>
        My Venues & products
        <div>
            <a href="/venue/create">
                <x-add-button>Add venue</x-add-button>
            </a>
            <a href="/products/create">
                <x-add-button>Add Product</x-add-button>
            </a>
        </div>
    </x-slot:heading>
    <div class="text-center my-10">
        <h3 class="text-4xl font-bold text-gray-800">Venues</h3>
        <div class="mt-2 h-1 w-16 bg-blue-500 mx-auto rounded-full"></div>
    </div>

    <div>
        <My-Venues><My-Venues />
    </div>
    <div class="text-center my-10">
        <h3 class="text-4xl font-bold text-gray-800">Products</h3>
        <div class="mt-2 h-1 w-16 bg-blue-500 mx-auto rounded-full"></div>
    </div>

    <List-Products />
</x-layout>