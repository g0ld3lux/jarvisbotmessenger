@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left content-header-title">Bots</div>
                <div class="pull-right content-header-actions">
                    <a href="{{ route('projects.create') }}" class="btn btn-primary"><i class="fa fa-btn fa-plus"></i>Add Bot</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @notification()

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    @if(count($projects) <= 0)
                        <div class="panel-body">
                            You have no Bots! <a href="{{ route('projects.create') }}">Create</a> new Bot
                        </div>
                    @else
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Facebook page</th>
                                    <th>Subscribed</th>
                                    <th>Timezone</th>
                                    <th>Created</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                    <tr>
                                        <td><a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a></td>
                                        <td>
                                            @if($project->page_id)
                                                <a href="http://www.facebook.com/{{ $project->page_id }}" target="_blank">{{ $project->page_title }}</a>
                                            @else
                                                <span class="text-muted">none</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($project->app_subscribed)
                                                <span class="label label-success">yes</span>
                                            @else
                                                <span class="label label-danger">no</span>
                                            @endif
                                        </td>
                                        <td>{{ $project->timezone }}</td>
                                        <td>{{ adjust_project_timezone($project, $project->created_at)->format('Y-m-d') }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('projects.show', $project->id) }}" class="btn btn-default"><i class="fa fa-arrow-right"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection