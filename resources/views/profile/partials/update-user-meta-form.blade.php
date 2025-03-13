<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update User Meta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update your account\'s user meta information.') }}
        </p>

        <x-error-form :error="$errors"></x-error-form>
    </header>

    <form method="post" action="{{ route('admin.user_meta.update', $user->id) }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_user_meta_address" :value="__('Address')" />
            <x-text-input id="update_user_meta_address" name="meta_key[address]" type="text" class="mt-1 block w-full"
                autocomplete="address"
                value="{{ old('meta_key.address', $user->meta->where('meta_key', 'address')->first()?->meta_value) }}" />

        </div>

        <div>
            <x-input-label for="update_user_meta_phone" :value="__('Phone')" />
            <x-text-input id="update_user_meta_phone" name="meta_key[phone]" type="text" class="mt-1 block w-full"
                autocomplete="phone"
                value="{{ old('meta_key.phone', $user->meta->where('meta_key', 'phone')->first()?->meta_value) }}" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
