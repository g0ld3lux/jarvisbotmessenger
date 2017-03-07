@extends('layouts.app')

@push('head_scripts')
    <script type="text/javascript">
        var MESSAGE_ID = {{ $message->id }};
        var BOT_ID = {{ $bot->id }};
        var BOT_TIMEZONE = "{{ $bot->timezone }}";
    </script>
@endpush

@section('content')
    <div ng-controller="MassMessageController">
        <div class="content-header">
            <div class="container">
                <div class="clearfix">
                    <div class="pull-left content-header-title"><a href="{{ route('bots.show', $bot->id) }}">{{ $bot->title }}</a> &raquo; <a href="{{ route('bots.messages.index', $bot->id) }}">Messages</a> &raquo; {{ $message->name }}</div>
                    <div class="pull-right">
                        @include('bots._partials.menu')
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            @notification()

            <uib-tabset active="0" ng-cloak>
                <uib-tab index="0">
                    <uib-tab-heading>
                        <i class="fa fa-btn fa-info"></i>Message details
                    </uib-tab-heading>
                    @include('bots.messages._partials.details')
                </uib-tab>
                <uib-tab index="1">
                    <uib-tab-heading>
                        <i class="fa fa-btn fa-clock-o"></i>Schedules
                    </uib-tab-heading>
                    @include('bots.messages._partials.schedules')
                </uib-tab>
            </uib-tabset>
        </div>
    </div>
@endsection