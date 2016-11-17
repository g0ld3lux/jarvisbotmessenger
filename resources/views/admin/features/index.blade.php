@extends('admin.layouts.app')

@section('content')
  <div class="content-header">
      <div class="container">
          <div class="clearfix">
              <div class="pull-left content-header-title">Features</div>
              <div class="pull-right content-header-actions">
                  <a href="{{ route('admin.features.create') }}" class="btn btn-primary"><i class="fa fa-btn fa-plus"></i>Add Features</a>
              </div>
          </div>
      </div>
  </div>
  <div class="container">
      @notification()

      <div class="row">
          <div class="col-md-10 col-md-push-1">
              <div class="panel panel-default">
                  <form method="GET" action="{{ route('admin.features.index') }}">
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

      <div class="row">
          <div class="col-md-12">
              <div class="panel panel-default">
                  @if(count($features) <= 0)
                      <div class="panel-body">
                          There is no registered features! <a href="{{ route('admin.features.create') }}">Add</a> new Feature.
                      </div>
                  @else
                      <table class="table custom-table">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Name</th>
                                  <th>Status</th>
                                  <th>&nbsp;</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($features as $feature)
                                  <tr>
                                      <td>{{ $feature->id }}</td>
                                      <td>{{ $feature->name }}</td>
                                      <td>
                                      <form class="form-horizontal" role="form" method="GET" action="{{ route('admin.features.toggleActive', $feature->id) }}">
                                      {!! csrf_field() !!}
                                      <span class="button-checkbox">
                                      <button type="submit" class="btn {{ ($feature->active === true) ? 'btn-success' : '' }}" class="success" {{ ($feature->active === true) ? 'checked' : '' }}>{{ ($feature->active === true) ? 'Active' : 'Inactive' }}</button>
                                      </span>
                                    </form>
                                      </td>


                                      <td class="text-right">
                                          <form action="{{ route('admin.features.destroy', $feature->id) }}" method="POST">
                                              {!! csrf_field() !!}
                                              {!! method_field('DELETE') !!}
                                              <button type="submit" class="btn btn-danger confirm-action" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                                              <a href="{{ route('admin.features.edit', $feature->id) }}" class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                              <a href="{{ route('admin.features.show', $feature->id) }}" class="btn btn-default" data-toggle="tooltip" title="Details"><i class="fa fa-arrow-right"></i></a>
                                          </form>
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  @endif
              </div>
          </div>
      </div>

      @if($features->hasPages())
          <div class="text-center">
              {!! $features->render() !!}
          </div>
      @endif
  </div>
@endsection
