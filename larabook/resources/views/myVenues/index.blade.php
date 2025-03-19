<x-layout>
    <x-slot:heading>
        My Venues & products 
        <div>
            <a href="/venue/create">
            <x-add-button>Add venue</x-add-button>
            </a>
            <a href="/products/create">
            <x-add-button >Add Product</x-add-button>
            </a>
        </div>
    </x-slot:heading>
    <h3 class="text-center m-6">Venues</h3>
    <div>
    <My-Venues><My-Venues />
    </div>
    <h3 class="text-center m-6">Products</h3>
    <List-Products />
</x-layout>