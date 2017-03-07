@extends('projects.responds.taxonomies.edit._base')

@section('form')
    <div class="form-group{{ $errors->has('option') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Option</label>

        <div class="col-md-6">
            <div class="radio">
                <label>
                    <input type="radio" name="option" id="optionEnable" value="enable" {{ old('option', $taxonomy->getParamValue('option')) == 'enable' ? 'checked' : '' }}>
                    Enable chat for recipient
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="option" id="optionDisable" value="disable" {{ old('option', $taxonomy->getParamValue('option')) == 'disable' ? 'checked' : '' }}>
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