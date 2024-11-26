<x-layout>
<x-slot:heading>
        Register
    </x-slot:heading>

<form method="POST" action="/register">
    @csrf
  <div class="space-y-12">

    <div class="border-b border-gray-900/10 pb-12">
      <h2 class="text-base/7 font-semibold text-gray-900">Personal Information</h2>
      <p class="mt-1 text-sm/6 text-gray-600">Use a permanent address where you can receive mail.</p>

      <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-3">
          <x-form-label for="first-name">First name</x-form-label>
          <div class="mt-2">
            <x-form-input  name="first-name" id="first-name" placeholder="Ola-Roger" />
          </div>
          <x-form-error name="first-name" />
        </div>

        <div class="sm:col-span-3">
          <x-form-label for="last-name" class="block text-sm/6 font-medium text-gray-900">Last name</x-form-label>
          <div class="mt-2">
            <x-form-input name="last-name" id="last-name" placeholder="Nordmann" />
          </div>
          <x-form-error name="last-name" />
        </div>

        <div class="sm:col-span-3">
          <x-form-label for="email">email</x-form-label>
          <div class="mt-2">
            <x-form-input  type="email" name="email" id="email" placeholder="Ola-Roger@mail.com"  />
          </div>
          <x-form-error name="email" />
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
          <x-form-label for="postal-code">Postal Code</x-form-label>
          <div class="mt-2">
            <x-form-input name="postal-code" id="postal-code" placeholder="8450" />
          </div>
          <x-form-error name="postal-code" />
        </div>

        <div class="sm:col-span-4">
          <x-form-label for="company">Company name (optional)</x-form-label>
          <div class="mt-2">
            <x-form-input id="company" name="company" type="company" placeholder="Big Pharma"/>
            <x-form-error name="company" />
          </div>
      </div>

        
      
      <div class="sm:col-span-4">
          <x-form-label for="phone" >Phone Number</x-form-label>
          <div class="mt-2">
            <x-form-input id="phone" name="phone" type="phone" placeholder="+47 800-55-800"/>
            <x-form-error name="phone" />
          </div>
      </div>
      <div class="sm:col-span-3">
          <x-form-label for="password" class="block text-sm/6 font-medium text-gray-900">Password</x-form-label>
          <div class="mt-2">
            <x-form-input type="password" name="password" id="password" />
          </div>
          <x-form-error name="password" />
        </div>

        <div class="sm:col-span-3">
          <x-form-label for="password_confirmation" class="block text-sm/6 font-medium text-gray-900">Password Confirmation</x-form-label>
          <div class="mt-2">
            <x-form-input type="password" name="password_confirmation" id="password_confirmation" />
          </div>
          <x-form-error name="password_confirmation" />
        </div>
    </div>

    

    

    
  </div>

  <div class="mt-6 flex items-center justify-end gap-x-6">
    <a href="/" class="text-sm/6 font-semibold text-gray-900">Cancel</a>
    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register</button>
  </div>
</form>

</x-layout>