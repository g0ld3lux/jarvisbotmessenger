<table class="table custom-table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Created</th>
            <th>Updated</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach($responds as $respond)
            <tr>
                <td>{{ $respond->title }}</td>
                <td>{{ $respond->created_at ? adjust_bot_timezone($bot, $respond->created_at)->format('F j, Y, g:i A') : '' }}</td>
                <td>{{ $respond->updated_at ? adjust_bot_timezone($bot, $respond->updated_at)->format('F j, Y, g:i A') : '' }}</td>
                <td class="text-right">
                    <form method="POST" action="{{ route('bots.responds.delete', [$bot->id, $respond->id]) }}">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <button type="submit" class="btn btn-danger confirm-action" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                        <a href="{{ route('bots.responds.edit', [$bot->id, $respond->id]) }}" class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>