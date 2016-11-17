@extends('admin.layouts.app')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left content-header-title"><a href="{{ route('admin.packages.index') }}">Packages</a> &raquo; Add Package</div>
            </div>
        </div>
    </div>

    <div class="container">
        @notification()

        <div class="row">
          <div class="box">
      <div class="box-header with-border">
          <h3 class="box-title">Package Details Form</h3>

      </div>
      <div class="box-body">
          <form method="POST" action="{{ route('admin.packages.store') }}" accept-charset="UTF-8" class="form-horizontal" id="validate">
          {!! csrf_field() !!}

          <div class="row">
              <div class="col-md-6">
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                      <label for="name" class="control-label col-md-3">Name *</label>
                      <div class="col-md-9">
                          <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-font-awesome"></i></span>
                              <input class="form-control validate[required]" placeholder="Package Name" name="name" type="text" id="name" value="{{ old('name') }}">

                          </div>
                          @if ($errors->has('name'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('name') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
                      <label for="cost" class="control-label col-md-3">Cost *</label>
                      <div class="col-md-9">
                          <div class="input-group">
                              <span class="input-group-addon"><i
                                          class="fa fa-money"></i></span>
                              <input class="form-control validate[required,custom[number],min[0]]" placeholder="Amount: 100.00" step="0.01" name="cost" type="number" id="cost" value="{{ old('cost') }}">
                          </div>
                          @if ($errors->has('cost'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('cost') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('currency_code') ? ' has-error' : '' }}">
                      <label for="cost" class="control-label col-md-3">Currency Code *</label>
                      <div class="col-md-9">
                          <div class="input-group">
                              <span class="input-group-addon"><i
                                          class="fa fa-usd"></i></span>
                              <input class="form-control validate[required]" placeholder="USD" name="currency_code" type="text" id="currency_code" value="{{ old('currency_code') }}">

                          </div>
                          @if ($errors->has('currency_code'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('currency_code') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('per') ? ' has-error' : '' }}">
                      <label for="cost_per" class="control-label col-md-3">Cost Per *</label>
                      <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon"><i
                                        class="fa fa-calendar"></i></span>
                            <input class="form-control validate[required]" placeholder="month / year / lifetime" name="per" type="text" id="per" value="{{ old('per') }}">

                        </div>
                          @if ($errors->has('per'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('per') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('plan') ? ' has-error' : '' }}">
                      <label for="plan" class="control-label col-md-3">Plan *</label>
                      <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon"><i
                                        class="fa fa-dropbox"></i></span>
                            <input class="form-control validate[required]" placeholder="Subscription Plan ID" name="plan" type="text" id="plan" value="{{ old('plan') }}">
                        </div>
                          @if ($errors->has('plan'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('plan') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                      <label for="status" class="control-label col-md-3">Status</label>
                      <div class="col-sm-8">
                          <label class="col-md-4 control-label">
                          <span class="button-checkbox">
                            <button type="button" class="btn" data-color="success">Active</button>
                            <input type="checkbox" class="hidden" name="active" {{ (old('active') === 'on') ? 'checked' : '' }} />
                          </span>
                          </label>
                          @if ($errors->has('active'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('active') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('featured') ? ' has-error' : '' }}">
                      <label for="status" class="control-label col-md-3">Featured</label>
                      <div class="col-sm-8">
                          <label class="col-md-4 control-label">
                          <span class="button-checkbox">
                            <button type="button" class="btn" data-color="success">Yes</button>
                            <input type="checkbox" class="hidden" name="featured" {{ (old('featured') === 'on') ? 'checked' : '' }}/>
                          </span>
                          </label>
                          @if ($errors->has('featured'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('featured') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
                      <label for="pricing_order" class="control-label col-md-3">Package Order *</label>
                      <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon"><i
                                        class="fa fa-bars"></i></span>
                            <input class="form-control validate[required,custom[integer],min[1]]" placeholder="Set Chronological Order" name="order" type="number" id="order" value="{{ old('order') }}">
                        </div>
                          @if ($errors->has('order'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('order') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-md-9 col-md-offset-3">
                          <input class="btn btn-primary" type="submit" value="Add Package">
                      </div>
                  </div>
              </div><!-- .col-md-6 -->
              <div class="col-md-6">
                  <h4>Feature List To Enable</h4>

                  @if(!empty($featurelist))
                  @foreach($featurelist as $id => $val)
                    {{--*/ $feature_description = 'feature_description.' /*--}}
                    {{--*/ $feature_active = 'feature_active.' /*--}}
                      <div class="form-group{{ $errors->has($feature_description.$id) ? ' has-error' : '' }} {{ $errors->has($feature_active.$id) ? ' has-error' : '' }}">
                        <label for="features" class="col-md-12" style="text-align:left;">
                          <span class="button-checkbox">
                            <button type="button" class="btn" data-color="success">{{ $val }}</button>
                            <input type="checkbox" class="hidden" name="feature_active[{{ $id }}]" {{ (old($feature_active.$id) === 'on') ? 'checked' : '' }}/>
                          </span>
                        </label>
                        @if ($errors->has($feature_active.$id))
                            <span class="help-block">
                                <strong>{{ $errors->first($feature_active.$id) }}</strong>
                            </span>
                        @endif
                          <div class="col-md-12">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="fa fa-info"></i>
                                  </span>
                                  <input name="feature_id[{{ $id }}]" type="hidden" class="hidden" value="{{ $id }}">
                                  <input class="form-control validate[required]" placeholder="Describe This Feature For this Package" name="feature_description[{{ $id }}]" type="text" id="feature_description{{ $id }}" value="{{ old($feature_description.$id) }}">
                              </div>
                              @if ($errors->has($feature_description.$id))
                                  <span class="help-block">
                                      <strong>{{ $errors->first($feature_description.$id) }}</strong>
                                  </span>
                              @endif
                          </div>
                      </div>
                @endforeach
                @else
                  <div class="panel-body">
                      There is no registered features! <a href="{{ route('admin.features.create') }}">Add</a> new Feature
                  </div>
              @endif
              </div><!-- .col-md-6 -->
          </div><!-- .row -->
          </form>
      </div><!-- /.box-body -->
      <div class="box-footer">
      </div><!-- /.box-footer-->
  </div><!-- /.box -->
        </div>
    </div>

@endsection

@push('scripts')
<script>
$(function () {
    $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active');

            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
            }
        }
        init();
    });
});
</script>
@endpush
