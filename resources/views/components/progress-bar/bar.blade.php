
<div class="pledge-bar mt-4">
    <div class="pledge-bar__icon mb-2">
        <x-progressBar.icon class="w-12 -translate-x-5" />
    </div>
    <div class="pledge-bar__outer bg-black rounded-full p-1">
        <div class="pledge-bar__outer__inner rounded-full bg-accent flex justify-center items-center w-0" data-percentage="{{$signaturePercentage}}">
            <span class="mix-blend-difference text-accent opacity-0">{{number_format($signaturePercentage, 2, ".", ".")}}%</span>
        </div>
    </div>
    <div class="pledge-bar__helper text-xs flex justify-between mt-1">
        <span>0</span>
        <span>20'000</span>
    </div>
</div>

