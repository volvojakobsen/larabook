<x-layout>
<x-slot:heading>
        Login
    </x-slot:heading>

<form method="POST" action="/login">
    @csrf
  <div class="space-y-12">
        <div class="sm:col-span-3">
          <x-form-label for="email">email</x-form-label>
          <div class="mt-2">
            <x-form-input  type="email" name="email" id="email" placeholder="Ola-Roger@mail.com"  />
          </div>
          <x-form-error name="email" />
        </div>
 
      <div class="sm:col-span-3">
          <x-form-label for="password" class="block text-sm/6 font-medium text-gray-900">Password</x-form-label>
          <div class="mt-2">
            <x-form-input type="password" name="password" id="password" />
          </div>
          <x-form-error name="password" />
        </div>
    </div>
    <div class="mt-6 flex items-center justify-start  gap-x-6">
    <a href="/" class="text-sm/6 font-semibold text-gray-900">Cancel</a>
    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Login</button>
  </div>
  </div>

  
</form>

</x-layout>