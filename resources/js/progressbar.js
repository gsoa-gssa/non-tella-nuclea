window.addEventListener("load", function () {
    let progressBarInner = this.document.querySelector(".pledge-bar__outer__inner");
    if (!progressBarInner) return;
    let percentageSpan = progressBarInner.querySelector("span");
    let percentage = progressBarInner.dataset.percentage;

    setTimeout(() => {
        progressBarInner.animate([
            { width: "0%" },
            { width: `${percentage}%` }
        ], {
            duration: 1000,
            easing: "ease-in-out",
            iterations: 1,
            fill: "forwards"
        });

        setTimeout(() => {
            percentageSpan.animate([
                { opacity: "0" },
                { opacity: "1" }
            ], {
                duration: 250,
                easing: "ease-in-out",
                iterations: 1,
                fill: "forwards"
            });
        }, 1000);
    }, 500);
});
