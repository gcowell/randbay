<div class="col-md-3" style="height: 100px;width: 100px;margin: 0 auto;border-radius: 15px;">
    <img src="/images/{{ $notification->item_img_path }}" style="margin: auto;right: 0;left: 0;bottom: 0;top: 0;position: absolute;display: block;max-height: 100%;max-width: 100%;width: auto;height: auto;">
</div>
<div class="col-md-8">
    <div class="row">
        <p>You bought <a href=/transactions/{{ $notification->transaction_id }}>{{ $notification->item_description }}</a> from {{ $notification->item_country_of_origin }}</p>
    </div>
    <div class="row">
        <a href=/transactions/{{ $notification->transaction_id }}>View Transaction</a>
    </div>
    <div class="row">
        {{ $notification->created_at->diffForHumans() }}
    </div>
</div>
<div class="col-md-1">
    @if($notification->unread == 'true')
    <span class="glyphicon glyphicon-eye-open" id="mark-as-read" style="cursor:pointer;" aria-hidden="true"></span>
    @else
    @endif
</div>




