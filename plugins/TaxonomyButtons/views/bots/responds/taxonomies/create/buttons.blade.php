@extends('bots.responds.taxonomies.create._base')

@section('form')
    <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Text</label>

        <div class="col-md-6">
            <textarea rows="5" class="form-control" name="text">{{ old('text') }}</textarea>

            @if ($errors->has('text'))
                <span class="help-block">
                    <strong>{{ $errors->first('text') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endsection