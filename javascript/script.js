let username = document.getElementById("username"); // The username input in the form
let password = document.getElementById("password");// The password input in the form
let form = document.getElementById('form');// The form 
let usernameError = document.getElementById('errmessage-username');// The place that the username error will be placed at
let passwordError = document.getElementById('errmessage-password');// The place that the password error will be placed at

let options = document.getElementsByClassName('option'); // will the have the three options which are "manager", "staff", and "admin"
let mainError = document.getElementById('mainError');// will be presenting the errors related to the selection of the three user which are "manager", "staff", and "admin"

form.addEventListener('submit', function(e){
    // These will be the  messages  that will be shown when the input field of username and password are empty.
    let usernameMessage = null; 
    let passwordMessage = null; 

    if(username.value === "" || username.value == null){ // to check if the value of the username input field is empty.
        usernameMessage = "Username is required"; 
    }
    
    if(password.value === "" || password.value  == null){// to check if the value of the password input field is empty.
        passwordMessage = "Password is required";
    }

    if(usernameMessage !== null){ // if the username input field is not empty 
        e.preventDefault(); // to prevent the "LOGIN" button from pressing

        usernameError.innerText = usernameMessage;
        username.style.borderColor = "red";
    }

    if(passwordMessage !== null){
        e.preventDefault();
        passwordError.innerText = passwordMessage;
        password.style.borderColor = "red";
    }
    
    let valid =  false; 
    

    for(let i=0; i<options.length; i++){// if one of the three options are checked the loop will stop and "valid" will turn true
        if(options[i].checked){
            valid = true;
            break;
        }
    }

    if (valid === false){  // if "valid" is false which means that none of the three options got chosen.
        e.preventDefault();
        mainError.innerText = "Please choose between the three options above."; 
    }
    
});



