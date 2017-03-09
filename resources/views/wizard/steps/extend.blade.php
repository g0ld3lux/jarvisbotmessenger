@extends('layouts.app')

@section('page.title')
    {{ trans('wizard::steps.' . $currentStep->getId() . '.title') }}
@endsection

@push('scripts')
    <link rel="stylesheet" href="{{ asset('wizard/css/' . config('setup_wizard.theme') . '.css') }}">
@endpush


@section('content')
@include('wizard::partials.content')
@endsection