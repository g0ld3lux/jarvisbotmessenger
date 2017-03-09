<div class="form-group{{ $errors->has('greeting_text') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Greeting text</label>

    <div class="col-md-6">
        <textarea rows="4" class="form-control" name="greeting_text">{{ old('greeting_text', $bot->threadSettings->greeting_text) }}</textarea>

        @if ($errors->has('greeting_text'))
            <span class="help-block">
                <strong>{{ $errors->first('greeting_text') }}</strong>
            </span>
        @endif
    </div>
</div>