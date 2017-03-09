@unless (SetupWizard::isFirst())
    {{ Form::submit(trans('wizard::views.nav.back'), [
        'name'  => 'wizard-action-back',
        'class' => 'btn btn-default btn-back',
    ]) }}
@endunless

@if (SetupWizard::isLast())
    {{ Form::submit(trans('wizard::views.nav.done'), [
        'name'  => 'wizard-action-next',
        'class' => 'btn btn-primary',
    ]) }}
@else
    {{ Form::submit(trans('wizard::views.nav.next'), [
        'name'  => 'wizard-action-next',
        'class' => 'btn btn-primary',
    ]) }}
@endif