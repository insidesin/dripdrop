<?php 

include('includes/db_consts.php'); //Include MySQL db connection info.
include('includes/register_user.php');

//MAIN FORM-CREATION START - Creates the registration form.
echo '<script type="text/javascript" src="js/register_user.js"></script>';		//Allow for .js validation
echo '<form name="registerForm" onsubmit="return registerUser()" action="register.php?register=1" method="post">';
	
	//Generate fields based on their seperate functions.
	formTextField('Username', 'username', true, 'text', isset($username) ? $username : '', $errors);
	formTextField('Email', 'email', true, 'email', isset($email) ? $email : '', $errors);
	formTextField('Password', 'password', true, 'password', isset($password) ? $password : '', $errors);
	formTextField('Confirm Password', 'password_confirm', true, 'password', isset($password_confirm) ? $password_confirm : '', $errors);
	formTextField('Date of Birth', 'birthday', false, 'text', isset($birthday) ? $birthday : '', $errors);
	
	formDropDownField('Gender', 'gender', false, array('Not telling', 'Male', 'Female'), 
		isset($gender) ? $gender : 'Not telling', $errors);
	
	formDropDownField('Disability status', 'disability', false, array('No disability', 'Require disability access'), 
		isset($disabled) ? $disabled : 'No disability', $errors);
        
	formCheckbox('Subscribe to newsletter', 'newsletter', false, isset($subscribe) ? $subscribe : 0, $errors);
	
	echo '<h4 class="form_caption"><input class="form_data" type="submit" value="Submit" /></h4>';
	
echo '</form>';

/*
 * Creates a text field wherever this function is called.
 * Allows for many different options and provides errors where appropriate.
 */
function formTextField($caption, $name, $required, $type, $prefill, $errors) {
	echo "<h4 class=\"form_caption\">";
	if($required) 
		echo "<span class=\"required\">*</span>";
	echo "$caption: ";
    echo "<input class=\"form_data\" type=\"$type\" id=\"$name\" name=\"$name\" value=\"$prefill\" ";
	if($required)
		echo "required";
	echo "></h4>";
	
	//Display any errors if the field has any.
	if(isset($errors["$name"])) {
		echo "<div class=\"alert\"> $errors[$name] </div>";
	}
}

/*
 * Creates a dropdown field wherever this function is called.
 * Allows for many different options and provides errors where appropriate.
 */
function formDropDownField($caption, $name, $required, $options, $prefill, $errors) {
	echo "<h4 class=\"form_caption\">";
	if($required) 
		echo "<span class=\"required\">*</span>";
	echo "$caption: ";
    echo "<select class=\"form_data\" id=\"$name\" name=\"$name\" ";
	if($required)
		echo "required";
	echo ">";
		
	foreach ($options as $optionField) {
		if($optionField == $prefill)
			echo "<option selected>$optionField</option>";
		else
			echo "<option>$optionField</option>";
	}
	
	echo "</select></h4>";
	
	//Display any errors if the field has any.
	if(isset($errors["$name"])) {
		echo "<div class=\"alert\"> $errors[$name] </div>";
	}
}

/*
 * Creates a checkbox field wherever this function is called.
 * Allows for many different options and provides errors where appropriate.
 */
function formCheckbox($caption, $name, $required, $prefill, $errors) {
	echo "<h4 class=\"form_caption\">";
	if($required) 
		echo "<span class=\"required\">*</span>";
	echo "$caption: ";
    echo "<input class=\"form_data\" type=\"checkbox\" id=\"$name\" name=\"$name\" ";
	if($prefill == 1) //TRUE
		echo "checked";
	if($required)
		echo "required";
	echo "></h4>";
	
	//Display any errors if the field has any.
	if(isset($errors["$name"])) {
		echo "<div class=\"alert\"> $errors[$name] </div>";
	}
}


/*
 * Adds a certain error to the field's error list. Stored in array of strings.
 */
function alertInvalid(&$errors, $field_name, $alert_text) {
	if(isset($errors["$field_name"]))
		$errors[$field_name] += "$alert_text ";
	else
		$errors[$field_name] = "$alert_text ";
}

?>