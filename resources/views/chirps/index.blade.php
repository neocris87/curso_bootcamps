<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chirps') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @session('success')
                        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 mb-2 shadow-md"
                            role="alert">
                            <div class="flex">
                                <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path
                                            d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                                    </svg></div>
                                <div>
                                    <p class="font-bold">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endsession

                    <form method="POST" action="{{ route('chirps.store') }}">
                        @csrf
                        <textarea name="message" placeholder="{{ __('What\'s on your mind?') }}"
                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm text-black ">{{ old('message') }}</textarea>
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                        <x-primary-button type='submit' class="mt-4">{{ __('Chirp') }}</x-primary-button>
                    </form>

                    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">

                        @foreach ($chirps as $chirp)
                            <div class="p-6 flex space-x-2">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />

                                </svg>

                                <div class="flex-1">

                                    <div class="flex justify-between items-center">

                                        <div>

                                            <span class="text-gray-800">{{ $chirp->user->name }}</span>

                                            <small
                                                class="ml-2 text-sm text-gray-600">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>

                                            @unless ($chirp->created_at->eq($chirp->updated_at))
                                                <small class="text-sm text-gray-600"> &middot; {{ __('Editado') }}</small>
                                            @endunless

                                        </div>


                                        @can ('update', $chirp)
                                            <x-dropdown>
                                                <x-slot name="trigger">
                                                    <button>
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-4 w-4 text-gray-400" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path
                                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />

                                                        </svg>
                                                    </button>
                                                </x-slot>

                                                <x-slot name="content">
                                                    <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                                        {{ __('Editar') }}
                                                    </x-dropdown-link>

                                                    <form method="POST" action="{{ route('chirps.destroy' , $chirp) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-dropdown-link  :href="route('chirps.destroy', $chirp)"  onclick="event.preventDefault(); this.closest('form').submit();">
                                                            {{ __('Eliminar') }}
                                                        </x-dropdown-link>
                                                    </form>

                                                </x-slot>
                                            </x-dropdown>

                                        @endcan

                                    </div>

                                    <p class="mt-4 text-lg text-gray-900 whitespace-pre-line">{{ $chirp->message }}</p>


                                </div>

                            </div>
                        @endforeach



                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
