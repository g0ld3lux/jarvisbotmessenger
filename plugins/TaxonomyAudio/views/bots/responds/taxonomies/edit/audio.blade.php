@extends('bots.responds.taxonomies.edit._base')

@section('form')
    <input type="hidden" name="option" value="{{ $taxonomy->getParamValue('option') }}">

    <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Audio URL</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="url" value="{{ old('url', $taxonomy->getParamValue('url')) }}">

            @if ($errors->has('url'))
                <span class="help-block">
                    <strong>{{ $errors->first('url') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endsection