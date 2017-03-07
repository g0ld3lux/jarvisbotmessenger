<div class="form-group">
    <label class="col-md-4 control-label">Save to</label>

    <div class="col-md-6">
        <p class="form-control-static"><a href="{{ route('bots.recipients.variables.edit', [$bot->id, $param->value]) }}">{{ $bot->recipientsVariables()->find($param->value)->name }}</a></p>
    </div>
</div>