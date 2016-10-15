@extends('projects.responds.taxonomies.create._base')

@section('form')
    <input type="hidden" name="option" value="url">
    {{--<div class="form-group{{ $errors->has('option') ? ' has-error' : '' }}">--}}
        {{--<label class="col-md-4 control-label">Option</label>--}}

        {{--<div class="col-md-6">--}}
            {{--<div class="btn-group" data-toggle="buttons">--}}
                {{--<label class="btn btn-primary {{ old('option', 'url') == 'url' ? 'active' : '' }}">--}}
                    {{--<input type="radio" name="option" value="url" id="optionURL" autocomplete="off" {{ old('option', 'url') == 'url' ? 'checked' : '' }}> URL--}}
                {{--</label>--}}
                {{--<label class="btn btn-primary {{ old('option', 'url') == 'upload' ? 'active' : '' }}">--}}
                    {{--<input type="radio" name="option" value="upload" id="optionUpload" autocomplete="off" {{ old('option', 'url') == 'upload' ? 'active' : '' }}> Upload--}}
                {{--</label>--}}
            {{--</div>--}}

            {{--@if ($errors->has('option'))--}}
                {{--<span class="help-block">--}}
                    {{--<strong>{{ $errors->first('option') }}</strong>--}}
                {{--</span>--}}
            {{--@endif--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }} option-field option-url" @if(old('option', 'url') != 'url') style="display: none;" @endif>
        <label class="col-md-4 control-label">Image URL</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="url" value="{{ old('url') }}">

            @if ($errors->has('url'))
                <span class="help-block">
                    <strong>{{ $errors->first('url') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }} option-field option-upload"  @if(old('option', 'url') != 'upload') style="display: none;" @endif>
        <label class="col-md-4 control-label">File (jpg, png)</label>

        <div class="col-md-6">
            <input type="file" class="form-control" name="file" value="{{ old('file') }}">

            @if ($errors->has('file'))
                <span class="help-block">
                    <strong>{{ $errors->first('file') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).on("ready", function () {

            $("input[name='option']").on("change", function () {
                showFields($(this).val());
            });

            function showFields(option)
            {
                $(".option-field").hide();
                $(".option-" + option).show();
            }

            showFields("{{ old('option', 'url') }}");

        });
    </script>
@endpush