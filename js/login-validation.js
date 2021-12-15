//fillimi i validimit te Login Formes

$("#loginform").submit(function(e) {
    let errorMsg = [];

    const loginUsername = $("#loginusername");
    const loginPassword = $("#loginpassword");

    if (loginUsername.val() == '' && loginPassword.val() == '') {
        errorMsg.push('Please Enter Username and Password!')
    } else {
        if (loginUsername.val() == '') {
            errorMsg.push("Username is Required to Login!")
        } else {
            if ((loginUsername.val().length < 6) || (loginUsername.val().length > 12)) {
                errorMsg.push('Username Should be al least 6 characters and lower than 12');
            } else {
                if (countWordsNumber(loginUsername.val()) > 1) {
                    errorMsg.push('Username Needs to be ONLY one String With Letters And Numbers!');
                } else {
                    if (valUsername(loginUsername.val())) {
                        errorMsg.push('Username Needs to be ONLY String With Letters And Numbers!');
                    } else {
                        if (matchFullName(loginUsername.val()) != null) {
                            errorMsg.push("Username Contains Only Letters and Numbers!");
                        }
                    }
                }
            }
        }

        if (loginPassword.val() == '') {
            errorMsg.push("Password is Required to Login!")
        } else {
            if ((loginPassword.val().length < 6) || (loginPassword.val().length > 50)) {
                errorMsg.push('Password Should be al least 6 characters and lower than 50');
            } else {
                if (countWordsNumber(loginPassword.val()) > 1) {
                    errorMsg.push('Password Needs to be ONLY ONE String With Letters And Numbers!');
                }
            }
        }
    }


    if(errorMsg.length > 0){
        e.preventDefault();
    }

    $("#error").html("");
    errorMsg.forEach(element => {
        $("#error").append("<li>" + element + "</li>");
    });

})

$("#registerform").submit(function(e) {
    let errorMsg = [];

    const full_name = $("#register_fullname");
    const email = $("#register_email");
    const username = $("#register_username");
    const password = $("#register_password");
    const password2 = $("#register_confirm_password");


    if (full_name.val() == '' && email.val() == '' && username.val() == '' && password.val() == '' && password2.val() == '') {
        errorMsg.push('Please Enter All Required Fields!')
    } else {
        if (full_name.val() == '') {
            errorMsg.push('Full Name is Required to Register!')
        } else {
            if (countWordsNumber(full_name.val()) <= 1) {
                errorMsg.push("Full Name needs to be at least two Words!")
            } else {
                if (matchFullName(full_name.val()) != null) {
                    errorMsg.push("Full Name Should Contain Only Letters!");
                }
            }
        }

        if (email.val() === '') {
            errorMsg.push("Email is Required to Register!")
        } else {
            if (!valEmail(email.val())) {
                errorMsg.push("Email is Invalid Please Enter Again!");
            }
        }

        if (username.val() === '') {
            errorMsg.push("Username is Required to Register!")
        } else {
            if ((username.val().length < 6) || (username.val().length > 12)) {
                errorMsg.push('Username Should be al least 6 characters and lower than 12');
            } else {
                if (countWordsNumber(username.val()) > 1) {
                    errorMsg.push('Username Needs to be ONLY one String With Letters And Numbers!');
                } else {
                    if (valUsername(username.val())) {
                        errorMsg.push('Username Needs to be ONLY String With Letters And Numbers!');
                    } else {
                        if (matchFullName(username.val()) != null) {
                            errorMsg.push("Username Should Contain Only Letters and Numbers!");
                        }
                    }
                }
            }
        }

        if (password.val() === '') {
            errorMsg.push("Password is Required to Register!")
        } else {
            if ((password.val().length < 6) || (password.val().length > 50)) {
                errorMsg.push('Password Should be al least 6 characters and lower than 50');
            }
        }

        if (password2.val() === '') {
            errorMsg.push("Confirm Password is Required to Register!")
        } else {
            if (countWordsNumber(password.val()) > 1) {
                errorMsg.push('Password Needs to be ONLY ONE String With Letters And Numbers!');
            } else {
                if (password2.val() !== password.val()) {
                    errorMsg.push("Password Should be the Same is both Fields! Please Retype Again!")
                }
            }
        }
    }

    if(errorMsg.length > 0){
        e.preventDefault();
    }

    $("#error").html("");
    errorMsg.forEach(element => {
        $("#error").append("<li>" + element + "</li>");
    });

})

function countWordsNumber(str) {
    return str.split(" ").length;
}

function matchFullName(str) {
    const findThis = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
    return str.match(findThis);
}

function valEmail(str) {
    const testThis = /\S+@\S+\.\S+/;
    return str.match(testThis);
}

function valUsername(str) {
    const testThis = /\S+N+/;
    return str.match(testThis);
}

function toggleLoginRegister(){
    $("#registerform").slideToggle();
    $("#loginform").slideToggle();
}

$("#toogleRegister").click(function(){
    toggleLoginRegister();
})

$("#toogleLogin").click(function(){
    toggleLoginRegister();
})