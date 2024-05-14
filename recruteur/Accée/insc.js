function validateForm() {
    var password = document.getElementById("Password").value;
    var confirmPassword = document.getElementById("ConfPassword").value;
    var passwordError = document.getElementById("passwordError");
    var passwordE = document.getElementById("passwordE");
    var inscrire = document.getElementById("inscrire");
        
    if(confirmPassword){

        if(password != confirmPassword){
            passwordError.textContent = "Mot de passe ne correspondant pas";
            passwordE.textContent = ".";
            inscrire.disabled = true;
        } 
        else{
            passwordError.textContent = "";
            passwordE.textContent = "";
            inscrire.disabled = false;
        }
    }
}

window.onload = function() {
    var urlParams = new URLSearchParams(window.location.search);
    var message = urlParams.get('message');
    
    if (message) {
        alert(message);
    }
};
