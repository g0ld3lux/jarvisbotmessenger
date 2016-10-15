@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="clearfix">
                <div class="pull-left content-header-title"><a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a> &raquo; Settings</div>
                <div class="pull-right">
                    @include('projects._partials.menu')
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @notification()

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li class="{{ old('tab', 'general') == 'general' ? 'active' : '' }}"><a href="#general" data-toggle="tab" aria-expanded="true">General</a></li>
                    <li class="{{ old('tab', 'general') == 'thread' ? 'active' : '' }}"><a href="#thread" data-toggle="tab" aria-expanded="true">Thread settings</a></li>
                    <li class="{{ old('tab', 'general') == 'delete' ? 'active' : '' }}"><a href="#delete" data-toggle="tab" aria-expanded="false">Delete project</a></li>
                </ul>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade {{ old('tab', 'general') == 'general' ? ' active in' : '' }}" id="general">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('projects.update', $project->id) }}">
                                    {!! csrf_field() !!}

                                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label">Title</label>

                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="title" value="{{ old('title', $project->title) }}">

                                            @if ($errors->has('title'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('timezone') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label">Timezone</label>

                                        <div class="col-md-6">
                                            <select class="form-control select2" name="timezone">
                                                @foreach(timezones_list() as $timezone => $title)
                                                    <option value="{{ $timezone }}" @if(old('timezone', $project->timezone) == $timezone) selected @endif>{{ $title }}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('timezone'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('timezone') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-btn fa-save"></i>Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade {{ old('tab', 'general') == 'thread' ? ' active in' : '' }}" id="thread">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('projects.update.thread', $project->id) }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="tab" value="thread">

                                    <div class="form-group{{ $errors->has('greeting_text') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label">Greeting text</label>

                                        <div class="col-md-6">
                                            <textarea rows="4" class="form-control" name="greeting_text">{{ old('greeting_text', $project->threadSettings->greeting_text) }}</textarea>

                                            @if ($errors->has('greeting_text'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('greeting_text') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('get_started_respond_id') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label">Get started respond</label>

                                        <div class="col-md-6">
                                            <select name="get_started_respond_id" class="form-control select2" style="width: 100%;">
                                                <option>- none -</option>
                                                @foreach($responds as $respond)
                                                    <option value="{{ $respond->id }}" @if($project->threadSettings->get_started_respond_id == $respond->id) selected @endif>{{ $respond->title }}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('get_started_respond_id'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('get_started_respond_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('persistent_menu_respond_id') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label">Persistent menu respond</label>

                                        <div class="col-md-6">
                                            <select name="persistent_menu_respond_id" class="form-control select2" style="width: 100%;">
                                                <option>- none -</option>
                                                @foreach($persistent_menu_responds as $respond)
                                                    <option value="{{ $respond->id }}" @if($project->threadSettings->persistent_menu_respond_id == $respond->id) selected @endif>{{ $respond->title }}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('persistent_menu_respond_id'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('persistent_menu_respond_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-btn fa-save"></i>Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade {{ old('tab', 'general') == 'delete' ? ' active in' : '' }}" id="delete">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('projects.delete', $project->id) }}">
                                    {!! csrf_field() !!}
                                    {!! method_field('DELETE') !!}
                                    <input type="hidden" name="tab" value="delete">

                                    <div class="alert alert-danger" role="alert">
                                        To delete your project, please enter the title of the project as a confirmation. Your project will be deleted immediately. Project recovery is impossible once the project is deleted.
                                    </div>

                                    <div class="form-group{{ $errors->has('delete_title') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label">Title</label>

                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="delete_title" value="{{ old('delete_title') }}">

                                            @if ($errors->has('delete_title'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('delete_title') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-btn fa-trash"></i>Delete
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection