<div {{$attributes->merge(["class"=>"petition-supporter-people"])}}>
    <p class="text-sm">
        @foreach ($supporters as $supporter)
            <b>{{$supporter->data["firstname"]}} {{$supporter->data["lastname"]}}</b>, {{$supporter->data["zip"]}}
            @if (!$loop->last)
                ,
            @endif
        @endforeach
    </p>
    @if ($loadMore)
        <div class="petition-loadmore">
            <a href="#" class="text-sm underline petition-loadmore__button">{{__("Mehr anzeigen")}}</a>
        </div>
    @endif
</div>
