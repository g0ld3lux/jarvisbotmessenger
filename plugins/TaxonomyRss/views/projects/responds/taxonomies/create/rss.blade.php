@extends('projects.responds.taxonomies.create._base')

@section('form')
    <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">RSS feed URL</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="url" value="{{ old('url') }}">

            @if($errors->has('url'))
                <span class="help-block">
                    <strong>{{ $errors->first('url') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('count') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Show no more than</label>

        <div class="col-md-6">
            <select class="form-control" name="count">
                <option value="1" @if(old('count') == '1') selected @endif>1 story</option>
                <option value="2" @if(old('count') == '2') selected @endif>2 stories</option>
                <option value="3" @if(old('count') == '3') selected @endif>3 stories</option>
                <option value="4" @if(old('count') == '4') selected @endif>4 stories</option>
                <option value="5" @if(old('count') == '5') selected @endif>5 stories</option>
                <option value="6" @if(old('count') == '6') selected @endif>5 stories</option>
                <option value="7" @if(old('count') == '7') selected @endif>7 stories</option>
                <option value="8" @if(old('count') == '8') selected @endif>8 stories</option>
                <option value="9" @if(old('count') == '9') selected @endif>9 stories</option>
            </select>

            @if($errors->has('count'))
                <span class="help-block">
                    <strong>{{ $errors->first('count') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('text_link') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Text for a link to an article</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="text_link" value="{{ old('text_link') }}">

            @if($errors->has('text_link'))
                <span class="help-block">
                    <strong>{{ $errors->first('text_link') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endsection