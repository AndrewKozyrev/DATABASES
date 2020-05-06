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
	  table-layout: fixed;
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
	
	.del_btn {
		text-decoration: none;
		padding: 2px 5px;
		color: white;
		border-radius: 3px;
		background: #800000;
	}
  
	.gamma td, .gamma th{
		border: 1px solid #ddd;
		padding: 8px;
	}
	
	.gamma td{
		padding: 2px;
	}
	
	
	.gamma tr:nth-child(even){background-color: #f2f2f2;}

	.gamma tr:hover {background-color: #ddd;}
	
	.alpha{
		text-align: center;
		text-layout: fixed;
		width: 100px;
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
	
	input
	{
		text-align: center;
		width: 120px;
		border-collapse: collapse;
	}
	
	#cat select {
		width: 120px;
		border-collapse: collapse;
		text-align: center;
	}
	
	#AC
	{
		font-size: 15px;
	}
	
	#Headers td
	{
		text-align: center;
		font-weight: bold;
		font-size: 15px;
	}
	
	#TAG, #MODEL, #MAKE
	{
		width: 120px;
	}
	
</style>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>

<title>Автомобили</title>

</head>

<body>

<?php

//$connection = mysqli_connect($hostname, $username, $password);
$connection = mysqli_connect($hostname, $username, $password, $dbName);
if (mysqli_connect_errno()) {
    printf("Не удалось подключиться: %s\n", mysqli_connect_error());
    exit();
}

/*if(!$connection)
{
    DIE("Can't create a connection! <br/>". mysqli_error(TRUE));
}
*/

//@mysqli_select_db($connection, $dbName) OR DIE ("Can't select a database! <br/>". mysqli_error());
 
if (isset($_GET["edit"])) {
	$car_id = $_GET["edit"];
	$update = true;
	$query = "SELECT * FROM `vehicle` WHERE car_id = $car_id";
	$record = mysqli_query($connection, $query);

	if (mysqli_num_rows($record) == 1 ) {
		$n = mysqli_fetch_assoc($record);
		$tag_number_1 = $n["tag_number"];
		$model_1 = $n["model"];
		$make_1 = $n["make"];
		$car_year_1 = $n["car_year"];
		$category_1 = $n["category"];
		$mp3_layer_1 = $n["mp3_layer"];
		$dvd_player_1 = $n["dvd_player"];
		$air_conditioner_1 = $n["air_conditioner"];
		$navigation_1 = $n["navigation"];
		$available_1 = $n["available"];
	}
}
			
	if (isset($_GET['del'])) 
		{
			$car_id = $_GET['del'];
			$query = "CALL deleteVehicle($car_id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
			mysqli_query($connection, $query);
				if (!mysqli_query($connection, $query))
			{
				DIE('Error: ' . mysqli_error($connection));
			}
			echo "Record deleted!";
		}
mysqli_set_charset($connection, "utf8mb4");

$car_id;
$tag_number = $_POST["tag_number"];
$model = $_POST["model"];
$make = $_POST["make"];
$car_year = $_POST["car_year"];
$category = $_POST["category"];
$mp3_layer = $_POST["mp3_layer"];
$dvd_player = $_POST["dvd_player"];
$air_conditioner = $_POST["air_conditioner"];
$navigation = $_POST["navigation"];
$available = $_POST["available"];

{
		if (isset($_POST['update'])) 
			{	
				$car_id = $_POST["car_id"];
				$tag_number_2 = $_POST["tag_number"];
				$model_2 = $_POST["model"];
				$make_2 = $_POST["make"];
				$car_year_2 = $_POST["car_year"];
				$category_2 = $_POST["category"];
				$mp3_layer_2 = $_POST["mp3_layer"];
				$dvd_player_2 = $_POST["dvd_player"];
				$air_conditioner_2 = $_POST["air_conditioner"];
				$navigation_2 = $_POST["navigation"];
				$available_2 = $_POST["available"];
				
				$query = "CALL updateVehicle($car_id, '$tag_number_2', '$model_2', '$make_2', $car_year_2, '$category_2', $mp3_layer_2, $dvd_player_2, $air_conditioner_2, $navigation_2, $available_2)";
				if (!mysqli_query($connection, $query))
					{
						DIE('Error: ' . mysqli_error($connection));
					}
				
				echo "Record updated!"; 
			
			}
			
		if (isset($_POST['insert']))
			{
				$query = "CALL insertVehicle('$tag_number', '$model', '$make', $car_year, '$category', $mp3_layer, $dvd_player, $air_conditioner, $navigation, $available)";
					if (!mysqli_query($connection, $query))
					{
						DIE('Error: ' . mysqli_error($connection));
					}

				echo "1 record added";
			}
	{	
		$query = "SELECT * FROM `vehicle`";
		$result = mysqli_query($connection, $query);

		/**
		*
		*/
		if (mysqli_num_rows($result) == 0)
		{

		  echo "Sorry, empty list <br><br>";

		}

		 else

		{
			 echo "<table border='1' cols='10' cellpadding='1' cellspacing='2' class = 'gamma'>";

			 echo  "<tr>
						<th id='TAG'>Tag Number</th>
						<th id='MODEL'>Model</th>
						<th id='MAKE'>Make</th>
						<th class = 'alpha'>Year</th>
						<th class = 'alpha'>Category</th>
						<th class = 'alpha'>mp3 Player</th>
						<th class = 'alpha'>DVD Player</th>
						<th class = 'alpha'>Air Conditioner</th>
						<th class = 'alpha'>Navigation</th>
						<th class = 'alpha'>Availability</th>
						</tr>";

			  while ($row = mysqli_fetch_assoc($result)) {

				echo "<tr>";

					echo "<td>".$row["tag_number"]."</td>";

					echo "<td>".$row["model"]."</td>";

					echo "<td>".$row["make"]."</td>";

					echo "<td>".$row["car_year"]."</td>";
					
					echo "<td class = 'alpha'>".$row["category"]."</td>";

					echo "<td class = 'alpha'>".$row["mp3_layer"]."</td>";

					echo "<td class = 'alpha'>".$row["dvd_player"]."</td>";

					echo "<td class = 'alpha'>".$row["air_conditioner"]."</td>";

					echo "<td class = 'alpha'>".$row["navigation"]."</td>";

					echo "<td class = 'alpha'>".$row["available"]."</td>";
					
					echo "<td>";

					echo "<a href='vehicle.php?edit=". $row["car_id"] . "'" . " class='edit_btn'>Edit</a>";

					echo "</td>";

					echo "<td>";

					echo "<a href='vehicle.php?del=" . $row["car_id"] . "'" . " class='del_btn'>Delete</a>";

					echo "</td>";

				 echo "</tr>";

			}
			
			echo "</table><br>";
		}
		//>
	}

}

//mysqli_free_result($result);

echo "<form action='vehicle.php' method='post' name='vehicle_form'>";

echo "<table class = 'delta' cols='10'>";

echo "<tr id = 'Headers'>";

echo "<td style='display: none;'><input type='hidden' name='car_id' value='$car_id'>";

echo "<td>Tag Number: <input type='text' name='tag_number' value='$tag_number_1'></input></td>";

echo "<td>Model: <input type='text' name='model' value='$model_1'></input></td>";

echo "<td>Make: <input type='text' name='make' value='$make_1'></input></td>";

echo "<td>Year: <input type='text' name='car_year' value='$car_year_1'></input></td>";

echo "<td id='cat'>Category: <select name='category'>";

/*            --- C ---
Запрос на выборку всех записей из таблицы "rate" и сортировкой
по категории.
*/

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

echo "</select></td>";

echo "<td>mp3 Player: <input type='text' name='mp3_layer' value='$mp3_layer_1'></input></td>";

echo "<td>DVD Player: <input type='text' name='dvd_player' value='$dvd_player_1'></input></td>";

echo "<td id='AC'>Air Conditioner: <input type='text' name='air_conditioner' value='$air_conditioner_1'></input></td>";

echo "<td>Navigation: <input type='text' name='navigation' value='$navigation_1'></input></td>";

echo "<td>Availability: <input type='text' name='available' value='$available_1'></input></td>";

echo "</tr>";

echo "</table>";

echo "<table class = 'delta'>";

echo "<tr>";

echo "</tr>";

echo "</table>";

if ($update == true)
	echo "<button class='btn' type='submit' name='update' style='background: yellow;' >update</button>";
else
	echo "<button class='btn' type='submit' name='insert' id = 'Insert'>Insert</button>";

echo "</form>";

mysqli_close($connection);


?>

</body>

</html>