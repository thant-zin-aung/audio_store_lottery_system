// login/reset password code...
let formWrapper = document.getElementsByClassName("form-wrapper")[0];
let resetFormWrapper = document.getElementsByClassName("reset-form-wrapper")[0];
let loginButton = document.getElementsByClassName("login-button")[0];
let resetButton = document.getElementsByClassName("reset-button")[0];

resetButton.addEventListener("click",event=>{
    formWrapper.style.display = "none";
    resetFormWrapper.style.display = "flex";
});
// resetButton.addEventListener("click",event=>{
//     formWrapper.display = "none";
//     resetFormWrapper.display = "flex";
// });
