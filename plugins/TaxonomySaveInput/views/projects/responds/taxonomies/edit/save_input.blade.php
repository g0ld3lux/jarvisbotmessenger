@extends('projects.responds.taxonomies.edit._base')

@section('form')
    <div class="form-group{{ $errors->has('variable') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Save to</label>

        <div class="col-md-6">
            <select class="form-control" name="variable">
                <option></option>
                @foreach($project->recipientsVariables()->orderBy('name', 'asc')->get() as $variable)
                    <option value="{{ $variable->id }}" @if(old('variable', $taxonomy->getParamValue('variable')) == $variable->id) selected @endif>{{ $variable->name }}</option>
                @endforeach
            </select>

            @if($errors->has('variable'))
                <span class="help-block">
                    <strong>{{ $errors->first('variable') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endsection