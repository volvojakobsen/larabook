<x-layout>
<x-slot:heading>
        Edit Venue
    </x-slot:heading>

<form method="POST" action="/venue/update" enctype="multipart/form-data">
    @csrf
  <div class="space-y-12">

    <div class="border-b border-gray-900/10 pb-12">

      <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-3">
          <x-form-label for="name">Name</x-form-label>
          <div class="mt-2">
            <x-form-input  name="name" id="name" placeholder="Telefjord-Arena" />
          </div>
          <x-form-error name="name" />
        </div>

        

        <div class="sm:col-span-3">
          <x-form-label for="address" >Address</x-form-label>
          <div class="mt-2">
            <x-form-input name="address" id="address" placeholder="Havnegata 24" />
          </div>
          <x-form-error name="address" />
        </div>

        <div class="sm:col-span-3">
          <x-form-label for="city">city</x-form-label>
          <div class="mt-2">
            <x-form-input name="city" id="city" placeholder="Stokmarknes" />
          </div>
          <x-form-error name="city" />
        </div>

        <div class="sm:col-span-3">
          <x-form-label for="postal">Postal Code</x-form-label>
          <div class="mt-2">
            <x-form-input name="postal" id="postal" placeholder="8450" />
          </div>
          <x-form-error name="postal" />
        </div>

        
      
      <div class="sm:col-span-4">
          <x-form-label for="price" >Price</x-form-label>
          <div class="mt-2">
            <x-form-input id="price" name="price" type="price" placeholder="+47 800-55-800"/>
            <x-form-error name="price" />
          </div>
      </div>
      <div class="sm:col-span-3">
          <x-form-label for="image" class="block text-sm/6 font-medium text-gray-900">Image</x-form-label>
          <div class="mt-2">
            <x-form-input type="file" name="image" id="image" />
          </div>
          <x-form-error name="image" />
        </div>

        <div class="sm:col-span-3">
          <x-form-label for="description" class="block text-sm/6 font-medium text-gray-900">Description</x-form-label>
          <div class="mt-2">
            <x-form-input type="textarea" name="description" id="description" />
          </div>
          <x-form-error name="description" />
        </div>
    </div>

    

    

    
  </div>

  <div class="mt-6 flex items-center justify-end gap-x-6">
    <a href="/" class="text-sm/6 font-semibold text-gray-900">Cancel</a>
    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register</button>
  </div>
</form>

</x-layout>