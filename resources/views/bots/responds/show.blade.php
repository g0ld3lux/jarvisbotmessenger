@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left content-header-title"><a href="{{ route('bots.show', $bot->id) }}">{{ $bot->title }}</a> &raquo; <a href="{{ route('bots.responds.index', $bot->id) }}">Responds</a> &raquo; {{ $respond->title }}</div>
                <div class="pull-right">
                    <form method="POST" action="{{ route('bots.responds.delete', [$bot->id, $respond->id]) }}">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        @include('bots._partials.menu')
                        <button type="submit" class="btn btn-danger confirm-action" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                        <a href="{{ route('bots.responds.edit', [$bot->id, $respond->id]) }}" class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @notification()
    </div>
@endsection