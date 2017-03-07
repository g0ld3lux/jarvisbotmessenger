<table class="table custom-table">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Created</th>
            <th>Updated</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach($recipients as $recipient)
            <tr @if($recipient->chat_disabled) class="text-muted" @endif>
                <td class="text-center">
                    @if($recipient->getPhotoUrl('recipient_small'))
                        <img class="img-circle" src="{{ $recipient->getPhotoUrl('recipient_small') }}">
                    @else
                        &nbsp;
                    @endif
                </td>
                <td class="text-center">
                    @if($recipient->gender == 'male')
                        <i class="fa fa-mars"></i>
                    @elseif($recipient->gender == 'female')
                        <i class="fa fa-venus"></i>
                    @else
                        -
                    @endif
                </td>
                <td>{{ $recipient->first_name }}</td>
                <td>{{ $recipient->last_name }}</td>
                <td>{{ $recipient->created_at ? adjust_bot_timezone($bot, $recipient->created_at)->format('F j, Y, g:i A') : '' }}</td>
                <td>{{ $recipient->updated_at ? adjust_bot_timezone($bot, $recipient->updated_at)->format('F j, Y, g:i A') : '' }}</td>
                <td class="text-right">
                    <form method="POST" action="{{ route('bots.recipients.chat.toggle', [$bot->id, $recipient->id]) }}">
                        {!! csrf_field() !!}
                        @if($recipient->chat_disabled)
                            <button class="btn btn-link" type="submit" name="action" value="enable" data-toggle="tooltip" title="Enable chat"><i class="fa fa-toggle-off"></i></button>
                        @else
                            <button class="btn btn-link" type="submit" name="action" value="disable" data-toggle="tooltip" title="Disable chat"><i class="fa fa-toggle-on"></i></button>
                        @endif
                    </form>
                </td>
                <td class="text-right">
                    <a href="{{ route('bots.recipients.show', [$bot->id, $recipient->id]) }}" class="btn btn-default"><i class="fa fa-arrow-right"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>