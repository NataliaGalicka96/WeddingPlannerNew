const input = document.querySelector('#registration_form_plainPassword');

const checkbox = document.querySelector('#checbox');


function showPassword() {
    if (input.type === "password") {
        input.type = "text";
        input.innerText = input.value;
    } else {
        input.type = "password";
    }
}