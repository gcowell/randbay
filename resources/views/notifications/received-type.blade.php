<div class="col-md-3" style="height: 100px;width: 100px;margin: 0 auto;border-radius: 15px;">
    <a id="fancy-img" href="/images/{{ $notification->item_img_path }}">
        <img src="/images/{{ $notification->item_img_path }}" style="margin: auto;right: 0;left: 0;bottom: 0;top: 0;position: absolute;display: block;max-height: 90%;max-width: 90%;width: auto;height: auto;">
    </a>
</div>
<div class="col-md-1">
</div>
<div class="col-md-7">
    <div class="row">
        <p>Your sold item <a href=/transactions/{{ $notification->transaction_id }}>{{ $notification->item_description }}</a> has been received by the buyer!</p>
    </div>
    <div class="row">
        <a href=/transactions/{{ $notification->transaction_id }}>View Transaction</a>
    </div>
    <div class="row">
        <p style="font-size: 90%;font-style: italic;">{{ $notification->created_at->diffForHumans() }}</p>
    </div>
</div>
<div class="col-md-1">
    @if($notification->unread == 'true')
    <span class="glyphicon glyphicon-eye-open" id="mark-as-read" style="cursor:pointer;" aria-hidden="true"></span>
    @else
    @endif
</div>