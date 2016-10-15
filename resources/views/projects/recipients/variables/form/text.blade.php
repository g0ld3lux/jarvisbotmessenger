<div class="form-group{{ $errors->has('variables.'.$variable->accessor) ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">{{ $variable->name }}</label>

    <div class="col-md-6">
        <input type="text" class="form-control" name="variables[{{ $variable->accessor }}]" value="{{ old('variables.'.$variable->accessor, $recipientVariables->has($variable->accessor) ? $recipientVariables->get($variable->accessor)->getParamValue('text') : '') }}">

        @if($errors->has('variables.'.$variable->accessor))
            <span class="help-block">
                <strong>{{ $errors->first('variables.'.$variable->accessor) }}</strong>
            </span>
        @endif
    </div>
</div>