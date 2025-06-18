/*let signUp = document.getElementById("signUp")
let signIn = document.getElementById("signIn")
let nameInput = document.getElementById("nameInput")                                                                                                                                                                                                            
let title = document.getElementById("title")                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
let tipoCuenta = document.getElementById("tipoCuenta"); 

signIn.onmouseover = function() {                                                                                                                               
    nameInput.style.maxHeight = "0px";                                                                                                                                                                                                          
    title.innerHTML = "Iniciar Sesión";
    signUp.classList.add("disable");
    signIn.classList.remove("disable");
    tipoCuenta.style.display = "none"; 
}

signUp.onmouseover = function() {
    nameInput.style.maxHeight = "66px";                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
    title.innerHTML = "Registrate";
    signUp.classList.remove("disable");
    signIn.classList.add("disable");
    tipoCuenta.style.display = "block";                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
}*/

const signUpBtn = document.getElementById("signUp");
const signInBtn = document.getElementById("signIn");
const registerBox = document.getElementById("registerBox");
const nameInput = document.getElementById("nameInput");
const title = document.querySelector("#registerBox h1");
const tipoCuenta = document.getElementById("tipoCuenta");
const premiumRadio = document.getElementById("premiumRadio");
const usernameInput = document.getElementById("usernameInput");

// Cambiar a modo login
signInBtn.addEventListener('mouseenter', function () {
  nameInput.style.display = "none";
  title.textContent = "Iniciar Sesión";
  signUpBtn.classList.add("disable");
  signInBtn.classList.remove("disable");
  tipoCuenta.style.display = "none";
  usernameInput.required = false;
});

// Cambiar a modo registro
signUpBtn.addEventListener('mouseenter', function () {
  nameInput.style.display = "block";
  title.textContent = "Regístrate";
  signUpBtn.classList.remove("disable");
  signInBtn.classList.add("disable");
  tipoCuenta.style.display = "flex";
  usernameInput.required = true;
});