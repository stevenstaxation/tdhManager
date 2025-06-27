/*eslint-env jquery */
/*eslint-env browser */
/*jslint browser: true */
/*global $, jQuery, alert*/

/**
 * When sign up button is clicked, check email, username and
 * passwords are valid and meet the necessary security requirements.
 * If all is OK, send an email to the new user for them to verify their
 * account and return to log in page
 */
$("#signUpForm").submit(function (event) {
  "use strict";
  event.preventDefault();
  var dataToPost = $(this).serializeArray();
  dataToPost.push({
    name: "logInType",
    value: $("#hiddenUserType").html(),
  });

  $.ajax({
    url: "register.php",
    type: "POST",
    data: dataToPost,
    success: function (data) {
      if (data) {
        $("#registerMessage").html(data);
        if (data.includes("success")) {
          window.setTimeout(function () {
            window.location.href = "index.php";
          }, 4000);
        }
      }
    },
    error: function () {
      $("#registerMessage").html(
        "<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>"
      );
    },
  });
});

/**
 * When login button is clicked, check username and password exist and are
correct.  If so login and show main window.  If not show error message
for four seconds and do not allow log in.
 */
$("#logInForm").submit(function (event) {
  // prevent default PHP processing
  "use strict";
  event.preventDefault();
  // collect user inputs
  var dataToPost = $(this).serializeArray();

  $.ajax({
    url: "logInCheck.php",
    type: "POST",
    data: dataToPost,
    success: function (data) {
      if (data.includes("success")) {
        window.location = "main.php";
      } else {
        $("#logInMessage").html(data);
        setTimeout(function () {
          $("#logInMessage").html("");
        }, 4000);
      }
    },
    error: function () {
      $("#registerMessage").html(
        "<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>"
      );
    },
  });
});

// AJAX call for the FORGOTTEN PASSWORD form
// once the form is submitted
$("#forgotPasswordForm").submit(function (event) {
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
      $("#registerMessage").html(data);
      window.setTimeout(function () {
        window.location.href = "index.php";
      }, 6000);
    },
    error: function () {
      $("#registerMessage").html(
        "<div class='alert alert-danger'>TDH Manager is not available at the moment. Contact your administrator.</div>"
      );
    },
  });
});
