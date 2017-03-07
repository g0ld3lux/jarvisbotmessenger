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
                        <div class="form-horizontal">
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
                                        <label class="col-md-4 control-label">Account Status</label>

                                        <div class="col-md-6">

                                            <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.users.toggleActiveToShow', $user->id) }}">
                                            {!! csrf_field() !!}
                                            <span class="button-checkbox">
                                            <button type="submit" class="btn {{ ($user->activated) ? 'btn-success' : 'btn-default' }}" {{ ($user->activated) ? 'checked' : '' }}>{{ ($user->activated) ? 'Active' : 'Inactive' }}</button>
                                            </span>
                                          </form>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Email Verified</label>

                                        <div class="col-md-6">

                                              @if($user->verified)
                                                <span class="button-checkbox">
                                                <button type="submit" class="btn btn-success">Verified</button>
                                                </span>
                                              @else

                                                <form class="form-horizontal" role="form" method="GET" action="{{ route('admin.users.resendActivationEmail', $user->id) }}">
                                                {!! csrf_field() !!}
                                                <span class="label label-info">Pending</span>
                                                <button type="submit" class="btn btn-warning confirm-action" data-toggle="tooltip" title="Resend Email"><i class="fa fa-envelope"></i></button>
                                                </form>

                                              @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Trial Status</label>

                                        <div class="col-md-6">

                                              @if(is_null($user->trialExpired()))
                                                <span class="button-checkbox">
                                                <button type="submit" class="btn">Not Enroll</button>
                                                </span>
                                              @elseif($user->trialExpired())
                                                <span class="button-checkbox">
                                                <button type="submit" class="btn btn-danger">Expired</button>
                                                </span>
                                              @else
                                                <span class="button-checkbox">
                                                <button type="submit" class="btn btn-success">Enrolled</button>
                                                </span>
                                                <a href="{{ route('admin.users.removeTrial', $user->id) }}" class="btn btn-danger confirm-action" data-toggle="tooltip" title="Remove Free Trial"><i class="fa fa-ban"></i></a>
                                              @endif

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Subscription Status</label>

                                        <div class="col-md-6">
                                              @if(is_null($user->subscriptionExpired()))
                                                <span class="button-checkbox">
                                                <button type="submit" class="btn">Not Enroll</button>
                                                </span>
                                              @elseif($user->subscriptionExpired())
                                                <span class="button-checkbox">
                                                <button type="submit" class="btn btn-danger">Expired</button>
                                                </span>
                                              @else
                                                <span class="button-checkbox">
                                                <button type="submit" class="btn btn-success">Enrolled</button>
                                                </span>
                                              @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Trial Ends At</label>

                                        <div class="col-md-6">

                                              @if(is_null($user->trialExpired()))
                                                <span class="label label-default">N/A</span>
                                                <a href="{{ route('admin.users.refreshTrial', $user->id) }}" class="btn btn-success confirm-action" data-toggle="tooltip" title="Give Free Trial"><i class="fa fa-plus-square"></i></a>
                                              @else
                                                <p class="form-control-static">
                                                <span class="label label-info">{{ $user->trial_ends_at->format('F j, Y, g:i A') }}</span>
                                              </p>
                                              @endif


                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Subscription Ends At</label>

                                        <div class="col-md-6">

                                              @if(is_null($user->subscriptionExpired()))
                                                <span class="button-checkbox">
                                                <button type="submit" class="btn">N/A</button>
                                                </span>
                                              @else
                                                <p class="form-control-static">
                                                {{ $user->subscription_ends_at->format('F j, Y, g:i A') }}
                                                </p>
                                              @endif

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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    @if(count($bots) <= 0)
                        <div class="panel-body">
                            User has no bots!
                        </div>
                    @else
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>Bot</th>
                                    <th>Recipients</th>
                                    <th>Flows</th>
                                    <th>Created</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bots as $bot)
                                    <tr>
                                        <td>{{ $bot->title }}</td>
                                        <td>{{ $bot->recipients()->count() }}</td>
                                        <td>{{ $bot->flows()->count() }}</td>
                                        <td>{{ $bot->created_at->format('F j, Y, g:i A') }}</td>
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
