<div class="pledge-bar mt-4">
    <div class="pledge-bar__outer bg-black rounded-full p-1">
        <div class="pledge-bar__outer__inner rounded-full bg-accent flex justify-center items-center w-0" data-percentage="{{$donationPercent}}">
            <span class="mix-blend-difference text-accent opacity-0 text-nowrap">{{number_format($donationAmount, 0, ",", "'")}} CHF</span>
        </div>
    </div>
    <div class="pledge-bar__helper text-xs flex justify-between mt-1">
        <span>0 CHF</span>
        <span>25'000 CHF</span>
    </div>
</div>

