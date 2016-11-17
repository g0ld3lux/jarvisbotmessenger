@extends('layouts.app')

@push('head_scripts')
<style>
.color-1 {
    background-color: #f55039;
}

.color-2 {
    background-color: #46A6F7;
}

.color-3 {
    background-color: #47887E;
}

.color-4 {
    background-color: #F59B24;
}
/*============================================================
PRICING STYLES
==========================================================*/
.package-padding-btm {
    padding-bottom: 50px;
}
.button-color-square {
    color: #fff;
    background-color: rgba(0, 0, 0, 0.50);
    border: none;
    border-radius: 0px;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
}

    .button-color-square:hover {
        color: #fff;
        background-color: rgba(0, 0, 0, 0.50);
        border: none;
    }


.package {
    margin-bottom: 30px;
    margin-top: 50px;
    text-align: center;
    box-shadow: 0 0 5px rgba(0, 0, 0, .5);
    color: #fff;
    line-height: 30px;
}

    .package ul {
        list-style: none;
        margin: 0;
        text-align: center;
        padding-left: 0px;
    }

        .package ul li {
            padding-top: 20px;
            padding-bottom: 20px;
            cursor: pointer;
        }

            .package ul li i {
                margin-right: 5px;
            }


    .package .price {
        background-color: rgba(0, 0, 0, 0.5);
        padding: 40px 20px 20px 20px;
        font-size: 60px;
        font-weight: 900;
        color: #FFFFFF;
    }

        .package .price small {
            color: #B8B8B8;
            display: block;
            font-size: 12px;
            margin-top: 22px;
        }

    .package .type {
        background-color: #607d8b;
        padding: 50px 20px;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 30px;
    }

    .package .pricing-footer {
        padding: 20px;
    }

.package-attached > .col-lg-4,
.package-attached > .col-lg-3,
.package-attached > .col-md-4,
.package-attached > .col-md-3,
.package-attached > .col-sm-4,
.package-attached > .col-sm-3 {
    padding-left: 0;
    padding-right: 0;
}

.package.popular {
    margin-top: 10px;
}

    .package.popular .price {
        padding-top: 80px;
    }
</style>
@endpush

@section('content')
  <div class="content-header">
      <div class="container">
          <div class="clearfix">
              <div class="pull-left content-header-title">Choose a Plan</div>
              <div class="pull-right content-header-actions">
                  <a href="{{ route('account.index') }}" class="btn btn-primary"><i class="fa fa-btn fa-arrow-circle-left"></i>Back To Account</a>
              </div>
          </div>
      </div>
  </div>
  <!-- END CONTENT  HEADER DIV -->
  <div class="container">
    @notification()

    <div class="row">
        <div class="col-md-10 col-md-push-1">
            <div class="panel panel-default">
                <form method="GET" action="{{ route('plans.index') }}">
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
    <div class="row package-padding-btm package-attached">

        @foreach ($packages->chunk(4) as $chunk)
          {{--*/ $count = 1 /*--}}
          @foreach ($chunk as $package)

              <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                  <div class="package-wrapper">
                      <div class="package color-{{ $count ++ }} {{ ($package->featured) ? 'popular' : '' }}">
                          <div class="price">
                              <sup>{{ ($package->currency_code === 'USD') ? '$' : '₱' }}</sup>{{ round($package->cost) }}
                                  <small>per {{ $package->per }}</small>
                          </div>
                          <div class="type">
                              {{ $package->name }}
                          </div>
                          <ul>
                            @foreach($package->features as $feature)
                              <li>{{ $feature->name }}  {!! ($feature->pivot->feature_description === 'Yes') ? '<i class="fa fa-check" aria-hidden="true"></i>' : $feature->pivot->feature_description !!}</li>
                            @endforeach
                          </ul>
                          <div class="pricing-footer">
                            <a href="{{ route('payment.index', ['plan' => $package->plan]) }}" class="btn button-color-square btn-lg" data-toggle="tooltip" title="{{ $package->name }}"><i class="fa fa-cart-arrow-down"></i> Subscribe</a>

                          </div>
                      </div>
                  </div>
              </div>
            @endforeach

          @endforeach

          </div> <!-- END ROW DIV -->

          @if($packages->hasPages())
              <div class="text-center">
                  {!! $packages->render() !!}
              </div>
          @endif
      </div> <!-- END CONTAINER DIV -->
@endsection
