window.addEventListener('load', function () {
    let signatureCountOptions = this.document.querySelectorAll("input[name='data[signatureCount]']");
    let phoneInputPlaceholder = document.querySelector("input[name='data[phone]']").getAttribute("placeholder");
    signatureCountOptions.forEach(function (option) {
        option.addEventListener('change', function () {
            let signatureCount = option.value;
            if (signatureCount >= 20) {
                let phoneInput = document.querySelector("input[name='data[phone]']");
                phoneInput.setAttribute("required", "required");
                phoneInput.setAttribute("placeholder", "");
            } else {
                let phoneInput = document.querySelector("input[name='data[phone]']");
                phoneInput.removeAttribute("required");
                phoneInput.setAttribute("placeholder", phoneInputPlaceholder);
            }
        });
    });
});
