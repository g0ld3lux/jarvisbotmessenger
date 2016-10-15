@extends('layouts.app')

@push('head_scripts')
    <script type="text/javascript">
        var PROJECT_ID = "{{ $project->id }}";
    </script>
@endpush

@section('content')
    <div ng-controller="ProjectDashboardController">
        <div class="content-header">
            <div class="container">
                <div class="clearfix">
                    <div class="pull-left content-header-title">{{ $project->title }}</div>
                    <div class="pull-right">
                        @include('projects._partials.menu')
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            @notification()

            <uib-tabset active="0">
                <uib-tab index="0">
                    <uib-tab-heading>
                        <i class="fa fa-info fa-btn"></i>Project details
                    </uib-tab-heading>
                    <div>
                        <div class="panel panel-default">
                            <div class="jumbotron jumbotron-white">
                                <p class="text-center">
                                    Connected Facebook page:
                                    <span ng-show="projectLoading">Initializing...</span>
                                    <span ng-show="!projectLoading && !project.id">Failed to load project...</span>
                                    <span ng-show="!projectLoading && project.id">
                                        <a ng-href="http://www.facebook.com/@{{ project.page_id }}" ng-show="project.page_id" target="_blank"><strong>@{{ project.page_title }}</strong></a>
                                        <button class="btn btn-info btn-xs" ng-click="connectPage(project)" ng-show="!project.page_id"><i class="fa fa-plug fa-btn"></i>Connect Facebook page</button>
                                        <button class="btn btn-danger btn-xs" ng-click="disconnectPage(project)" ng-show="project.page_id" uib-tooltip="Disconnect current page" tooltip-trigger="mouseenter"><i class="fa fa-times"></i></button>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div ng-controller="ProjectAnalyticsController">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="clearfix">
                                                <div class="pull-left">Analytics</div>
                                                <div class="pull-right" ng-cloak>
                                                    <div date-range-picker ng-model="datePicker.date" options="datePicker.options" class="btn btn-default btn-xs analytics-date">
                                                        <span>@{{ datePicker.date.startDate.format("MMM D, YYYY") }} - @{{ datePicker.date.endDate.format("MMM D, YYYY") }}</span> <b class="caret"></b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <p class="text-center" ng-show="analyticsLoading">Initializing project analytics...</p>
                                            <canvas ng-cloak ng-show="!analyticsLoading" height="282" class="chart chart-bar" chart-data="data" chart-labels="labels" chart-series="series" chart-options="options" chart-colors="colors"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </uib-tab>
                <uib-tab index="1">
                    <uib-tab-heading>
                        <i class="fa fa-clone fa-btn"></i>Flows
                    </uib-tab-heading>
                    <div ng-controller="ProjectDashboardFlowsController">
                        <div class="panel panel-default" ng-show="flowsLoading">
                            <div class="panel-body text-center">
                                <p>Initializing flows...</p>
                            </div>
                        </div>

                        <div ng-cloak ng-show="!flowsLoading" class="panel panel-default">
                            <div class="panel-body">
                                <div class="clearfix">
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-primary" ng-click="import()" uib-tooltip="Import flows" tooltip-trigger="mouseenter"><i class="fa fa-download fa-btn"></i>Import</button>
                                        <button type="button" class="btn btn-primary" ng-click="export()" uib-tooltip="Export flows" tooltip-trigger="mouseenter"><i class="fa fa-upload fa-btn"></i>Export</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default" ng-show="!flows || flows.length <= 0 && !flowsLoading">
                            <div class="panel-body">
                                <div class="alert alert-info">No flows are defined</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row" ui-sortable="sortableOptions" ng-model="flows">
                                    <div class="col-md-12 flow-container" ng-repeat="flow in flows" ng-mouseenter="hoverFlow = flow.id" ng-mouseleave="hoverFlow = null">
                                        <div class="panel panel-default">
                                            <div class="panel-heading clearfix">
                                                <span ng-show="flow.is_default" uib-tooltip="Default flow" tooltip-trigger="mouseenter"><i class="fa fa-asterisk"></i></span>
                                                @{{ flow.title }}
                                                <button type="button" ng-click="deleteFlow(flow)" ng-show="hoverFlow == flow.id" class="close flow-action-button" tooltip-trigger="mouseenter" uib-tooltip="Delete flow"><i class="fa fa-times"></i></button>
                                                <button type="button" ng-click="editFlow(flow)" ng-show="hoverFlow == flow.id" class="close flow-action-button" tooltip-trigger="mouseenter" uib-tooltip="Edit flow"><i class="fa fa-pencil"></i></button>
                                                <button type="button" ng-click="makeDefault(flow)" ng-show="hoverFlow == flow.id && !flow.is_default" class="close flow-action-button" tooltip-trigger="mouseenter" uib-tooltip="Make default"><i class="fa fa-asterisk"></i></button>
                                                <button type="button" ng-click="removeDefault(flow)" ng-show="hoverFlow == flow.id && flow.is_default" class="close flow-action-button" tooltip-trigger="mouseenter" uib-tooltip="Remove default flow"><i class="fa fa-asterisk"></i></button>
                                                <span ng-show="hoverFlow == flow.id" class="close flow-action-button drag-handle" tooltip-trigger="mouseenter" uib-tooltip="Reorder"><i class="fa fa-arrows"></i></span>
                                            </div>
                                            <div class="panel-body">
                                                <dl class="dl-horizontal">
                                                    <dt class="text-muted">If user says:</dt>
                                                    <dd>
                                                        <div ng-show="flow.matchers.length <= 0">There is no assigned phrases</div>
                                                        <span class="matcher" ng-repeat="matcher in flow.matchers">
                                                        <div class="btn-group btn-group-xs" role="group">
                                                            <button class="btn btn-primary" type="button">
                                                                <span ng-show="matcher.type == 'contains'">
                                                                    <span matcher-param="matcher" param="text"></span>
                                                                </span>
                                                                <span ng-show="matcher.type == 'equals'">
                                                                    <span matcher-param="matcher" param="text"></span>
                                                                </span>
                                                                <span ng-show="matcher.type == 'regex'">
                                                                    <span matcher-param="matcher" param="pattern"></span>
                                                                </span>
                                                                <span ng-show="matcher.type == 'text'">
                                                                    <span matcher-param="matcher" param="text"></span> <small class="text-muted">(<span matcher-param="matcher" param="sensitivity"></span>)</small>
                                                                </span>
                                                                <span class="badge">@{{ matcher.type }}</span>
                                                                </button>
                                                            </div>
                                                        </span>
                                                    </dd>
                                                </dl>
                                                <hr>
                                                <dl class="dl-horizontal">
                                                    <dt class="text-muted">Then show them:</dt>
                                                    <dd>
                                                        <div ng-show="flow.responds.length <= 0">There is nothing to say :(</div>
                                                        <span class="respond" ng-repeat="respond in flow.responds">
                                                            <a ng-href="@{{ respondHref(respond) }}" class="btn btn-primary btn-xs">@{{ respond.title }}</a>
                                                        </span>
                                                    </dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" ng-show="!flowsLoading">
                                    <div class="col-md-12 text-center">
                                        <button type="button" ng-click="addFlow()" class="btn btn-primary btn-lg btn-block"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </uib-tab>
            </uib-tabset>
        </div>
    </div>
@endsection

@push('ngTemplates')
    @include('projects._partials.flow_modal')
    @include('projects._partials.matcher_modal')
    @include('projects._partials.connect_facebook_page_modal')
    @include('projects._partials.export_modal')
    @include('projects._partials.import_modal')
@endpush