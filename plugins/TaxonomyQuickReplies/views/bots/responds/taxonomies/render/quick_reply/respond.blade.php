<div class="form-group">
    <label class="col-md-4 control-label">Respond</label>

    <div class="col-md-6">
        <p class="form-control-static"><a href="{{ route('bots.responds.edit', [$bot->id, $param->value]) }}">{{ $bot->responds()->find($param->value)->title }}</a></p>
    </div>
</div>