@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left content-header-title"><a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a> &raquo; <a href="{{ route('projects.responds.index', $project->id) }}">Responds</a> &raquo; {{ $respond->title }} &raquo; Edit</div>
                <div class="pull-right">
                    @include('projects._partials.menu')
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @notification()
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('projects.responds.update', [$project->id, $respond->id]) }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Title</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="title" value="{{ old('title', $respond->title) }}">

                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="taxonomies-block">
                                @foreach($taxonomies as $taxonomy)
                                    @include('projects.responds.taxonomies.render.render', ['project' => $project, 'respond' => $respond, 'taxonomy' => $taxonomy])
                                @endforeach
                            </div>

                            <div class="form-group text-right">
                                <div class="col-md-6 col-md-offset-4">
                                    <a href="{{ route('projects.responds.edit.taxonomies.create', [$project->id, $respond->id]) }}" class="btn btn-primary">
                                        <i class="fa fa-btn fa-plus"></i>Add new element
                                    </a>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-save"></i>Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection