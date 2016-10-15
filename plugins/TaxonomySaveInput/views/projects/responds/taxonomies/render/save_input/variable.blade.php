<div class="form-group">
    <label class="col-md-4 control-label">Save to</label>

    <div class="col-md-6">
        <p class="form-control-static"><a href="{{ route('projects.recipients.variables.edit', [$project->id, $param->value]) }}">{{ $project->recipientsVariables()->find($param->value)->name }}</a></p>
    </div>
</div>