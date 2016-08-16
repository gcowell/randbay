@foreach ($notifications as $notification)
@if ($notification->unread == 'true')
<div class="row notification-item" style="background-color:#b4c3d8;border-radius:15px;" data-notification-id="{{ $notification->id }}">
@else
<div class="row notification-item" style="background-color:#d9e1ec;border-radius:15px;" data-notification-id="{{ $notification->id }}">
@endif

    <div class="col-md-12">
        @include($notification->type, ['notification' => $notification])

    </div>
</div>
<div class="row" id="spacer">

</div>

@endforeach


