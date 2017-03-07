@extends('bots.responds.taxonomies.edit._base', ['btn_save' => false])

@section('form')
    @if($taxonomy->children()->count() > 0)
        <div class="taxonomies-block">
            @foreach($taxonomy->children()->ordered()->get() as $child)
                @include('bots.responds.taxonomies.render.render', ['bot' => $bot, 'respond' => $respond, 'taxonomy' => $child])
            @endforeach
        </div>
    @else
        <div class="alert alert-info">There is no elements defined!</div>
    @endif

    <div class="form-group text-right">
        <div class="col-md-6 col-md-offset-6">
            <a href="{{ route('bots.responds.edit.taxonomies.create', [$bot->id, $respond->id, 'element', $taxonomy->id]) }}" class="btn btn-primary">
                <i class="fa fa-btn fa-plus"></i>Add new element
            </a>
        </div>
    </div>
@endsection