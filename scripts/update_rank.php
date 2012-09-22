<?
	/* Eqp 07 code
	   Date: Thu, Feb 8, 2007 
	*/

	$db = mysql_connect("192.168.36.253", "equitypulse", "earth");
	mysql_select_db("equitypulse", $db);

	$query = "select login from Login_Portfolio order by Account_value desc";
	$result = mysql_query($query) or die("ERROR: Execute the program again");
	$rank = 1;

	while($row = mysql_fetch_array($result))	{
		$name = $row['login'];
		$query2 = "update Login_Portfolio set Rank=$rank where login='$name'";
		$result2 = mysql_query($query2) or die("ERROR: Execute the program again");
		$rank = $rank + 1;
	}
	
	mysql_close($db);
	//Eqp 07 code ends here
?>
