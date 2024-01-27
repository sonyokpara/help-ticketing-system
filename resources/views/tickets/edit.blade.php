<x-app-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <h1 class="text-gray-800 text-lg font-bold">Update Ticket</h1>
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('ticket.update', $ticket->id) }}" enctype="multipart/form-data">
                @method('patch')
                @csrf
        
                <!-- Title -->
                <div>
                    <x-input-label for="email" :value="__('Title')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{$ticket->title}}"  autofocus autocomplete="title" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
        
                <!-- Description -->
                <div class="mt-4">
                    <x-input-label for="description" :value="__('Description')" />
                    <x-textarea-input id="description" name="description" autofocus autocomplete="description" value="{{$ticket->description}}"/>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
        
                <!-- Attachment -->
                <div class="block mt-4">
                    @if($ticket->attachments)
                        <a href="{{'/storage/'.$ticket->attachment}}" target="_blank">See Attachment</a>
                    @endif
                    <x-input-label for="attachment" :value="__('Attachment (if any)')" />
                    <x-file-input name="attachment" id="attachment"/>
                    <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
        
                </div>
        
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-3">
                        {{ __('Update Ticket') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>