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
        <div id="signupbox" class="mainbox col-md-8 col-md-offset-2">
          <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Create an Account</div>
                    <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="privacy" >Privacy Policy</a></div>
                </div>
                <div style="padding-top:30px" class="panel-body" >
                  @notification()
                  <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Note:</strong> By Submitting The Form, You Have Agreed to Our Terms and Services.
                  </div>
                  <form id="signupform" class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                    {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                          <div class="col-xs-12">
                            <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="name" type="text" class="form-control" name="name" placeholder="Full Name" value="{{ old('name') }}">
                            </div>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                          </div>
                      </div>
                      <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="col-xs-12">
                          <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                      <input id="email" type="text" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}">
                          </div>
                          @if ($errors->has('email'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('email') }}</strong>
                              </span>
                          @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                      <div class="col-xs-12">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>

                                    <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                      </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                      <div class="col-xs-12">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-ok-sign"></i></span>

                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                        </div>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                      </div>
                    </div>

                    <div class="form-group{{ $errors->has('icode') ? ' has-error' : '' }}">
                      <div class="col-xs-12">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-console"></i></span>

                                    <input id="icode" type="text" class="form-control" name="icode" placeholder="Invitation Code">
                        </div>
                        @if ($errors->has('icode'))
                            <span class="help-block">
                                <strong>{{ $errors->first('icode') }}</strong>
                            </span>
                        @endif
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
                                  <i class="fa fa-android"></i> Start Creating Bots!
                          </button>
                          </div>
                        </div>
                          <h4 class="text-center">OR</h4>
                          <a class="btn btn-block btn-social btn-facebook" href="{{ config('services.facebook.redirect_link') }}">
                                  <i class="fa fa-facebook"></i> Sign Up with Facebook
                          </a>
                          <a class="btn btn-block btn-social btn-google-plus" href="{{ config('services.google.redirect_link') }}">
                          <i class="fa fa-google-plus"></i> Sign Up with Google
                          </a>
                          <a class="btn btn-block btn-social btn-twitter" href="{{ config('services.twitter.redirect_link') }}">
                          <i class="fa fa-twitter"></i> Sign Up with Twitter
                          </a>
                          <div class="form-group">
                              <div class="col-md-12 control">
                                  <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                      Already Have an Account?
                                  <a href="{{ url('login') }}">
                                      Login Here.
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
