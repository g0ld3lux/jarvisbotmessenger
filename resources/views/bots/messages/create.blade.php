@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left content-header-title"><a href="{{ route('bots.show', $bot->id) }}">{{ $bot->title }}</a> &raquo; <a href="{{ route('bots.messages.index', $bot->id) }}">Mass messages</a> &raquo; Schedule message</div>
                <div class="pull-right">
                    @include('bots._partials.menu')
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
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('bots.messages.store', $bot->id) }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('responds') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Responds to send</label>

                                <div class="col-md-6">
                                    <select class="form-control select2" name="responds[]" multiple>
                                        @foreach($responds as $respond)
                                            <option value="{{ $respond->id }}" @if(in_array($respond->id, (array) old('responds'))) selected @endif>{{ $respond->title }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('responds'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('responds') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('recipients') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Send to</label>

                                <div class="col-md-6">
                                    <select class="form-control select2" name="recipients[]" multiple>
                                        @foreach($recipients as $recipient)
                                            <option value="{{ $recipient->id }}" @if(in_array($recipient->id, (array) old('recipients'))) selected @endif>{{ $recipient->display_name }}</option>
                                        @endforeach
                                    </select>

                                    <span class="help-block text-right">
                                        <small>If none selected then all will be used.</small>
                                    </span>

                                    @if ($errors->has('recipients'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('recipients') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('scheduled_at') || $errors->has('timezone') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Schedule at</label>

                                <div class="col-md-3">
                                    <div class="input-group{{ $errors->has('scheduled_at') ? ' has-error' : '' }}">
                                        <span class="input-group-addon" id="select-schedule-time-addon"><i class="fa fa-clock-o"></i></span>
                                        <input name="scheduled_at" type="text" class="form-control" aria-describedby="select-schedule-time-addon" id="select-schedule-time">
                                    </div>

                                    @if ($errors->has('scheduled_at'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('scheduled_at') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <select name="timezone" class="form-control">
                                        <option value="bot">by Bot timezone</option>
                                        <option value="recipient">by Recipient timezone</option>
                                    </select>

                                    @if ($errors->has('timezone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('timezone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('interval') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Interval</label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" name="interval" placeholder="Interval" class="form-control" id="inputInterval" value="{{ old('interval') }}" aria-describedby="interval-addon">
                                        <span class="input-group-addon" id="interval-addon">sec.</span>
                                    </div>

                                    @if ($errors->has('interval'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('interval') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-save"></i>Schedule
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).on("ready", function () {
            $("#select-schedule-time").datetimepicker({
                minDate: moment().tz("{{ $bot->timezone }}")
            });
        });
    </script>
@endpush