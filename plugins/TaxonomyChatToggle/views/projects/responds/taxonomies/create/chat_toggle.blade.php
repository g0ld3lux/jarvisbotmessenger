@extends('projects.responds.taxonomies.create._base')

@section('form')
    <div class="form-group{{ $errors->has('option') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Option</label>

        <div class="col-md-6">
            <div class="radio">
                <label>
                    <input type="radio" name="option" id="optionEnable" value="enable" {{ old('option') == 'enable' ? 'checked' : '' }}>
                    Enable chat for recipient
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="option" id="optionDisable" value="disable" {{ old('option') == 'disable' ? 'checked' : '' }}>
                    Disable chat for recipient
                </label>
            </div>

            @if ($errors->has('option'))
                <span class="help-block">
                    <strong>{{ $errors->first('option') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endsection