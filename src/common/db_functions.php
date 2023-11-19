<?php
function fetch_all_rows($sql, $dto = NULL, $db_handle = NULL)
{
	global $database_handle;
	$which_db_handle = $database_handle;
	if(!empty($db_handle))
	{
		$which_db_handle = $db_handle;
	}
	$db_query_statement = $which_db_handle->prepare($sql);
	if(!empty($dto))
	{
		$db_query_statement->execute($dto);
	}
	else
	{
		$db_query_statement->execute();
	}
	return $db_query_statement->fetchAll();
}



function update_db($sql,$dto = NULL, $db_handle = NULL)
{
	global $database_handle;
	$which_db_handle = $database_handle;
	if(!empty($db_handle))
	{
		$which_db_handle = $db_handle;
	}
	$db_query_statement = $which_db_handle->prepare($sql);
	if(!empty($dto))
	{
		$db_query_statement->execute($dto);
	}
	else
	{
		$db_query_statement->execute();
	}
	return $db_query_statement->errorInfo();
}

function fetch_one_row($sql, $column = NULL, $dto = NULL, $db_handle = NULL)
{
	global $database_handle;
	$which_db_handle = $database_handle;
	if(!empty($db_handle))
	{
		$which_db_handle = $db_handle;
	}
	$db_query_statement = $which_db_handle->prepare($sql);
	if(!empty($dto))
	{
		$db_query_statement->execute($dto);
	}
	else
	{
		$db_query_statement->execute();
	}
	$row = $db_query_statement->fetch();
	if(!empty($column) && !empty($row) && array_key_exists($column, $row))
	{
		return $row[$column];
	}
	else
	{
		return $row;
	}
}

function cleanup_sql_results_as_hash($results)
{
	if(empty($results))
	{
		return $results;
	}

	$hash_dataset = array();
	$headers = array();
	foreach ($results[0] as $column_names => $column_values)
	{
		if(!is_numeric($column_names))
		{
			$headers[]=$column_names;
		}
	}

	foreach ($results as $row_index => $row_data)
	{
		$row = array();
		foreach ($headers as $headers_name)
		{
			$data = $row_data[$headers_name];
			if(substr($headers_name, -10)=="_timestamp")
			{
				$data = DateTime::createFromFormat('Y-m-d H:i:s', $data);
			}
			$row[$headers_name]=$data;
		}
		$hash_dataset[] = $row;
	}
	return $hash_dataset;
}


?>
