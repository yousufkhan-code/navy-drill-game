<?php
$registration_successful=false;
$errors=array();
if(array_key_exists('action', $_POST)){
	$existing_user_record_by_email=fetch_all_rows("select * from users where email = :user_email", array('user_email'=>$_POST['email']));
	$existing_user_record_by_name=fetch_all_rows("select * from users where username = :user_name", array('user_name'=>$_POST['username']));

	if($_POST['password'] != $_POST['password_repeat']){
		$errors[]="Sorry your password doesnt match, make sure password and confirm password are the exact same, then try again!";
	} elseif (!empty($existing_user_record_by_email)) {
		$errors[]="Sorry, this email is used for an existing account on this platform.";
	} elseif (!empty($existing_user_record_by_name)){
		$errors[]="Sorry this username has been taken, try another username";
	}

	if(empty($errors)){

		$encrypted_password=crypt($_POST['password'],__PASS_SALT__);
		$_POST['password']=$encrypted_password;

		$results=update_db(
			"insert into users (email,username,password) values (:email,:username,:password)",
			array(
				'email'=>$_POST['email'],
				'username'=>$_POST['username'],
				'password'=>$_POST['password']
			)
		);
		if($results===false){
			$errors[]="unable to insert in database";
		} elseif(!is_array($results)){
			$errors[]="Sorry database error has occured: $results";
		} else{
			$registration_successful=true;
		}

	}
	
}
$data_transfer_object=array('errors'=>$errors,'registration_successful'=>$registration_successful);
$template_engine=new PressEngine('register.tpl.html', $data_transfer_object, '../templates/');
echo $template_engine->contentString;


?>