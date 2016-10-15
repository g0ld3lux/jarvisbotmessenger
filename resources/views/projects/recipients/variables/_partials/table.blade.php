<table class="table custom-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Accessor</th>
            <th>Type</th>
            <th>Created</th>
            <th>Updated</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach($recipientsVariables as $recipientsVariable)
            <tr>
                <td>{{ $recipientsVariable->name }}</td>
                <td>{${{ $recipientsVariable->accessor }}}</td>
                <td>{{ $recipientsVariable->type }}</td>
                <td>{{ $recipientsVariable->created_at ? adjust_project_timezone($project, $recipientsVariable->created_at)->format('F j, Y, g:i A') : '' }}</td>
                <td>{{ $recipientsVariable->updated_at ? adjust_project_timezone($project, $recipientsVariable->updated_at)->format('F j, Y, g:i A') : '' }}</td>
                <td class="text-right">
                    <form method="POST" action="{{ route('projects.recipients.variables.delete', [$project->id, $recipientsVariable->id]) }}">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        @can('delete', [$recipientsVariable, $project])
                            <button type="submit" class="btn btn-danger confirm-action" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                        @endcan
                        @can('edit', [$recipientsVariable, $project])
                            <a href="{{ route('projects.recipients.variables.edit', [$project->id, $recipientsVariable->id]) }}" class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                        @endcan
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>