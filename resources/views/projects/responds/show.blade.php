@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left content-header-title"><a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a> &raquo; <a href="{{ route('projects.responds.index', $project->id) }}">Responds</a> &raquo; {{ $respond->title }}</div>
                <div class="pull-right">
                    <form method="POST" action="{{ route('projects.responds.delete', [$project->id, $respond->id]) }}">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        @include('projects._partials.menu')
                        <button type="submit" class="btn btn-danger confirm-action" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                        <a href="{{ route('projects.responds.edit', [$project->id, $respond->id]) }}" class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @notification()
    </div>
@endsection