@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left content-header-title"><a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a> &raquo; <a href="{{ route('projects.responds.index', $project->id) }}">Responds</a> &raquo; {{ $respond->title }} &raquo; <a href="{{ route('projects.responds.edit', [$project->id, $respond->id]) }}">Edit</a> &raquo; Elements</div>
                <div class="pull-right">
                    @include('projects._partials.menu')
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('projects.responds.edit.taxonomies.update', [$project->id, $respond->id, $taxonomy->id]) }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            <input type="hidden" name="type" value="{{ $taxonomy->type }}">

                            @yield('form')

                            @if((isset($btn_save) && $btn_save) || !isset($btn_save))
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-btn fa-save"></i>Save
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection