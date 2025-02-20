

<x-layout>
<x-slot:heading>
        Home
    </x-slot:heading>
    @if (Auth::check() && Auth::user()->isVenueAdmin)
                                <a href="/venue/edit/1">Edit Venue</a>
    @endif
{{ $Venue->name }}
<Venue />
</x-layout>