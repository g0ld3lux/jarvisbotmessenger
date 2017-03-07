@extends('bots.responds.taxonomies.create._base')

@section('form')
    <div class="form-group{{ $errors->has('option') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Option</label>

        <div class="col-md-6">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary {{ old('option', 'web_url') == 'web_url' ? 'active' : '' }}">
                    <input type="radio" name="option" value="web_url" id="optionWebUrl" autocomplete="off" {{ old('option', 'web_url') == 'web_url' ? 'checked' : '' }}> URL
                </label>
                <label class="btn btn-primary {{ old('option', 'web_url') == 'postback' ? 'active' : '' }}">
                    <input type="radio" name="option" value="postback" id="optionPostback" autocomplete="off" {{ old('option', 'web_url') == 'postback' ? 'checked' : '' }}> Postback
                </label>
                <label class="btn btn-primary {{ old('option', 'web_url') == 'phone_number' ? 'active' : '' }}">
                    <input type="radio" name="option" value="phone_number" id="optionPhoneNumber" autocomplete="off" {{ old('option', 'web_url') == 'phone_number' ? 'checked' : '' }}> Phone Number
                </label>
            </div>

            @if ($errors->has('option'))
                <span class="help-block">
                    <strong>{{ $errors->first('option') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Title</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="title" value="{{ old('title') }}">

            @if ($errors->has('title'))
                <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }} option-field option-web_url" @if(old('option', 'web_url') != 'web_url') style="display: none;" @endif>
        <label class="col-md-4 control-label">URL</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="url" value="{{ old('url') }}">

            @if ($errors->has('url'))
                <span class="help-block">
                    <strong>{{ $errors->first('url') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('responds') ? ' has-error' : '' }} option-field option-postback" @if(old('option', 'web_url') != 'postback') style="display: none;" @endif>
        <label class="col-md-4 control-label">Responds</label>

        <div class="col-md-6">
            <select class="form-control select2" name="responds[]" multiple style="width: 100%;">
                @foreach($bot->responds()->global()->get() as $respondValue)
                    <option value="{{ $respondValue->id }}" @if(in_array($respondValue->id, (array) old('responds'))) selected @endif>{{ $respondValue->title }}</option>
                @endforeach
            </select>

            @if ($errors->has('responds'))
                <span class="help-block">
                    <strong>{{ $errors->first('responds') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }} option-field option-phone_number" @if(old('option', 'web_url') != 'phone_number') style="display: none;" @endif>
        <label class="col-md-4 control-label">Phone number</label>

        <div class="col-md-6">
            <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}">

            @if ($errors->has('phone_number'))
                <span class="help-block">
                    <strong>{{ $errors->first('phone_number') }}</strong>
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

        showFields("{{ old('option', 'web_url') }}");

    });
</script>
@endpush