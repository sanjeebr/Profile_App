function validate() {
    var is_empty = document.getElementsByClassName("empty");
    var empty_error_msg = document.getElementsByClassName("empty-msg");
    var error = document.getElementsByClassName("error");
    var only_char = document.getElementsByClassName("only-char");
    var char_error_msg = document.getElementsByClassName("invalid-name");
    var only_num = document.getElementsByClassName("only-num");
    var num_error_msg = document.getElementsByClassName("invalid-num");
    var communication = document.getElementsByClassName("communication");
    var i;
    var letters = /^[a-zA-Z ]*$/;
    var number = /^[0-9 ]*$/;
    var no_error = true;

    for (i = 0; i < error.length; i++) {
        error[i].innerHTML = "";
    }

    for (i = 0; i < is_empty.length; i++) {

        if (is_empty[i].value == null || is_empty[i].value == "") {
            empty_error_msg[i].innerHTML = "This field is required.";
            no_error = false;
        }
    }

    for (i = 0; i < only_char.length; i++) {

        if ( ! only_char[i].value.match(letters)) {
            char_error_msg[i].innerHTML = "Only letters and white space allowed.";
            no_error = false;
        }
    }

    for (i = 0; i < only_char.length; i++) {

        if ( ! only_num[i].value.match(number)) {
            num_error_msg[i].innerHTML = "Invalid Input.";
            no_error = false;
        }
    }

    if (document.getElementById("r_pin").value.length != 6) {
        document.getElementById("r_pin_err").innerHTML = "Invalid Pin no";
        no_error = false;
    }

    if (document.getElementById("r_phone").value.length != 10) {
        document.getElementById("r_phone_err").innerHTML = "Invalid Phone no";
        no_error = false;
    }

    if (document.getElementById("r_fax").value.length != 0
        && document.getElementById("r_fax").value.length != 11) {

        document.getElementById("r_fax_err").innerHTML = "Invalid Fax no";
        no_error = false;
    }

    if (document.getElementById("o_pin").value.length != 0
        && document.getElementById("o_pin").value.length != 6) {


        document.getElementById("o_pin_err").innerHTML = "Invalid Pin no";
        no_error = false;
    }

    if (document.getElementById("o_phone").value.length != 0
        && document.getElementById("o_phone").value.length != 10) {

        document.getElementById("o_phone_err").innerHTML = "Invalid Phone no";
        no_error = false;
    }

    if (document.getElementById("o_fax").value.length != 0
        && document.getElementById("o_fax").value.length != 11) {

        document.getElementById("o_fax_err").innerHTML = "Invalid Fax no";
        no_error = false;
    }
    return no_error;
}


function register_validate() {
    var password = document.getElementsByClassName("password");
    var password_err = document.getElementsByClassName("pwd-err");
    var is_empty = document.getElementsByClassName("empty");
    var empty_error_msg = document.getElementsByClassName("empty-msg");
    var error = document.getElementsByClassName("error");
    var i;
    var no_error = true;

    for (i = 0; i < error.length; i++) {
        error[i].innerHTML = "";
    }

    for (i = 0; i < is_empty.length; i++) {

        if (is_empty[i].value == null || is_empty[i].value == "") {
            empty_error_msg[i].innerHTML = "This field is required.";
            no_error = false;
        }
    }

    if (password[0].value === password[1]) {
            password_err[0].innerHTML = "Password field does not match Confirm Password field";
            no_error = false;
    }

    for (i = 0; i < password.length; i++) {

        if (password[i].value.length < 8 || password[i].value.length > 16) {
            password_err[i].innerHTML = "Password length must be between 8-16";
            no_error = false;
        }
    }

    return no_error;
}