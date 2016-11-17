@extends('admin.layouts.app')

@section('content')
  <div class="content-header">
      <div class="container">
          <div class="clearfix">
              <div class="pull-left content-header-title">Packages</div>
              <div class="pull-right content-header-actions">
                  <a href="{{ route('admin.packages.create') }}" class="btn btn-primary"><i class="fa fa-btn fa-plus"></i>Add Package</a>
              </div>
          </div>
      </div>
  </div>
  <div class="container">
      @notification()

      <div class="row">
          <div class="col-md-10 col-md-push-1">
              <div class="panel panel-default">
                  <form method="GET" action="{{ route('admin.packages.index') }}">
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
                  @if(count($packages) <= 0)
                      <div class="panel-body">
                          There is no registered Packages! <a href="{{ route('admin.packages.create') }}">Add</a> new Package.
                      </div>
                  @else
                      <table class="table custom-table">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Name</th>
                                  <th>Cost</th>
                                  <th>Featured</th>
                                  <th>Status</th>
                                  <th>Created At</th>
                                  <th>&nbsp;</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($packages as $package)
                                  <tr>
                                      <td>{{ $package->id }}</td>
                                      <td>{{ $package->name }}</td>
                                      <td>{{ $package->cost }} {{ $package->currency_code }} per {{ $package->per }}</td>
                                      <td>
                                      <form class="form-horizontal" role="form" method="GET" action="{{ route('admin.packages.toggleFeatured', $package->id) }}">
                                      {!! csrf_field() !!}
                                      <span class="button-checkbox">
                                      <button type="submit" class="btn {{ ($package->featured === true) ? 'btn-success' : '' }}" class="success" {{ ($package->featured === true) ? 'checked' : '' }}>{{ ($package->featured === true) ? 'Featured' : 'Normal' }}</button>
                                      </span>
                                    </form>
                                      </td>
                                      <td>
                                        <form class="form-horizontal" role="form" method="GET" action="{{ route('admin.packages.toggleActive', $package->id) }}">
                                          {!! csrf_field() !!}
                                        <span class="button-checkbox">
                                          <button type="submit" class="btn {{ ($package->active === true) ? 'btn-success' : '' }}" class="success" {{ ($package->active === true) ? 'checked' : '' }}>{{ ($package->active === true) ? 'Active' : 'Inactive' }}</button>
                                        </span>
                                        </form>
                                      </td>
                                      <td>{{ $package->created_at->format('F j, Y, g:i A') }}</td>


                                      <td class="text-right">
                                          <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST">
                                              {!! csrf_field() !!}
                                              {!! method_field('DELETE') !!}
                                              <button type="submit" class="btn btn-danger confirm-action" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                                              <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                                              <a href="{{ route('admin.packages.show', $package->id) }}" class="btn btn-default" data-toggle="tooltip" title="Details"><i class="fa fa-arrow-right"></i></a>
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

      @if($packages->hasPages())
          <div class="text-center">
              {!! $packages->render() !!}
          </div>
      @endif
  </div>
@endsection
