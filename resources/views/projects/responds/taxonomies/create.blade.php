@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left content-header-title"><a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a> &raquo; <a href="{{ route('projects.responds.index', $project->id) }}">Responds</a> &raquo; {{ $respond->title }} &raquo; <a href="{{ route('projects.responds.edit', [$project->id, $respond->id]) }}">Edit</a> &raquo; Elements</div>
                <div class="pull-right">
                    @include('projects._partials.menu')
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Messages</div>
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(app('app.services.taxonomies.create_link_registry')->items(\App\Services\Taxonomies\CreateLinkRegistry::MESSAGE) as $item)
                                <tr>
                                    <td class="text-center">{!! $item->icon() !!}</td>
                                    <td>{{ $item->title() }}</td>
                                    <td>{{ $item->description() }}</td>
                                    <td class="text-right">
                                        <a href="{{ $item->link($project, $respond) }}" class="btn btn-default"><i class="fa fa-plus"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Plugins</div>
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(app('app.services.taxonomies.create_link_registry')->items(\App\Services\Taxonomies\CreateLinkRegistry::PLUGIN) as $item)
                                <tr>
                                    <td class="text-center">{!! $item->icon() !!}</td>
                                    <td>{{ $item->title() }}</td>
                                    <td>{{ $item->description() }}</td>
                                    <td class="text-right">
                                        <a href="{{ $item->link($project, $respond) }}" class="btn btn-default"><i class="fa fa-plus"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Hooks</div>
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(app('app.services.taxonomies.create_link_registry')->items(\App\Services\Taxonomies\CreateLinkRegistry::HOOK) as $item)
                                <tr>
                                    <td class="text-center">{!! $item->icon() !!}</td>
                                    <td>{{ $item->title() }}</td>
                                    <td>{{ $item->description() }}</td>
                                    <td class="text-right">
                                        <a href="{{ $item->link($project, $respond) }}" class="btn btn-default"><i class="fa fa-plus"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection