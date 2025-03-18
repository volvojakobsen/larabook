<x-layout>
    <x-slot:heading>
        My Venues & products 
        <x-nav-link href="/venue/create">Add venue</x-nav-link>
        <x-nav-link href="/products/create">Add Product</x-nav-link>
    </x-slot:heading>
    <h3 class="text-center m-6">Venues</h3>
    <div>
    <My-Venues><My-Venues />
    </div>
    <h3 class="text-center m-6">Products</h3>
    <List-Products />
</x-layout>