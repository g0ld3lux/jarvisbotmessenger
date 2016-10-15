<div class="form-group">
    <label class="col-md-4 control-label">Respond</label>

    <div class="col-md-6">
        <p class="form-control-static"><a href="{{ route('projects.responds.edit', [$project->id, $param->value]) }}">{{ $project->responds()->find($param->value)->title }}</a></p>
    </div>
</div>