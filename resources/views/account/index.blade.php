@extends('layouts.app')

@section('css')
<style>
section {
    padding: 5px 0;
    text-align: center;
}

.input-group {
    margin: 20px auto;
    width: 100%;
}
input.btn.btn-lg,
input.btn.btn-lg:focus {
    outline: none;
    width: 60%;
    height: 60px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
button.btn {
    width: 100%;
    height: 60px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}
.reminder {
    color: #999;
}

</style>
@endsection

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
            </div>
        </div>
    </div>

    <div class="container">
        @notification()

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li class="{{ old('tab', 'general') == 'general' ? 'active' : '' }}"><a href="#general" data-toggle="tab" aria-expanded="true">General</a></li>
                    <li class="{{ old('tab', 'general') == 'password' ? 'active' : '' }}"><a href="#password" data-toggle="tab" aria-expanded="true">Password</a></li>
                    <li class="{{ old('tab', 'general') == 'delete' ? 'active' : '' }}"><a href="#delete" data-toggle="tab" aria-expanded="false">Delete account</a></li>
                    <li class="{{ old('tab', 'general') == 'google2fa' ? 'active' : '' }}"><a href="#google2fa" data-toggle="tab" aria-expanded="false">Two-Factor</a></li>
                </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade {{ old('tab', 'general') == 'general' ? ' active in' : '' }}" id="general">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('account.update') }}">
                                    {!! csrf_field() !!}

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label">Email</label>

                                        <div class="col-md-6">
                                          @if($user->email)
                                          <p class="form-control-static">{{ $user->email }}</p>
                                          @else
                                          <input type="text" class="form-control" name="email" placeholder="Enter Your Email Address!">
                                          @endif
                                          @if ($errors->has('email'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('email') }}</strong>
                                              </span>
                                          @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label">Name</label>

                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-btn fa-save"></i>Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade {{ old('tab', 'general') == 'password' ? ' active in' : '' }}" id="password">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('account.password') }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="tab" value="password">

                                    <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label">Old passsword</label>

                                        <div class="col-md-6">
                                            <input type="password" class="form-control" name="old_password">

                                            @if ($errors->has('old_password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('old_password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label">New passsword</label>

                                        <div class="col-md-6">
                                            <input type="password" class="form-control" name="new_password">

                                            @if ($errors->has('new_password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('new_password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label">Confirm new password</label>

                                        <div class="col-md-6">
                                            <input type="password" class="form-control" name="new_password_confirmation">

                                            @if ($errors->has('new_password_confirmation'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-btn fa-save"></i>Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade{{ old('tab', 'general') == 'delete' ? ' active in' : '' }}" id="delete">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('account.delete') }}">
                                    {!! csrf_field() !!}
                                    {!! method_field('DELETE') !!}
                                    <input type="hidden" name="tab" value="delete">

                                    <div class="alert alert-danger" role="alert">
                                        To delete your account, please enter the account password as a confirmation. Your account will be deleted immediately. Account recovery is impossible once the account is deleted.
                                    </div>

                                    <div class="form-group{{ $errors->has('delete_password') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label">Password</label>

                                        <div class="col-md-6">
                                            <input type="password" class="form-control" name="delete_password" value="{{ old('delete_password') }}">

                                            @if ($errors->has('delete_password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('delete_password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-btn fa-trash"></i>Delete
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade {{ old('tab', 'general') == 'google2fa' ? ' active in' : '' }}" id="google2fa">
                                @if(!$user->google2fa_on)

                                <section>
                                <div class="container">
                                  <div class="row">
                                    <hgroup>
                                      <h2>Enable Two Factor Authentication</h2>
                                     </hgroup>
                                    <img src="{{ $google2fa_url }}">
                                  </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                       <div class="form-group{{ $errors->has('secret') ? ' has-error' : '' }}">
                                             <form class="form-horizontal" role="form" method="POST" action="{{ route('account.enable2Factor') }}">
                                            {!! csrf_field() !!}
                                                 <div class="input-group input-group-lg">
                                <span class="input-group-addon" id="sizing-addon1">TOKEN</span>
                                <input type="text" name="secret" class="form-control" placeholder="######" aria-describedby="sizing-addon1">
                                                </div>
                                                 <button class="btn btn-info btn-lg" type="submit">Enable</button>
                                             </form>
                                       </div>
                                         <small class="reminder"><em>If You Cant Access Your Phone Please Contact Our Support.</em></small>
                                    </div>
                                  </div>
                                </div>
                                </section>
                                @else
                                  <section>
                                  <div class="container">
                                    <div class="row">
                                      <div class="col-md-6 col-md-offset-3">
                                  <form class="form-horizontal" role="form" method="POST" action="{{ route('account.disable2Factor') }}">
                                    {!! csrf_field() !!}
                                    <hgroup>
                                      <h2>Disable Two Factor Authentication</h2>
                                     </hgroup>
                                    <button class="btn btn-info btn-lg" type="submit">Disable</button>
                                  </form>
                                  </div>
                                  </div>
                                </div>
                              </section>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
