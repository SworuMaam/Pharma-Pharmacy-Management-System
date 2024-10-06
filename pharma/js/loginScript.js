const username = document.getElementById("username");
const password = document.getElementById("paswrd");
const form = document.querySelector("form");
const errorMessage = document.getElementById("errorMessage");

form.addEventListener("submit", (e) => {
    const errors = [];

        if(username.value.trim() === ""){
            errors.push("Username is required!");
        }

        if(password.value.length == 0){
            errors.push("Password is required!");
        }

    if(errors.length > 0){  
        e.preventDefault();
        errorMessage.toggleAttribute('hidden');
        errorMessage.innerHTML = errors.join(', ');
    }
})