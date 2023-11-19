<?php
function output_if($c, $v)
{
	if($c)
	{
		echo $v;
	}
}

function output_if_match($a, $b, $v)
{
	if($a == $b)
	{
		echo $v;
	}
}

function echo_if_exists($obj, $default_value)
{
	if(!empty($obj))
	{
		echo $obj;
	}
	else
	{
		echo $default_value;
	}
}

function http_params_to_url($url_prefix='', $additional_params=FALSE)
{
	$all_params = array();
	if(!empty($_GET))
	{
		$all_params=array_merge($all_params,$_GET);
	}
	if(!empty($_POST))
	{
		$all_params=array_merge($all_params,$_POST);
	}
	if(!empty($additional_params))
	{
		$all_params=array_merge($all_params,$additional_params);
	}
	if(!empty($all_params))
	{
		return $url_prefix.'?'.http_build_query($all_params);
	}
	else
	{
		return '';
	}

}
?>
