@extends('layouts.app')

@section('css')
<style>
.btn-social{position:relative;padding-left:44px;text-align:left;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.btn-social :first-child{position:absolute;left:0;top:0;bottom:0;width:32px;line-height:34px;font-size:1.6em;text-align:center;border-right:1px solid rgba(0,0,0,0.2)}
.btn-social.btn-lg{padding-left:61px}.btn-social.btn-lg :first-child{line-height:45px;width:45px;font-size:1.8em}
.btn-social.btn-sm{padding-left:38px}.btn-social.btn-sm :first-child{line-height:28px;width:28px;font-size:1.4em}
.btn-social.btn-xs{padding-left:30px}.btn-social.btn-xs :first-child{line-height:20px;width:20px;font-size:1.2em}
.btn-social-icon{position:relative;padding-left:44px;text-align:left;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;height:34px;width:34px;padding-left:0;padding-right:0}.btn-social-icon :first-child{position:absolute;left:0;top:0;bottom:0;width:32px;line-height:34px;font-size:1.6em;text-align:center;border-right:1px solid rgba(0,0,0,0.2)}
.btn-social-icon.btn-lg{padding-left:61px}.btn-social-icon.btn-lg :first-child{line-height:45px;width:45px;font-size:1.8em}
.btn-social-icon.btn-sm{padding-left:38px}.btn-social-icon.btn-sm :first-child{line-height:28px;width:28px;font-size:1.4em}
.btn-social-icon.btn-xs{padding-left:30px}.btn-social-icon.btn-xs :first-child{line-height:20px;width:20px;font-size:1.2em}
.btn-social-icon :first-child{border:none;text-align:center;width:100% !important}
.btn-social-icon.btn-lg{height:45px;width:45px;padding-left:0;padding-right:0}
.btn-social-icon.btn-sm{height:30px;width:30px;padding-left:0;padding-right:0}
.btn-social-icon.btn-xs{height:22px;width:22px;padding-left:0;padding-right:0}
.btn-jarvis{color:#fff;background-color:#205081;border-color:rgba(0,0,0,0.2)}.btn-jarvis:hover,.btn-jarvis:focus,.btn-jarvis:active,.btn-jarvis.active,.open .dropdown-toggle.btn-jarvis{color:#fff;background-color:#183c60;border-color:rgba(0,0,0,0.2)}
.btn-jarvis:active,.btn-jarvis.active,.open .dropdown-toggle.btn-jarvis{background-image:none}
.btn-jarvis.disabled,.btn-jarvis[disabled],fieldset[disabled] .btn-jarvis,.btn-jarvis.disabled:hover,.btn-jarvis[disabled]:hover,fieldset[disabled] .btn-jarvis:hover,.btn-jarvis.disabled:focus,.btn-jarvis[disabled]:focus,fieldset[disabled] .btn-jarvis:focus,.btn-jarvis.disabled:active,.btn-jarvis[disabled]:active,fieldset[disabled] .btn-jarvis:active,.btn-jarvis.disabled.active,.btn-jarvis[disabled].active,fieldset[disabled] .btn-jarvis.active{background-color:#205081;border-color:rgba(0,0,0,0.2)}

.btn-facebook{color:#fff;background-color:#3b5998;border-color:rgba(0,0,0,0.2)}.btn-facebook:hover,.btn-facebook:focus,.btn-facebook:active,.btn-facebook.active,.open .dropdown-toggle.btn-facebook{color:#fff;background-color:#30487b;border-color:rgba(0,0,0,0.2)}
.btn-facebook:active,.btn-facebook.active,.open .dropdown-toggle.btn-facebook{background-image:none}
.btn-facebook.disabled,.btn-facebook[disabled],fieldset[disabled] .btn-facebook,.btn-facebook.disabled:hover,.btn-facebook[disabled]:hover,fieldset[disabled] .btn-facebook:hover,.btn-facebook.disabled:focus,.btn-facebook[disabled]:focus,fieldset[disabled] .btn-facebook:focus,.btn-facebook.disabled:active,.btn-facebook[disabled]:active,fieldset[disabled] .btn-facebook:active,.btn-facebook.disabled.active,.btn-facebook[disabled].active,fieldset[disabled] .btn-facebook.active{background-color:#3b5998;border-color:rgba(0,0,0,0.2)}
.btn-twitter{color:#fff;background-color:#2ba9e1;border-color:rgba(0,0,0,0.2)}.btn-twitter:hover,.btn-twitter:focus,.btn-twitter:active,.btn-twitter.active,.open .dropdown-toggle.btn-twitter{color:#fff;background-color:#1c92c7;border-color:rgba(0,0,0,0.2)}
.btn-twitter:active,.btn-twitter.active,.open .dropdown-toggle.btn-twitter{background-image:none}
.btn-twitter.disabled,.btn-twitter[disabled],fieldset[disabled] .btn-twitter,.btn-twitter.disabled:hover,.btn-twitter[disabled]:hover,fieldset[disabled] .btn-twitter:hover,.btn-twitter.disabled:focus,.btn-twitter[disabled]:focus,fieldset[disabled] .btn-twitter:focus,.btn-twitter.disabled:active,.btn-twitter[disabled]:active,fieldset[disabled] .btn-twitter:active,.btn-twitter.disabled.active,.btn-twitter[disabled].active,fieldset[disabled] .btn-twitter.active{background-color:#2ba9e1;border-color:rgba(0,0,0,0.2)}
.btn-google-plus{color:#fff;background-color:#dd4b39;border-color:rgba(0,0,0,0.2)}.btn-google-plus:hover,.btn-google-plus:focus,.btn-google-plus:active,.btn-google-plus.active,.open .dropdown-toggle.btn-google-plus{color:#fff;background-color:#ca3523;border-color:rgba(0,0,0,0.2)}
.btn-google-plus:active,.btn-google-plus.active,.open .dropdown-toggle.btn-google-plus{background-image:none}
.btn-google-plus.disabled,.btn-google-plus[disabled],fieldset[disabled] .btn-google-plus,.btn-google-plus.disabled:hover,.btn-google-plus[disabled]:hover,fieldset[disabled] .btn-google-plus:hover,.btn-google-plus.disabled:focus,.btn-google-plus[disabled]:focus,fieldset[disabled] .btn-google-plus:focus,.btn-google-plus.disabled:active,.btn-google-plus[disabled]:active,fieldset[disabled] .btn-google-plus:active,.btn-google-plus.disabled.active,.btn-google-plus[disabled].active,fieldset[disabled] .btn-google-plus.active{background-color:#dd4b39;border-color:rgba(0,0,0,0.2)}

</style>

@endsection
@section('content')
<div class="container auth">


      <div id="loginbox" class="mainbox col-md-8 col-md-offset-2">
          <div class="panel panel-default" >
                  <div class="panel-heading">
                      <div class="panel-title">Sign In</div>
                      <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="{{ url('/password/reset') }}">Forgot password?</a></div>
                  </div>

                  <div style="padding-top:30px" class="panel-body" >

                      @notification()
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                          {!! csrf_field() !!}

                          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                          <div class="col-xs-12">
                            <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="login-username" type="text" class="form-control" name="email" placeholder="email" value="{{ old('email') }}">
                            </div>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                          </div>

                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="col-xs-12">
                          <div  class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                      <input id="login-password" type="password" class="form-control" name="password" placeholder="password" value="{{ old('password') }}">
                          </div>
                          @if ($errors->has('password'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('password') }}</strong>
                              </span>
                          @endif
                        </div>
                        </div>

                        <div class="col-xs-12" style="margin-bottom: 10px;">
                        <div class="input-group">
                            <div class="checkbox">
                              <label>
                                <input id="login-remember" type="checkbox" name="remember" value="1"> Remember me
                              </label>
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6 col-md-offset-3">
                        <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}" style="margin-bottom:25px">

                          {!! app('captcha')->display() !!}
                          @if ($errors->has('g-recaptcha-response'))
                              <span class="help-block text-center">
                                  <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                              </span>
                          @endif
                        </div>

                      </div>


                      <div class="col-xs-12" style="padding-top: 30px;">
                              <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                <div class="btn-group" role="group">
                                <button class="btn btn-block btn-social btn-jarvis" type="submit">
                                        <i class="fa fa-android"></i> Login Using Email
                                </button>
                              </div>
                            </div>
                            <h4 class="text-center">OR</h4>
                            <a class="btn btn-block btn-social btn-facebook" href="{{ config('services.facebook.redirect_link') }}">
                                    <i class="fa fa-facebook"></i> Sign in with Facebook
                            </a>
                            <a class="btn btn-block btn-social btn-google-plus" href="{{ config('services.google.redirect_link') }}">
                            <i class="fa fa-google-plus"></i> Sign in with Google
                            </a>
                            <a class="btn btn-block btn-social btn-twitter" href="{{ config('services.twitter.redirect_link') }}">
                            <i class="fa fa-twitter"></i> Sign in with Twitter
                            </a>
                              <div class="form-group">
                                  <div class="col-md-12 control">
                                      <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                          Don't have an account!
                                      <a href="{{ url('register') }}">
                                          Sign Up Here
                                      </a>
                                      </div>
                                  </div>
                              </div>
                            </div>
                          </form>



                      </div>
                  </div>
      </div>
</div>
@endsection
