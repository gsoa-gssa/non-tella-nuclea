window.addEventListener("click", function (e) {
    let pledgeOption = e.target.closest(".petition-input-group__signatureCountFields__options__option");
    if (!pledgeOption) return;
    let pledgeInput = pledgeOption.querySelector("input");
    if (!pledgeInput) return;
    let helper = pledgeInput.dataset.helper;
    if (!helper) return;
    this.document.querySelector("#pledge-helper").textContent = helper;
});
