@extends('admin.layouts.app')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left content-header-title"><a href="{{ route('admin.features.index') }}">Features</a> &raquo; View Feature</div>
            </div>
        </div>
    </div>

    <div class="container">
        @notification()

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                            <div>
                                <label>Name</label>
                                <div>
                                    <input type="text" class="form-control" name="name" value="{{ $feature->name }}" readonly>
                                </div>
                            </div>

                            <div>
                            <span class="button-checkbox">
                            <button type="button" class="btn {{ ($feature->active === true) ? 'btn-success' : '' }}" class="success">{{ ($feature->active === true) ? 'Active' : 'Inactive' }}</button>
                            <a href="{{ route('admin.features.index') }}" class="btn btn-default" data-toggle="tooltip" title="Back To Features"><i class="fa fa-arrow-left"></i></a>
                            <a href="{{ route('admin.features.edit', $feature->id) }}" class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>

                            </span>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
