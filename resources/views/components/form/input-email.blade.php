<div class="petition-input-group">
    <label for="{{$formID}}-{{$item->name}}">{{__($item->label)}}</label>
    <input
        type="email"
        id="{{$formID}}-{{$item->name}}"
        name="email"
        class="petition-input-group__input"
        placeholder="{{$item->placeholder ?? ''}}"
        @if($item->required) required @endif
        value="{{old($item->name)}}"
    >
    @error($item->name)
        <p class="petition-input-group__error">{{ $message }}</p>
    @enderror
</div>
