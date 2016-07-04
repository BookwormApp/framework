<table class="table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Event</th>
            <th>User</th>
        </tr>
    </thead>
    <tbody>
    @foreach ( $logs as $log )
        <tr>
            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
            <td>
                @include('logs.events.'.$log->event)
            </td>
            <td>
                @if ( $log->user )
                    {{ $log->user->name }}
                    ({{ $log->user->email }})
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
