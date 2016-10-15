@extends('layouts.app')

@push('head_scripts')
    <script type="text/javascript">
        var PROJECT_ID = {{ $project->id }};
        var PROJECT_TIMEZONE = "{{ $project->timezone }}";
    </script>
@endpush

@section('content')
    <div ng-controller="RespondsController">
        <div class="content-header">
            <div class="container">
                <div class="clearfix">
                    <div class="pull-left content-header-title"><a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a> &raquo; Responds</div>
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
                        <i class="fa fa-btn fa-list"></i>Responds
                    </uib-tab-heading>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p class="text-center" ng-show="respondsLoading">Initializing responds...</p>

                            <div class="alert alert-info" ng-show="!respondsLoading && (responds.length <= 0 || !responds)" ng-cloak>No responds found.</div>

                            <div ng-show="responds.length > 0 && !respondsLoading" ng-cloak>
                                <div class="row">
                                    <div class="col-md-8 col-md-push-2">
                                        <div class="panel panel-default">
                                            <input type="text" name="search" class="form-control" placeholder="Search for..." ng-model="search">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 social-accounts">
                                        <ul class="responds-list list-unstyled">
                                            <li class="col-md-4" ng-repeat="respond in responds | filter : search as filtered_responds track by respond.id">
                                                <div class="panel panel-default respond-item">
                                                    <div class="title">
                                                        <a respond-href="respond" uib-tooltip="@{{ respond.title }}" tooltip-trigger="mouseenter">
                                                            @{{ respond.title | truncate:30}}
                                                        </a>
                                                        <button type="button" class="close" ng-click="deleteRespond(respond)" uib-tooltip="Delete respond" tooltip-trigger="mouseenter"><i class="fa fa-times"></i></button>
                                                    </div>
                                                    <div class="clearfix">
                                                        <small class="date pull-right" project-time time="respond.updated_at"></small>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="row" ng-show="filtered_responds.length <= 0">
                                    <div class="col-md-12">
                                        <div class="alert alert-info">No responds found.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </uib-tab>
                <uib-tab index="1" select="addRespond()">
                    <uib-tab-heading>
                        <i class="fa fa-btn fa-plus"></i>Add respond
                    </uib-tab-heading>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p class="text-center">Redirecting...</p>
                        </div>
                    </div>
                </uib-tab>
            </uib-tabset>
        </div>
    </div>
@endsection