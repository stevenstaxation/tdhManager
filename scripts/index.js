/*eslint-env jquery */
/*eslint-env browser */
/*jslint browser: true */
/*global $, jQuery, alert*/

// AJAX call for the SIGN UP form
// once the form is submitted

$('#signUpForm').submit(function (event) {
    "use strict";
    // prevent default PHP processing 
    event.preventDefault();
    // collect user inputs
    var dataToPost = $(this).serializeArray();
    // send to register.php using AJAX
    dataToPost.push({
        name: 'logInType',
        value: $('#hiddenUserType').html()
    });


    $.ajax({
        url: "register.php",
        type: "POST",
        data: dataToPost,
        success: function (data) {
            if (data) {
                $('#registerMessage').html(data);
                if (data.includes("success")) {
                    window.setTimeout(function () {
                        window.location.href = "index.php";
                    }, 4000); 
                } 
            } 
        },
        error: function () {
            $('#registerMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
        }
        
    });

});

// AJAX call for the LOG IN form
// once the form is submitted
$('#logInForm').submit(function (event) {
   // prevent default PHP processing 
    "use strict";
    event.preventDefault();
    // collect user inputs
    var dataToPost = $(this).serializeArray();
    // send to logInCheck.php using AJAX
  
    $.ajax({
        url: "logInCheck.php",
        type: "POST",
        data: dataToPost,
        success: function (data) {
            if (data.includes("success")) {
                window.location = "main.php";
            } else {
                $('#logInMessage').html(data);
            }
        },
        error: function () {
            $('#registerMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
        }
        
    });

});

// AJAX call for the FORGOTTEN PASSWORD form
// once the form is submitted
$('#forgotPasswordForm').submit(function (event) {
   // prevent default PHP processing 
    "use strict";
    event.preventDefault();
    // collect user inputs
    var dataToPost = $(this).serializeArray();
    $.ajax({
        url: "forgotpassword.php",
        type: "POST",
        data: dataToPost,
        success: function (data) {
            $('#registerMessage').html(data);
            window.setTimeout(function () {
                window.location.href = "index.php";
            }, 6000);
        },
        error: function () {
            $('#registerMessage').html("<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>");
        }
        
    });

});

