<?php

$action=get_request_param('action');

if(array_key_exists('__TERMS_VERSION__', $_SESSION) == FALSE) {

	if($action=='accept'){
		$_SESSION['__TERMS_VERSION__']=__TERMS_VERSION__;
	} else {
		include('../templates/terms.tpl.php');
		die();	
	}
	
} elseif ($_SESSION['__TERMS_VERSION__']!=__TERMS_VERSION__) {
	unset($_SESSION['__TERMS_VERSION__']);
	include('../templates/terms.tpl.php');
	die();	
}

?>