/* Registration Form (user_register) */
const phoneInputField = document.querySelector("#user_phone");
const phoneInput = window.intlTelInput(phoneInputField, {
    utilsScript:
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    preferredCountries: ["my"],
});

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
document
    .getElementById("register-button")
    .addEventListener("click", function () {
        setCookie("user_phone", phoneInput.getNumber(), "10");
    });
