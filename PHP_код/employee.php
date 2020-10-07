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
	
	.del_btn {
		text-decoration: none;
		padding: 2px 5px;
		color: white;
		border-radius: 3px;
		background: #800000;
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
	
	.address
	{
		max-width: 200px;
		white-space : nowrap;
		overflow : hidden;
	}
	
	.expand:hover 
	{
		max-width : initial; 
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
	
	
	#Headers td
	{
		text-align: center;
		font-weight: bold;
		font-size: 15px;
	}
	
</style>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>

<title>Сотрудники</title>

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
	$employee_id = $_GET["edit"];
	$update = true;
	$query = "SELECT * FROM `employee` WHERE employee_id = $employee_id";
	$record = mysqli_query($connection, $query);

	if (mysqli_num_rows($record) == 1 ) {
		$n = mysqli_fetch_assoc($record);
		$employee_number_1 = $n["employee_number"];
		$first_name_1 = $n["first_name"];
		$last_name_1 = $n["last_name"];
		$hourly_salary_1 = $n["hourly_salary"];
	}
}
			
	if (isset($_GET['del'])) 
		{
			$employee_id = $_GET['del'];
			$query = "CALL deleteEmployee($employee_id, NULL, NULL, NULL, NULL)";
			mysqli_query($connection, $query);
				if (!mysqli_query($connection, $query))
			{
				DIE('Error: ' . mysqli_error($connection));
			}
			echo "Record deleted!";
		}
mysqli_set_charset($connection, "utf8mb4");

$employee_id;
$employee_number = $_POST["employee_number"];
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$hourly_salary = $_POST["hourly_salary"];


{
		if (isset($_POST['update'])) 
			{	
				$employee_id = $_POST["employee_id"];
				$employee_number_2 = $_POST["employee_number"];
				$first_name_2 = $_POST["first_name"];
				$last_name_2 = $_POST["last_name"];
				$hourly_salary_2 = $_POST["hourly_salary"];
				
				$query = "CALL updateEmployee($employee_id, $employee_number_2, '$first_name_2', '$last_name_2', $hourly_salary_2)";
				if (!mysqli_query($connection, $query))
					{
						DIE('Error: ' . mysqli_error($connection));
					}
				
				echo "Record updated!"; 
			
			}
			
		if (isset($_POST['insert']))
			{
				$query = "CALL insertEmployee($employee_number, '$first_name', '$last_name', $hourly_salary)";
					if (!mysqli_query($connection, $query))
					{
						DIE('Error: ' . mysqli_error($connection));
					}

				echo "1 record added";
			}
	{	
		$query = "SELECT * FROM `employee`";
		$result = mysqli_query($connection, $query);

		if (mysqli_num_rows($result) == 0)
		{

		  echo "Sorry, empty list <br><br>";

		}

		 else

		{
			 echo "<table border='1' cols='4' cellpadding='1' cellspacing='2' class = 'gamma'>";

			 echo  "<tr>
						<th class='alpha'>PID</th>
						<th class='alpha'>Fist Name</th>
						<th class='alpha'>Last Name</th>
						<th>Salary/hour</th>
					</tr>";

			  while ($row = mysqli_fetch_assoc($result)) {

				echo "<tr>";

					echo "<td class='alpha'>".$row["employee_number"]."</td>";

					echo "<td class='alpha'>".$row["first_name"]."</td>";

					echo "<td class='alpha'>".$row["last_name"]."</td>";
					
					echo "<td>".$row["hourly_salary"]."</td>";

					echo "<td>";

					echo "<a href='employee.php?edit=". $row["employee_id"] . "'" . " class='edit_btn'>Edit</a>";

					echo "</td>";

					echo "<td>";

					echo "<a href='employee.php?del=" . $row["employee_id"] . "'" . " class='del_btn'>Delete</a>";

					echo "</td>";

				 echo "</tr>";

			}
			
			echo "</table><br>";
		}
		//>
	}

}

//mysqli_free_result($result);

echo "<form action='employee.php' method='post' name='employee_form'>";

echo "<table class = 'delta' cols='4'>";

echo "<tr id = 'Headers'>";

echo "<td style='display: none;'><input type='hidden' name='employee_id' value='$employee_id'>";

echo "<td>PID: <input type='text' name='employee_number' value='$employee_number_1'></input></td>";

echo "<td>First Name: <input type='text' name='first_name' value='$first_name_1'></input></td>";

echo "<td>Last Name: <input type='text' name='last_name' value='$last_name_1'></input></td>";

echo "<td>Salary/hour: <input type='text' name='hourly_salary' value='$hourly_salary_1'></input></td>";

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