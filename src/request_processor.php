<?php
$url="";
if(array_key_exists('REDIRECT_URL',$_SERVER))
{
    $url=$_SERVER['REDIRECT_URL'];
}
elseif (array_key_exists('REQUEST_URI',$_SERVER))
{
    $url=$_SERVER['REQUEST_URI'];
}


if(substr($url,-1)=="/")
{
    $url=substr($url,0,-1);
}

switch ($url)
{
	case "/navy-drill/register":
		echo "register user";
		break;
	
	default:
		echo "hello world";
		echo $url;
		break;
}
?>