<x-app-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <h1 class="text-gray-800 text-lg font-bold">{{$ticket->title}}</h1>
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex justify-between">
                <p>{{$ticket->description}}</p>
                @if ($ticket->attachments)
                    <a href="{{'/storage/'.$ticket->attachments}}" target="_blank">Attachment</a>
                @endif
                <p>{{$ticket->created_at->diffForHumans()}}</p>
                
            </div>
            <div class="flex mt-1 mb-4">
                <form action="{{route('ticket.edit', $ticket->id)}}" method="get">
                    <x-primary-button>Edit</x-primary-button>
                </form>
                <form class="ml-3" action="{{route('ticket.destroy', $ticket->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <x-primary-button>Delete</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
