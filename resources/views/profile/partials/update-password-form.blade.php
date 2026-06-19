
        <h2>
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" :value="__('Current Password')" />
            <input id="current_password"  class="form-control" name="current_password" type="password" autocomplete="current-password" />
        </div>

        <div>
            <x-input-label for="password" :value="__('New Password')" />
            <input id="password" name="password" type="password" class="form-control" autocomplete="new-password" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
        </div>
<br>
        <div class="text-center gap-4">
            <button class="btn btn-warning">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

