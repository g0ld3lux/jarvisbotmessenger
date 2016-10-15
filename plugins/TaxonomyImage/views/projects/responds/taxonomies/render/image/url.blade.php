<div class="form-group">
    <label class="col-md-4 control-label">Image URL</label>

    <div class="col-md-6">
        <p class="form-control-static">{{ $param->value }}</p>
    </div>
</div>

<div class="form-group">
    <div class="col-md-6 col-md-push-4">
        <p class="form-control-static">
            <img src="{{ $param->value }}">
        </p>
    </div>
</div>