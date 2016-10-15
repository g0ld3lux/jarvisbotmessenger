@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left content-header-title"><a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a> &raquo; <a href="{{ route('projects.recipients.index', $project->id) }}">Recipients</a> &raquo; <a href="{{ route('projects.recipients.show', [$project->id, $recipient->id]) }}">@if($recipient->getPhotoUrl('recipient_small')) <img class="img-circle" src="{{ $recipient->getPhotoUrl('recipient_small') }}"> @endif {{ $recipient->display_name }}</a> &raquo; Edit</div>
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
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('projects.recipients.update', [$project->id, $recipient->id]) }}">
                            {!! csrf_field() !!}

                            @foreach(recipient_variables_list($project) as $variable)
                                @include('projects.recipients.variables.form.form', ['variable' => $variable, 'recipientVariables' => $recipientVariables])
                            @endforeach

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