@extends('projects.responds.taxonomies.edit._base')

@section('form')
    <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Text</label>

        <div class="col-md-6">
            <textarea rows="5" class="form-control" name="text">{{ old('text', $taxonomy->getParamValue('text')) }}</textarea>

            @if ($errors->has('text'))
                <span class="help-block">
                    <strong>{{ $errors->first('text') }}</strong>
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