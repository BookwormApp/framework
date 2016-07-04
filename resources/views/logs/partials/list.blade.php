<ul class="list-group list-logs">
    @foreach ( $logs as $log )
   <li class="list-group-item {{ $log->getSlug() }}">
       @include('logs.events.'.$log->event)
   </li>
    @endforeach
</ul>
