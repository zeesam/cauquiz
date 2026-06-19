    <h2>Update Your Login Details</h2>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            Full Name
            <input id="name" name="name" type="text" class="form-control" value="{{Auth::user()->name}}" name="name" required />
        </div>
        <div>
            Email
            <input id="email" name="email" type="email" class="form-control" value="{{Auth::user()->email}}" required/>
            <br>
        <div class="text-center gap-4">
            <button type="submit" class="btn btn-warning">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
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
