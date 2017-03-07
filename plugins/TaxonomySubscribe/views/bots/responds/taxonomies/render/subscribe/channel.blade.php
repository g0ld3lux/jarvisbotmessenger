<div class="form-group">
    <label class="col-md-4 control-label">Channel</label>

    <div class="col-md-6">
        <p class="form-control-static"><a href="{{ route('projects.subscriptions.channels.show', [$project->id, $param->value]) }}">{{ $project->subscriptionsChannels()->find($param->value)->name }}</a></p>
    </div>
</div>