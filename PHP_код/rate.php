<?php
    $hostname = "carrental.local";

    $username = "root";

    $password = "";

    $dbName = "CarRental";

?>
<!DOCTYPE html>
<html>
	
<head>

<style>
	.gamma {
	  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	  border-collapse: collapse;
	  table-layout: auto;
	}
	
	.gamma th{
		padding-top: 5px;
		padding-bottom: 5px;
		text-align: left;
		background-color: #4CAF50;
		color: white;
  }
  	.edit_btn {
		text-decoration: none;
		padding: 2px 5px;
		background: #2E8B57;
		color: white;
		border-radius: 3px;
	}

	#Insert, .btn {
		text-decoration: none;
		font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
		padding: 5px 5px;
		border-radius: 5px;
		font-weight: bold;
		font-size: 15px;
	}
  	
	.gamma tr:nth-child(even){
		background-color: #f2f2f2;
	}

	.gamma tr:hover {
		background-color: #ddd;
	}
	
  
	.gamma td, .gamma th{
		border: 1px solid #ddd;
		padding: 8px;
	}
	
	.gamma td{
		padding: 2px;
	}
	
	.alpha{
		text-align: left;
		width: 120px;
		text-layout: fixed;
	}
	
	.delta td, #Insert{
		border-collapse: collapse;
		table-layout: auto;
		border: 1px solid;
		width: 100px;
	}
	
	input[type=text], #cat select {
		padding: 1px 1px;
		margin: 8px 0;
		box-sizing: border-box;
		table-layout: fixed;
		border: 2px solid red;
		border-radius: 4px;
		border-collapse: collapse;
	}
	
	input, #cat select
	{
		text-align: center;
		width: 120px;
		border-collapse: collapse;
	}
	
	
	#Headers td
	{
		text-align: center;
		font-weight: bold;
		font-size: 15px;
	}
	
</style>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>

<title>Тарифы</title>

</head>

<body>

<?php

//$connection = mysqli_connect($hostname, $username, $password);
$connection = mysqli_connect($hostname, $username, $password, $dbName);
if (mysqli_connect_errno()) {
    printf("Не удалось подключиться: %s\n", mysqli_connect_error());
    exit();
}

 
if (isset($_GET["edit"])) {
	$rate_id = $_GET["edit"];
	$update = true;
	$query = "SELECT * FROM `rate` WHERE rate_id = $rate_id";
	$record = mysqli_query($connection, $query);

	if (mysqli_num_rows($record) == 1 ) {
		$n = mysqli_fetch_assoc($record);
		$category_1 = $n["category"];
		$daily_1 = $n["daily"];
		$weekly_1 = $n["weekly"];
		$monthly_1 = $n["monthly"];
	}
}
			
mysqli_set_charset($connection, "utf8mb4");

$rate_id;
$category = $_POST["category"];
$daily = $_POST["daily"];
$weekly = $_POST["weekly"];
$monthly = $_POST["monthly"];


{
		if (isset($_POST['update'])) 
			{	
				$rate_id = $_POST["rate_id"];
				$category_2 = $_POST["category"];
				$daily_2 = $_POST["daily"];
				$weekly_2 = $_POST["weekly"];
				$monthly_2 = $_POST["monthly"];
				
				$query = "CALL updateRate($rate_id, '$category_2', $daily_2, $weekly_2, $monthly_2)";
				if (!mysqli_query($connection, $query))
					{
						DIE('Error: ' . mysqli_error($connection));
					}
				
				echo "Record updated!"; 
			
			}
			
	{	
		$query = "SELECT * FROM `rate`";
		$result = mysqli_query($connection, $query);

		if (mysqli_num_rows($result) == 0)
		{

		  echo "Sorry, empty list <br><br>";

		}

		 else

		{
			 echo "<table border='1' cols='4' cellpadding='1' cellspacing='2' class = 'gamma'>";

			 echo  "<tr>
						<th class='alpha'>Category</th>
						<th class='alpha'>Daily Rate</th>
						<th class='alpha'>Weekly Rate</th>
						<th>Monthly Rate</th>
					</tr>";

			  while ($row = mysqli_fetch_assoc($result)) {

				echo "<tr>";

					echo "<td class='alpha'>".$row["category"]."</td>";

					echo "<td class='alpha'>".$row["daily"]."</td>";

					echo "<td class='alpha'>".$row["weekly"]."</td>";
					
					echo "<td>".$row["monthly"]."</td>";

					echo "<td>";

					echo "<a href='rate.php?edit=". $row["rate_id"] . "'" . " class='edit_btn'>Edit</a>";

					echo "</td>";

				 echo "</tr>";

			}
			
			echo "</table><br>";
		}
		//>
	}

}

//mysqli_free_result($result);

echo "<form action='rate.php' method='post' name='rate_form'>";

echo "<table class = 'delta' cols='4'>";

echo "<tr id = 'Headers'>";

echo "<td style='display: none;'><input type='hidden' name='rate_id' value='$rate_id'>";

echo "<td id='cat'>Category: <select class='delta' name='category'>";

{
	$query = "SELECT * FROM `CarRental`.`rate` ORDER BY `rate`.`category`";

	$result = mysqli_query($connection, $query);

	if ($result = mysqli_query($connection, $query))
	{
		while ($row = mysqli_fetch_assoc($result)) {
			if ($category_1 != $row["category"])
				echo"<option value='".$row["rate_id"]."'>".$row["category"]."</option>";
			else
				echo "<option selected='selected'>$category_1</option>";
		}
	}

	else 
		DIE('Error: <br/>' . mysqli_error($connection));
}

echo "</select></td>";

echo "<td>Daily Rate: <input type='text' name='daily' value='$daily_1'></input></td>";

echo "<td>Weekly Rate: <input type='text' name='weekly' value='$weekly_1'></input></td>";

echo "<td>Monthly Rate: <input type='text' name='monthly' value='$monthly_1'></input></td>";

echo "</tr>";

echo "</table>";

echo "<table class = 'delta'>";

echo "<tr>";

echo "</tr>";

echo "</table>";

echo "<button class='btn' type='submit' name='update' id = 'Insert'>Update</button>";

echo "</form>";

mysqli_close($connection);


?>

</body>

</html>