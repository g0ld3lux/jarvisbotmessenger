@extends('projects.responds.taxonomies.edit._base')

@section('form')
    <div class="form-group{{ $errors->has('option') ? ' has-error' : '' }}">
        <input type="hidden" name="option" value="{{ $taxonomy->getParamValue('option') }}">
        <label class="col-md-4 control-label">Option</label>

        <div class="col-md-6">
            <p class="form-control-static">{{ $taxonomy->getParamValue('option') }}</p>

            @if ($errors->has('option'))
                <span class="help-block">
                    <strong>{{ $errors->first('option') }}</strong>
                </span>
            @endif
        </div>
    </div>


    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Title</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="title" value="{{ old('title', $taxonomy->getParamValue('title')) }}">

            @if ($errors->has('title'))
                <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>
    </div>

    @if($taxonomy->getParamValue('option') == 'web_url')
        <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label">URL</label>

            <div class="col-md-6">
                <input type="text" class="form-control" name="url" value="{{ old('url', $taxonomy->getParamValue('url')) }}">

                @if ($errors->has('url'))
                    <span class="help-block">
                        <strong>{{ $errors->first('url') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    @endif

    @if($taxonomy->getParamValue('option') == 'postback')
        <div class="form-group{{ $errors->has('responds') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label">Responds</label>

            <div class="col-md-6">
                <select class="form-control select2" name="responds[]" multiple style="width: 100%;">
                    @foreach($project->responds()->global()->get() as $respondValue)
                        <option value="{{ $respondValue->id }}" @if(in_array($respondValue->id, (array) old('responds', $taxonomy->getParamValue('respond', 'array')))) selected @endif>{{ $respondValue->title }}</option>
                    @endforeach
                </select>

                @if ($errors->has('responds'))
                    <span class="help-block">
                        <strong>{{ $errors->first('responds') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    @endif

    @if($taxonomy->getParamValue('option') == 'phone_number')
        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label">Phone number</label>

            <div class="col-md-6">
                <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number', $taxonomy->getParamValue('phone_number')) }}">

                @if ($errors->has('phone_number'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone_number') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    @endif
@endsection