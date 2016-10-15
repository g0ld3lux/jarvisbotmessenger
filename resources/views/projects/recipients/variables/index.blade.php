@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left content-header-title"><a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a> &raquo; Recipients variables</div>
                <div class="pull-right">
                    @include('projects._partials.menu')
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @notification()

        <uib-tabset active="0" ng-cloak>
            <uib-tab index="0">
                <uib-tab-heading>
                    <i class="fa fa-btn fa-list"></i>Variables
                </uib-tab-heading>
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="pull-right">
                            <a href="{{ route('projects.recipients.variables.create', $project->id) }}" class="btn btn-primary" uib-tooltip="Add variable" tooltip-trigger="mouseenter"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    @if(count($recipientsVariables) <= 0)
                        <div class="panel-body">
                            You have no variables in this project! <a href="{{ route('projects.recipients.variables.create', $project->id) }}">Add</a> new variable.
                        </div>
                    @else
                        @include('projects.recipients.variables._partials.table', ['recipientsVariables' => $recipientsVariables])
                    @endif
                </div>
            </uib-tab>
        </uib-tabset>
    </div>
@endsection