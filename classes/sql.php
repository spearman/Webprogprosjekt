<?php

class sql extends mysqli
{
	function __construct()
	{
		parent::__construct("84.209.111.93","webprosjekt","web123","web_prosjekt","3306");

		if(mysqli_connect_error())
			die("Kunne ikke opprette tilkobling til databasen: (".mysqli_connect_errno().") ".mysqli_connect_error());
	}
	
	function close()
	{
	   parent::kill($this->thread_id);
	   parent::close();
	}
}
?>