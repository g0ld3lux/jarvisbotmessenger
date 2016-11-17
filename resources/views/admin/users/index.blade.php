@extends('admin.layouts.app')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left content-header-title">Users</div>
                <div class="pull-right content-header-actions">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fa fa-btn fa-plus"></i>Add user</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @notification()

        <div class="row">
            <div class="col-md-10 col-md-push-1">
                <div class="panel panel-default">
                    <form method="GET" action="{{ route('admin.users.index') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search for..." value="{{ $search }}">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
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
                                    <th>Verified</th>
                                    <th>Status</th>
                                    <th>Trial</th>
                                    <th>Subscription</th>

                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->display_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                          @if($user->verified)
                                            <span class="button-checkbox">
                                            <button type="submit" class="btn btn-success">Verified</button>
                                            </span>
                                          @else
                                            <span class="button-checkbox">
                                            <button type="submit" class="btn btn-info">Pending</button>
                                            </span>
                                          @endif
                                        </td>
                                        <td>

                                          <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.users.toggleActiveToIndex', $user->id) }}">
                                          {!! csrf_field() !!}
                                          <span class="button-checkbox">
                                          <button type="submit" class="btn {{ ($user->activated) ? 'btn-success' : 'btn-default' }}" {{ ($user->activated) ? 'checked' : '' }}>{{ ($user->activated) ? 'Active' : 'Inactive' }}</button>
                                          </span>
                                        </form>

                                        </td>
                                        <td>
                                          <span class="button-checkbox">
                                          <button type="submit" class="btn
                                          @if(is_null($user->trialExpired()))
                                            btn-default
                                          @elseif($user->trialExpired())
                                            btn-danger
                                          @else
                                            btn-success
                                          @endif
                                          "
                                          class="
                                          @if(is_null($user->trialExpired()))
                                            default
                                          @elseif($user->trialExpired())
                                            danger
                                          @else
                                            success
                                          @endif
                                          ">
                                          @if(is_null($user->trialExpired()))
                                            Inactive
                                          @elseif($user->trialExpired())
                                            Expired
                                          @else
                                            On-Trial
                                          @endif
                                        </button>
                                          </span>

                                        </td>
                                        <td>
                                          <span class="button-checkbox">
                                          <button type="submit" class="btn
                                          @if(is_null($user->subscriptionExpired()))
                                            btn-default
                                          @elseif($user->subscriptionExpired())
                                            btn-danger
                                          @else
                                            btn-success
                                          @endif
                                          "
                                          class="
                                          @if(is_null($user->subscriptionExpired()))
                                            default
                                          @elseif($user->subscriptionExpired())
                                            danger
                                          @else
                                            success
                                          @endif
                                          ">
                                          @if(is_null($user->subscriptionExpired()))
                                            Inactive
                                          @elseif($user->subscriptionExpired())
                                            Expired
                                          @else
                                            Active
                                          @endif
                                        </button>
                                          </span>

                                        </td>


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

        @if($users->hasPages())
            <div class="text-center">
                {!! $users->render() !!}
            </div>
        @endif
    </div>
@endsection
