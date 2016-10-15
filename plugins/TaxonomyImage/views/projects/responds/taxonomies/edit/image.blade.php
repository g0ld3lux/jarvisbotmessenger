@extends('projects.responds.taxonomies.edit._base')

@section('form')
    {{--<div class="form-group{{ $errors->has('option') ? ' has-error' : '' }}">--}}
        <input type="hidden" name="option" value="{{ $taxonomy->getParamValue('option') }}">
        {{--<label class="col-md-4 control-label">Option</label>--}}

        {{--<div class="col-md-6">--}}
            {{--<p class="form-control-static">{{ array_get($params, 'option') }}</p>--}}

            {{--@if ($errors->has('option'))--}}
                {{--<span class="help-block">--}}
                    {{--<strong>{{ $errors->first('option') }}</strong>--}}
                {{--</span>--}}
            {{--@endif--}}
        {{--</div>--}}
    {{--</div>--}}

    @if($taxonomy->getParamValue('option') == 'url')
        <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label">Image URL</label>

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

    @if($taxonomy->getParamValue('option') == 'upload')
        <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label">File (jpg, png)</label>

            <div class="col-md-6">
                <input type="file" class="form-control" name="file" value="{{ old('file') }}">

                @if ($errors->has('file'))
                    <span class="help-block">
                        <strong>{{ $errors->first('file') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-push-4">
                <p class="form-control-static">
                    <img src="{{ route('imagecache', ['image_preview', $taxonomy->getParamValue('source')]) }}">
                </p>
            </div>
        </div>
    @endif
@endsection