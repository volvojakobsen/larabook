<x-layout>
<x-slot:heading>
        Home
    </x-slot:heading>
    <h1 class="">Home page</h1>
    <x-nav-link href="/venue/create" >Add venue</x-nav-link>
{{ $Venue->name }}
</x-layout>