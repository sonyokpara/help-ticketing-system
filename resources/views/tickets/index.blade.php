<x-app-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <form action="{{route('ticket.create')}}" method="get" class="mb-4">
            <x-primary-button>Create Ticket</x-primary-button>
        </form>
        <h1 class="text-gray-800 text-lg font-bold">All Help Ticket</h1>
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            @foreach ($tickets as $ticket)
                <div class="flex justify-between space-y-5">
                    <a href="{{route('ticket.show', $ticket->id)}}">{{$ticket->title}}</a>
                    @if ($ticket->attachments)
                        <a href="{{'/storage/'.$ticket->attachments}}" target="_blank">Attachment</a>
                    @endif
                    <p>{{$ticket->created_at->diffForHumans()}}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
