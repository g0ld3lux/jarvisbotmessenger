@extends('projects.responds.taxonomies.create._base')

@section('form')
    <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Callback URL</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="url" value="{{ old('url') }}">

            @if($errors->has('url'))
                <span class="help-block">
                    <strong>{{ $errors->first('url') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endsection