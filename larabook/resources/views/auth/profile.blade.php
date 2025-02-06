<x-layout>
<x-slot:heading>
        Home
    </x-slot:heading>
    <h1 class="">Home page</h1>
    <x-nav-link href="/venue/create" >Add venue</x-nav-link>
    <h1>hello {{ $user->first_name }} {{ $user->last_name }}</h1>
    <h2>{{$user->address}}</h2>
    <h2>{{$user->city}}</h2>
    <h2>{{$user->postal}}</h2>
    <h2>{{$user->company}}</h2>
    <h2>{{$user->phone}}</h2>
    <h2>{{$user->email}}</h2>
</x-layout>