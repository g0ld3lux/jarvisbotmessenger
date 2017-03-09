@extends('wizard::layouts.wizard')

@section('page.title')
    {{ trans('wizard::steps.' . $currentStep->getId() . '.title') }}
@endsection

@section('wizard.header')
    <h3 class="sw-step-title">{!! trans('wizard::steps.' . $currentStep->getId() . '.title') !!}</h3>
@endsection

@section('wizard.breadcrumb')
    @include('wizard::partials.breadcrumb')
@endsection

@section('wizard.errors')
    @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
@endsection

@section('wizard.description')
    <h4>{!! trans('wizard::steps.' . $currentStep->getId() . '.description') !!}</h4>
@endsection

@section('wizard.form')
    @include('wizard::partials.steps.' . $currentStep->getId(), $currentStep->getFormData())
@endsection

@section('wizard.navigation')
    @include('wizard::partials.navigation')
@endsection
