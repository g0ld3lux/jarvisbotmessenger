<dl class="dl-horizontal">
    <dt>{{ $recipientVariable->variable->name }}</dt>
    <dd>@include('projects.recipients.variables.render.'.$recipientVariable->variable->type, ['recipientVariable' => $recipientVariable])</dd>
</dl>