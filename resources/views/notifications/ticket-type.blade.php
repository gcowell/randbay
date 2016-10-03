<div class="col-md-3" style="height: 100px;width: 100px;margin: 0 auto;border-radius: 15px;">
    <img src="/img/exclamation.png" style="margin: auto;right: 0;left: 0;bottom: 0;top: 0;position: absolute;display: block;max-height: 90%;max-width: 90%;width: auto;height: auto;">
</div>
<div class="col-md-1">
</div>
<div class="col-md-7">
    <div class="row">
        <p>A ticket has been raised against your item: "<a href=/transactions/{{ $notification->transaction_id }}>{{ $notification->item_description }}"</a> </p>
        <p>Please respond <a href=/support/{{ $notification->item_support_ticket_id}} >here.</a></p>
    </div>
    <div class="row">
        <p style="font-size: 90%;font-style: italic;">{{ $notification->created_at->diffForHumans() }}</p>
    </div>
</div>
<div class="col-md-1">
    @if($notification->unread == 'true')
    <span class="glyphicon glyphicon-eye-open" title="Mark as read" id="mark-as-read" style="cursor:pointer;" aria-hidden="true"></span>
    @else
    @endif
</div>