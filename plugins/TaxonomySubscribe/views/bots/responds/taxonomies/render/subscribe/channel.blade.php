<div class="form-group">
    <label class="col-md-4 control-label">Channel</label>

    <div class="col-md-6">
        <p class="form-control-static"><a href="{{ route('bots.subscriptions.channels.show', [$bot->id, $param->value]) }}">{{ $bot->subscriptionsChannels()->find($param->value)->name }}</a></p>
    </div>
</div>