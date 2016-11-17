@extends('admin.layouts.app')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left content-header-title"><a href="{{ route('admin.packages.index') }}">Packages</a> &raquo; View Package</div>
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
          <form class="form-horizontal">

          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="name" class="control-label col-md-3">Name *</label>
                      <div class="col-md-9">
                          <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-font-awesome"></i></span>
                              <input class="form-control" placeholder="Package Name" name="name" type="text" id="name" value="{{ $package->name }}" readonly>

                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="cost" class="control-label col-md-3">Cost *</label>
                      <div class="col-md-9">
                          <div class="input-group">
                              <span class="input-group-addon"><i
                                          class="fa fa-money"></i></span>
                              <input class="form-control" name="cost" type="number" id="cost" value="{{ $package->cost }}" readonly>
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="cost" class="control-label col-md-3">Currency Code *</label>
                      <div class="col-md-9">
                          <div class="input-group">
                              <span class="input-group-addon"><i
                                          class="fa fa-usd"></i></span>
                              <input class="form-control" name="currency_code" type="text" id="currency_code" value="{{ $package->currency_code }}" readonly>

                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="cost_per" class="control-label col-md-3">Cost Per *</label>
                      <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon"><i
                                        class="fa fa-calendar"></i></span>
                            <input class="form-control" name="per" type="text" id="per" value="{{ $package->per }}" readonly>

                        </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="plan" class="control-label col-md-3">Plan *</label>
                      <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon"><i
                                        class="fa fa-dropbox"></i></span>
                            <input class="form-control" name="plan" type="text" id="plan" value="{{ $package->plan }}" readonly>
                        </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="status" class="control-label col-md-3">Status</label>
                      <div class="col-sm-8">
                          <label class="col-md-4 control-label">
                          <span class="button-checkbox">
                            <button type="button" class="btn" data-color="success">Active</button>

                            <input type="checkbox" class="hidden" name="active"
                              {{ $package->active === true ? 'checked' : '' }}
                            >
                          </span>
                          </label>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="status" class="control-label col-md-3">Featured</label>
                      <div class="col-sm-8">
                          <label class="col-md-4 control-label">
                          <span class="button-checkbox">
                            <button type="button" class="btn" data-color="success">Yes</button>
                            <input type="checkbox" class="hidden" name="featured"
                              {{ $package->featured === true ? 'checked' : '' }}
                            >
                          </label>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="pricing_order" class="control-label col-md-3">Package Order *</label>
                      <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon"><i
                                        class="fa fa-bars"></i></span>
                            <input class="form-control" name="order" type="number" id="order" value="{{ (empty($package->order)) ? 0 : $package->order }}" readonly>
                        </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-md-9 col-md-offset-3">

                          <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-warning"  title="Edit"><i class="fa fa-pencil"></i> Edit Package</a>
                          <a href="{{ route('admin.packages.index') }}" class="btn btn-default"  title="Edit"><i class="fa fa-arrow-left"></i> Back To Package</a>

                      </div>
                  </div>
              </div><!-- .col-md-6 -->
              <div class="col-md-6">
                  <h4>Feature List To Enable</h4>

                  @if(!empty($featurelist))
                  <!-- START FOREACH LOOP -->
                  @foreach($featurelist as $id => $val)
                    {{--*/ $feature_description = 'feature_description.' /*--}}
                    {{--*/ $feature_active = 'feature_active.' /*--}}
                      <div class="form-group">
                        <label for="features" class="col-md-12" style="text-align:left;">
                          <span class="button-checkbox">
                            <button type="button" class="btn" data-color="success">{{ $val }}</button>

                            <input type="checkbox" class="hidden" name="feature_active[{{ $id }}]"
                            @foreach($activelist as $key => $value)
                            @if($id === $key)
                            checked
                            @endif
                            @endforeach
                            readonly>

                          </span>
                        </label>

                          <div class="col-md-12">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="fa fa-info"></i>
                                  </span>
                                  <input name="feature_id[{{ $id }}]" type="hidden" class="hidden" value="{{ $id }}">
                                  <input class="form-control" name="feature_description[{{ $id }}]" type="text" id="feature_description{{ $id }}"

                                  @foreach($activelist as $key => $value)
                                  @if ($id === $key)
                                  value="{{ $value }}"
                                  @endif
                                  @endforeach
                                  readonly>

                                </div>

                          </div>
                      </div>
                    @endforeach
                    <!-- END FOREACH LOOP -->
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
