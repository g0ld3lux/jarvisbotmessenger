<div class="form-group">
    <label class="col-md-4 control-label">Show no more than</label>

    <div class="col-md-6">
        <p class="form-control-static">{{ $param->value }} {{ $param->value == '1' ? 'story' : 'stories' }}</p>
    </div>
</div>