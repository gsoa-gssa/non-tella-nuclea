<div class="petition-input-group @if(isset($item->fullwidth) && $item->fullwidth)petition-input-group__fullwidth @endif">
    <label for="{{$formID}}-{{$item->name}}">{{__($item->label)}}</label>
    <input
        type="text"
        id="{{$formID}}-{{$item->name}}"
        name="data[{{$item->name}}]"
        class="petition-input-group__input"
        placeholder="{{$item->placeholder ?? ''}}"
        @if($item->required) required @endif
        value="{{old("data.".$item->name)}}"
    >
    @error("data.".$item->name)
        <p class="petition-input-group__error">{{ $message }}</p>
    @enderror
</div>
