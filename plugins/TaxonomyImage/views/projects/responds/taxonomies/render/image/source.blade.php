<div class="form-group">
    <label class="col-md-4 control-label">Image</label>

    <div class="col-md-6">
        <p class="form-control-static">
            <img src="{{ route('imagecache', ['image_preview', $param->value]) }}">
        </p>
    </div>
</div>