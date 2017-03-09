<div class="form-group{{ $errors->has('get_started_respond_id') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Get started respond</label>

    <div class="col-md-6">
        <select name="get_started_respond_id" class="form-control select2" style="width: 100%;">
            <option>- none -</option>
            @foreach($responds as $respond)
                <option value="{{ $respond->id }}" @if($bot->threadSettings->get_started_respond_id == $respond->id) selected @endif>{{ $respond->title }}</option>
            @endforeach
        </select>

        @if ($errors->has('get_started_respond_id'))
            <span class="help-block">
                <strong>{{ $errors->first('get_started_respond_id') }}</strong>
            </span>
        @endif
    </div>
</div>