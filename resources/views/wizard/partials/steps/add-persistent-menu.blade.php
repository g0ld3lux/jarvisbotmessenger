<div class="form-group{{ $errors->has('persistent_menu_respond_id') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Persistent menu respond</label>

    <div class="col-md-6">
        <select name="persistent_menu_respond_id" class="form-control select2" style="width: 100%;">
            <option>- none -</option>
            @foreach($persistent_menu_responds as $respond)
                <option value="{{ $respond->id }}" @if($bot->threadSettings->persistent_menu_respond_id == $respond->id) selected @endif>{{ $respond->title }}</option>
            @endforeach
        </select>

        @if ($errors->has('persistent_menu_respond_id'))
            <span class="help-block">
                <strong>{{ $errors->first('persistent_menu_respond_id') }}</strong>
            </span>
        @endif
    </div>
</div>