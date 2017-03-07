<div class="taxonomy-group">
    <div class="clearfix taxonomy-group-toolbar">
        <small class="pull-left taxonomy-type">{{ $taxonomy->type }}</small>
        <div class="pull-right taxonomy-toolbar">
            @if(!$taxonomy->is_first)
                <a href="{{ route('bots.responds.edit.taxonomies.move.down', [$bot->id, $respond->id, $taxonomy->id]) }}" class="btn btn-xs btn-default" data-toggle="tooltip" title="Move up"><i class="fa fa-arrow-up"></i></a>
            @endif
            @if(!$taxonomy->is_last)
                <a href="{{ route('bots.responds.edit.taxonomies.move.up', [$bot->id, $respond->id, $taxonomy->id]) }}" class="btn btn-xs btn-default" data-toggle="tooltip" title="Move down"><i class="fa fa-arrow-down"></i></a>
            @endif
            <a href="{{ route('bots.responds.edit.taxonomies.delete', [$bot->id, $respond->id, $taxonomy->id]) }}" class="btn btn-xs btn-danger confirm-action" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
            <a href="{{ route('bots.responds.edit.taxonomies.edit', [$bot->id, $respond->id, $taxonomy->id]) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>
        </div>
    </div>
    <div class="taxonomy-group-params">
        @foreach($taxonomy->params()->ordered()->get() as $param)
            @include('bots.responds.taxonomies.render.'.$taxonomy->type.'.'.$param->key, ['bot' => $bot, 'respond' => $respond, 'taxonomy' => $taxonomy, 'param' => $param])
        @endforeach
    </div>

    @foreach($taxonomy->children()->ordered()->get() as $child)
        @include('bots.responds.taxonomies.render.render', ['bot' => $bot, 'respond' => $respond, 'taxonomy' => $child])
    @endforeach

    @if(view()->exists('bots.responds.taxonomies.render._actions.'.$taxonomy->type))
        <div class="taxonomy-group-bottom-toolbar">
            @include('bots.responds.taxonomies.render._actions.'.$taxonomy->type, ['bot' => $bot, 'respond' => $respond, 'taxonomy' => $taxonomy])
        </div>
    @endif
</div>