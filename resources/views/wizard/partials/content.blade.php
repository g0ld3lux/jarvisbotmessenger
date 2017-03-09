<div class="col-md-10 col-md-push-1 col-lg-8 col-lg-push-2 col-sm-12">
    {!! Form::open([
        'route' => ['setup_wizard.submit', $currentStep->getSlug()],
        'files' => true,
    ]) !!}

    <div class="sw-wizard">
        <div class="sw-step-header">
            <h3 class="sw-step-title">{!! trans('wizard::steps.' . $currentStep->getId() . '.title') !!}</h3>
        </div>

        <div class="sw-breadcrumb">
            @include('wizard::partials.breadcrumb')
        </div>

        <div class="sw-description">
            <h4>{!! trans('wizard::steps.' . $currentStep->getId() . '.description') !!}</h4>
        </div>

        <div class="sw-errors">
            @if ($errors->has())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif
        </div>

        <div class="sw-step-form">
            @include('wizard::partials.steps.' . $currentStep->getId(), $currentStep->getFormData())
        </div>

        <div class="sw-navigation">
            @include('wizard::partials.navigation')
        </div>
    </div>

    {!! Form::close() !!}
    @stack('ajax')
</div>

