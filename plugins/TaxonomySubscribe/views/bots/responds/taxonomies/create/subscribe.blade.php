@extends('bots.responds.taxonomies.create._base')

@section('form')
    <div class="form-group{{ $errors->has('channel') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Channel</label>

        <div class="col-md-6">
            <select class="form-control" name="channel">
                <option></option>
                @foreach($bot->subscriptionsChannels()->ordered()->get() as $channel)
                    <option value="{{ $channel->id }}" @if(old('channel') == $channel->id) selected @endif>{{ $channel->name }}</option>
                @endforeach
            </select>

            @if($errors->has('channel'))
                <span class="help-block">
                    <strong>{{ $errors->first('channel') }}</strong>
                </span>
            @endif
        </div>
    </div>


    <div class="form-group{{ $errors->has('option') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Option</label>

        <div class="col-md-6">
            <div class="radio">
                <label>
                    <input type="radio" name="option" id="optionAdd" value="add" {{ old('option') == 'add' ? 'checked' : '' }}>
                    Add recipient to subscription channel
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="option" id="optionRemove" value="remove" {{ old('option') == 'remove' ? 'checked' : '' }}>
                    Remove recipient from subscription channel
                </label>
            </div>

            @if ($errors->has('option'))
                <span class="help-block">
                    <strong>{{ $errors->first('option') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endsection