@extends('bots.responds.taxonomies.create._base')

@section('form')
    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Title</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="title" value="{{ old('title') }}">

            @if ($errors->has('title'))
                <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('sub_title') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Sub-Title</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="sub_title" value="{{ old('sub_title') }}">

            @if ($errors->has('sub_title'))
                <span class="help-block">
                    <strong>{{ $errors->first('sub_title') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('image_url') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Image URL</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="image_url" value="{{ old('image_url') }}">

            @if ($errors->has('image_url'))
                <span class="help-block">
                    <strong>{{ $errors->first('image_url') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endsection