<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('User Avatar') }}
        </h2>

    </header>
    <img width="50" height="50" class="rounded-full" src="{{asset("/storage/$user->avatar")}}" alt="user avatar">

    <form action="{{route('profile.avatar.ai')}}" method="post" class="mt-4">
        @csrf
        <p class="mb-1 text-sm text-gray-600 dark:text-gray-400">Generate avatar from AI</p>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Generate') }}</x-primary-button>
        </div>

    </form>

    <form method="post" action="{{route('update.avatar')}}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div>
            OR
            <x-input-label for="avatar" :value="__('Upload avatar from your computer')" />
            <x-text-input id="avatar" name="avatar" type="file" class="mt-1 block w-full" :value="old('avatar', $user->avatar)" required autofocus autocomplete="avatar" />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
