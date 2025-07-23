<x-layout>
    <x-slot:heading>
    {{ $Venue->name }}
        <div class="flex flex-row gap-3">
       
        @if (Auth::check() && Auth::user()->isVenueAdmin && Auth::user()->id === $Venue->user_id)
        <x-editVenue-button href="/venue/edit/{{$Venue->id}}">Edit Venue</x-editVenue-button>
        <form action="/venue/{{$Venue->id}}" method="POST">
            @csrf
            @method('DELETE')
            <x-delete-button type="submit">Delete Venue</x-delete-button>
        </form>
        @endif
        </div>
    </x-slot:heading>
    <Venue />
</x-layout>