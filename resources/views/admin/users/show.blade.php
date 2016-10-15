@extends('admin.layouts.app')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left content-header-title"><a href="{{ route('admin.users.index') }}">Users</a> &raquo; #{{ $user->id }} {{ $user->display_name }}</div>
                <div class="pull-right content-header-actions">
                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <button type="submit" class="btn btn-danger confirm-action" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @notification()

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        #{{ $user->id }} {{ $user->display_name }}
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Name</label>

                                        <div class="col-md-6">
                                            <p class="form-control-static">{{ $user->name }}</p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">E-mail</label>

                                        <div class="col-md-6">
                                            <p class="form-control-static">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Created at</label>

                                        <div class="col-md-6">
                                            <p class="form-control-static">{{ $user->created_at->format('F j, Y, g:i A') }}</p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Updated at</label>

                                        <div class="col-md-6">
                                            <p class="form-control-static">{{ $user->updated_at->format('F j, Y, g:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(count($user->permissions) > 0)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Permissions</label>

                                            <div class="col-md-8">
                                                <p class="form-control-static">
                                                    @foreach($user->permissions as $permission)
                                                        <span class="label label-info">{{ $permission->permission }}</span>
                                                    @endforeach
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    @if(count($projects) <= 0)
                        <div class="panel-body">
                            User has no projects!
                        </div>
                    @else
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Recipients</th>
                                    <th>Flows</th>
                                    <th>Created</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                    <tr>
                                        <td>{{ $project->title }}</td>
                                        <td>{{ $project->recipients()->count() }}</td>
                                        <td>{{ $project->flows()->count() }}</td>
                                        <td>{{ $project->created_at->format('F j, Y, g:i A') }}</td>
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