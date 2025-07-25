<x-layout>
<x-slot:heading>
        Add A New Product
    </x-slot:heading>

<form method="POST" action="/products/store" enctype="multipart/form-data">
    @csrf
  <div class="space-y-12">

    <div class="border-b border-gray-900/10 pb-12">

      <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-3">
          <x-form-label for="title">Title</x-form-label>
          <div class="mt-2">
            <x-form-input  name="title" id="title" placeholder="Catering" />
          </div>
          <x-form-error name="title" />
        </div>

        

        
      
      <div class="sm:col-span-4">
          <x-form-label for="price" >Price</x-form-label>
          <div class="mt-2">
            <x-form-input id="price" name="price" type="number" placeholder="100$"/>
            <x-form-error name="price" />
          </div>
      </div>


        <div class="sm:col-span-3">
          <x-form-label for="description" class="block text-sm/6 font-medium text-gray-900">Description</x-form-label>
          <div class="mt-2">
            <x-form-input type="textarea" name="description" id="description" placeholder="A short description of the product" />
          </div>
          <x-form-error name="description" />
        </div>
    </div>

    

    

    
  </div>

  <div class="mt-6 flex items-center justify-end gap-x-6">
    <a href="/" class="text-sm/6 font-semibold text-gray-900">Cancel</a>
    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add</button>
  </div>
</form>

</x-layout>