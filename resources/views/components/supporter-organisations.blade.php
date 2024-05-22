<div class="petition-supporter-logos grid grid-cols-2 md:grid-cols-3 mt-4 gap-4">
    @foreach ($logos as $logo)
        <div class="petition-supporter-logos__item aspect-square flex p-2 bg-white">
            <img src="{{ Storage::url($logo) }}" alt="Logo" class="object-contain" loading="lazy">
        </div>
    @endforeach
</div>
