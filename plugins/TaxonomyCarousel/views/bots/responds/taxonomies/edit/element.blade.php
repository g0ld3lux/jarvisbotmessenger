@extends('projects.responds.taxonomies.edit._base')

@section('form')
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

    <div class="form-group{{ $errors->has('sub_title') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Sub-Title</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="sub_title" value="{{ old('sub_title', $taxonomy->getParamValue('sub_title')) }}">

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
            <input type="text" class="form-control" name="image_url" value="{{ old('image_url', $taxonomy->getParamValue('image_url')) }}">

            @if ($errors->has('image_url'))
                <span class="help-block">
                    <strong>{{ $errors->first('image_url') }}</strong>
                </span>
            @endif
        </div>
    </div>

    @if($taxonomy->children()->count() > 0)
        <div class="taxonomies-block">
            @foreach($taxonomy->children()->ordered()->get() as $child)
                @include('projects.responds.taxonomies.render.render', ['project' => $project, 'respond' => $respond, 'taxonomy' => $child])
            @endforeach
        </div>
    @else
        <div class="alert alert-info">There is no buttons defined!</div>
    @endif

    <div class="form-group text-right">
        <div class="col-md-6 col-md-offset-6">
            <a href="{{ route('projects.responds.edit.taxonomies.create', [$project->id, $respond->id, 'button', $taxonomy->id]) }}" class="btn btn-primary">
                <i class="fa fa-btn fa-plus"></i>Add new button
            </a>
        </div>
    </div>
@endsection