@push('head_scripts')
    <script type="text/javascript">
        var BOT_ID = "{{ $bot->id }}";
    </script>
@endpush

@push('ajax')
<div class="panel panel-default" ng-controller="BotDashboardController" style="margin-top: -290px;">
    <div class="jumbotron jumbotron-white">
        <p class="text-center">
            Connected Facebook page:
            <span ng-show="botLoading">Initializing...</span>
            <span ng-show="!botLoading && !bot.id">Failed to load Bot Data...</span>
            <span ng-show="!botLoading && bot.id">
                <a ng-href="http://www.facebook.com/@{{ bot.page_id }}" ng-show="bot.page_id" target="_blank"><strong>@{{ bot.page_title }}</strong></a>
                <button class="btn btn-info btn-xs" ng-click="connectPage(bot)" ng-show="!bot.page_id"><i class="fa fa-plug fa-btn"></i>Connect Facebook page</button>
                <button class="btn btn-danger btn-xs" ng-click="disconnectPage(bot)" ng-show="bot.page_id" uib-tooltip="Disconnect current page" tooltip-trigger="mouseenter"><i class="fa fa-times"></i></button>
            </span>
        </p>
    </div>
</div>
<div style="padding-top: 170px;"></div>
@endpush
@push('ngTemplates')
@include('bots._partials.connect_facebook_page_modal')
@endpush