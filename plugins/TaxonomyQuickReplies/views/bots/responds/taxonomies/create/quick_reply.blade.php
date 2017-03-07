@extends('projects.responds.taxonomies.create._base')

@section('form')
    <input type="hidden" name="content_type" value="text">

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

    <div class="form-group{{ $errors->has('responds') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Responds</label>

        <div class="col-md-6">
            <select class="form-control select2" name="responds[]" multiple style="width: 100%;">
                @foreach($project->responds()->global()->get() as $respondValue)
                    <option value="{{ $respondValue->id }}" @if(in_array($respondValue->id, (array) old('responds'))) selected @endif>{{ $respondValue->title }}</option>
                @endforeach
            </select>

            @if ($errors->has('responds'))
                <span class="help-block">
                    <strong>{{ $errors->first('responds') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endsection