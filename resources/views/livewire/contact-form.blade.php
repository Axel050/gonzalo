<form wire:submit.prevent="submit" class="space-y-4 max-w-xl mx-auto">

    <div>
        <input type="text" wire:model.defer="name" placeholder="Nombre"
            class="w-full border px-4 py-2 rounded-lg bg-casa-base-2" />
        @error('name')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>


    <div>
        <input type="email" wire:model.defer="email" placeholder="Email"
            class="w-full border px-4 py-2 rounded-lg bg-casa-base-2" />
        @error('email')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <textarea wire:model.defer="message" placeholder="Mensaje" rows="4"
            class="w-full border px-4 py-2 rounded-lg bg-casa-base-2"></textarea>
        @error('message')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>


    <div>
        <div wire:ignore class="relative mt-3 lg:col-span-2  mx-auto ">
            <div id="g-recaptcha" class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"
                data-callback="onRecaptchaSuccess" data-expired-callback="onRecaptchaExpired"></div>
        </div>
        @error('g_recaptcha_response')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>


    <button type="submit" class="bg-casa-black text-white px-6 py-2 rounded-full font-bold">
        Enviar consulta
    </button>

    @if (session()->has('success'))
        <p class="text-green-600 text-sm mt-3 text-center">
            {{ session('success') }}
        </p>
    @endif



    @push('captcha')
        <script>
            function onRecaptchaSuccess(token) {
                @this.set('g_recaptcha_response', token);
            }

            function onRecaptchaExpired() {
                @this.set('g_recaptcha_response', '');
            }
        </script>
    @endpush




</form>
