/****************************************
	Author: 	Jackson Powell
	Unit:		The Web - INB271
 ****************************************/

//Registers a user if they pass validation tests from form input
function registerUser() {
	
	//Is the username filled in, is it less than 16 characters in length?
	var user = document.forms["registerForm"]["username"].value;
	if(user == null || user == "") {
		alert("Username must be filled out");
		return false;
	}
	if(user.length > 16) {
		alert("Username cannot be longer than 16 characters long");
		return false;
	}
	
	//Is the email filled in, is it less than 50 characters in length?
	var email = document.forms["registerForm"]["email"].value;
	if(email == null || email == "") {
		alert("Email must be filled out correctly");
		return false;
	}
	if(email.length > 50) {
		alert("Email cannot be longer than 50 characters long");
		return false;
	}
	//Check if the email attributes are in correct places
	if(email.indexOf("@") < 1 || email.indexOf(".") < email.indexOf("@") + 2
	|| email.indexOf(".") >= email.length) {
		alert("Not a valid e-mail address");
		return false;
	}
	
	//Do the passwords match and are they longer than or equal to 5 characters.
	var password = document.forms["registerForm"]["password"].value;
	var passwordConfirm = document.forms["registerForm"]["password_confirm"].value;
	if(password == null || passwordConfirm == null || passwordConfirm == "" || password == "") {
		alert("Password must be filled out");
		return false;
	}
	if(passwordConfirm < 5 || password.length < 5) {
		alert("Password cannot be shorter than 5 characters");
		return false;
	}
	if(passwordConfirm != password) {
		alert("Password confirmation doesn't match");
		return false;
	}
	
	//Check date regardless of HTML5, as HTML5 doesn't provide accurate check, only assists	
	//Regular expression for date formatting.
	var pattern = /^(\d{1,2})(\/|-)(\d{1,2})\2(\d{4})$/;
	
	var birthday = document.forms["registerForm"]["birthday"].value;
	if(pattern.test(birthday)) {
		var matchArray = birthday.match(pattern); // is the format ok?

		day = matchArray[1]; // parse date into variables
		month = matchArray[3];
		year = matchArray[4];
		
		//Check the consistency of the inputted data to real world dates
		if (day < 1 || day > 31) {
			alert("Day must be between 1 and 31.");
			return false;
		}
		if (month < 1 || month > 12) { //Check month range
			alert("Month must be between 1 and 12.");
			return false;
		}
		if ((month==4 || month==6 || month==9 || month==11) && day==31) {
			alert("Month "+month+" doesn't have 31 days!")
			return false
		}
		if (month == 2) { //Check for february 29th/leap year calculation
			var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
			if (day>29 || (day==29 && !isleap)) {
				alert("February " + year + " doesn't have " + day + " days!");
				return false;
			}
		}
	} else if (birthday != "") {	//If the date isn't inputted as DD/MM/YYYY
		alert("Date invalid, please use DD/MM/YYYY");
		return false;
	}
}