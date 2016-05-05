@foreach ($notifications as $notification)
@if ($notification->unread == 'true')
<div class="row notification-item" style="background-color:#ccf2ff;border-radius:15px;" data-notification-id="{{ $notification->id }}">
@else
<div class="row notification-item" style="background-color:#cccccc;border-radius:15px;" data-notification-id="{{ $notification->id }}">
@endif

    <div class="col-md-12">
        @include($notification->type, ['notification' => $notification])

    </div>
</div>

@endforeach


