@extends('admin.layouts.app')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left content-header-title">Dashboard</div>
            </div>
        </div>
    </div>

    <div class="container">
        @notification()

        <div class="row">
            <div class="col-md-3 col-md-push-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3><i class="fa fa-btn fa-user"></i>{{ \App\Models\User::count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-md-push-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3><i class="fa fa-btn fa-cubes"></i>{{ \App\Models\Project::count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Recent users
                    </div>
                    @if(count($users) <= 0)
                        <div class="panel-body">
                            There is no registered users! <a href="{{ route('admin.users.create') }}">Add</a> new user.
                        </div>
                    @else
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Projects</th>
                                    <th>Created</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->display_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->projects()->count() }}</td>
                                        <td>{{ $user->created_at->format('F j, Y, g:i A') }}</td>
                                        <td class="text-right">
                                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                <button type="submit" class="btn btn-danger confirm-action" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                                                <a href="{{ route('admin.users.impersonate', $user->id) }}" class="btn btn-success" data-toggle="tooltip" title="Login As This User"><i class="fa fa-universal-access"></i></a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-default" data-toggle="tooltip" title="Details"><i class="fa fa-arrow-right"></i></a>
                                            </form>
                                        </td>
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
