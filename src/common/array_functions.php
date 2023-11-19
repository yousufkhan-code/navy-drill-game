<?php
function re_key_by_id($old_array,$id)
{
	$new_array=array();
	foreach ($old_array as $row)
	{
		if(array_key_exists($id, $row))
		{
			$new_array[$row[$id]]=$row;	
		}
	}
	return $new_array;
}


?>
