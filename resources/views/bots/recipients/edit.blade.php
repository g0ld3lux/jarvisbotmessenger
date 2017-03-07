@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left content-header-title"><a href="{{ route('bots.show', $bot->id) }}">{{ $bot->title }}</a> &raquo; <a href="{{ route('bots.recipients.index', $bot->id) }}">Recipients</a> &raquo; <a href="{{ route('bots.recipients.show', [$bot->id, $recipient->id]) }}">@if($recipient->getPhotoUrl('recipient_small')) <img class="img-circle" src="{{ $recipient->getPhotoUrl('recipient_small') }}"> @endif {{ $recipient->display_name }}</a> &raquo; Edit</div>
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
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('bots.recipients.update', [$bot->id, $recipient->id]) }}">
                            {!! csrf_field() !!}

                            @foreach(recipient_variables_list($bot) as $variable)
                                @include('bots.recipients.variables.form.form', ['variable' => $variable, 'recipientVariables' => $recipientVariables])
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