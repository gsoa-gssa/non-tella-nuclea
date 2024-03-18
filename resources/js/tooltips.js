import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';
import './tippy.scss';

window.addEventListener("load", function () {
    let tooltips = document.querySelectorAll("[data-tooltip]");
    tooltips.forEach(tooltip => {
        let span = document.createElement("span");
        span.innerHTML = "info";
        span.classList.add("material-symbols-outlined", "ml-1", "font-sm");
        tooltip.appendChild(span);
        tippy(tooltip, {
            content: tooltip.getAttribute("data-tooltip"),
            placement: "top",
        });
    });
});
