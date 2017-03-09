<div class="row">
    <div class="col-md-12">

                <form class="form-horizontal" role="form" method="POST" action="{{ route('bots.store') }}">
                    {!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Name Your Bot:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}">

                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('timezone') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Pick A Time Zone</label>

                        <div class="col-md-6">
                            <select class="form-control select2" name="timezone">
                                @foreach(timezones_list() as $timezone => $title)
                                    <option value="{{ $timezone }}" @if(old('timezone') == $timezone) selected @endif>{{ $title }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('timezone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('timezone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                </form>

    </div>
</div>