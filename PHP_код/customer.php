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

<title>Пользователи</title>

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
	$customer_id = $_GET["edit"];
	$update = true;
	$query = "SELECT * FROM `customer` WHERE customer_id = $customer_id";
	$record = mysqli_query($connection, $query);

	if (mysqli_num_rows($record) == 1 ) {
		$n = mysqli_fetch_assoc($record);
		$first_name_1 = $n["first_name"];
		$last_name_1 = $n["last_name"];
		$phone_1 = $n["phone"];
		$address_1 = $n["address"];
		$zip_code_1 = $n["zip_code"];
		$license_number_1 = $n["license_number"];
		$country_1 = $n["country"];
		$city_1 = $n["city"];
	}
}
			
	if (isset($_GET['del'])) 
		{
			$customer_id = $_GET['del'];
			$query = "CALL deleteCustomer($customer_id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
			mysqli_query($connection, $query);
				if (!mysqli_query($connection, $query))
			{
				DIE('Error: ' . mysqli_error($connection));
			}
			echo "Record deleted!";
		}
mysqli_set_charset($connection, "utf8mb4");

$customer_id;
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$zip_code = $_POST["zip_code"];
$license_number = $_POST["license_number"];
$country = $_POST["country"];
$city = $_POST["city"];


{
		if (isset($_POST['update'])) 
			{	
				$customer_id = $_POST["customer_id"];
				$first_name_2 = $_POST["first_name"];
				$last_name_2 = $_POST["last_name"];
				$phone_2 = $_POST["phone"];
				$address_2 = $_POST["address"];
				$zip_code_2 = $_POST["zip_code"];
				$license_number_2 = $_POST["license_number"];
				$country_2 = $_POST["country"];
				$city_2 = $_POST["city"];
				
				$query = "CALL updateCustomer($customer_id, '$first_name_2', '$last_name_2', '$phone_2', '$address_2', '$zip_code_2', '$license_number_2', '$country_2', '$city_2')";
				if (!mysqli_query($connection, $query))
					{
						DIE('Error: ' . mysqli_error($connection));
					}
				
				echo "Record updated!"; 
			
			}
			
		if (isset($_POST['insert']))
			{
				$query = "CALL insertCustomer('$first_name', '$last_name', '$phone', '$address', '$zip_code', '$license_number', '$country', '$city')";
					if (!mysqli_query($connection, $query))
					{
						DIE('Error: ' . mysqli_error($connection));
					}

				echo "1 record added";
			}
	{	
		$query = "SELECT * FROM `customer`";
		$result = mysqli_query($connection, $query);

		if (mysqli_num_rows($result) == 0)
		{

		  echo "Sorry, empty list <br><br>";

		}

		 else

		{
			 echo "<table border='1' cols='8' cellpadding='1' cellspacing='2' class = 'gamma'>";

			 echo  "<tr>
						<th class='alpha'>Fist Name</th>
						<th class='alpha'>Last Name</th>
						<th class='alpha'>Telephone</th>
						<th>Address</th>
						<th>Zip Code</th>
						<th class='alpha'>License</th>
						<th class='alpha'>Country</th>
						<th>City</th>
					</tr>";

			  while ($row = mysqli_fetch_assoc($result)) {

				echo "<tr>";

					echo "<td class='alpha'>".$row["first_name"]."</td>";

					echo "<td class='alpha'>".$row["last_name"]."</td>";

					echo "<td class='alpha'>".$row["phone"]."</td>";

					echo "<td class='address expand'>".$row["address"]."</td>";
					
					echo "<td>".$row["zip_code"]."</td>";

					echo "<td class='alpha'>".$row["license_number"]."</td>";

					echo "<td class='alpha'>".$row["country"]."</td>";

					echo "<td>".$row["city"]."</td>";

					echo "<td>";

					echo "<a href='customer.php?edit=". $row["customer_id"] . "'" . " class='edit_btn'>Edit</a>";

					echo "</td>";

					echo "<td>";

					echo "<a href='customer.php?del=" . $row["customer_id"] . "'" . " class='del_btn'>Delete</a>";

					echo "</td>";

				 echo "</tr>";

			}
			
			echo "</table><br>";
		}
		//>
	}

}

//mysqli_free_result($result);

echo "<form action='customer.php' method='post' name='customer_form'>";

echo "<table class = 'delta' cols='8'>";

echo "<tr id = 'Headers'>";

echo "<td style='display: none;'><input type='hidden' name='customer_id' value='$customer_id'>";

echo "<td>First Name: <input type='text' name='first_name' value='$first_name_1'></input></td>";

echo "<td>Last Name: <input type='text' name='last_name' value='$last_name_1'></input></td>";

echo "<td>Telephone: <input type='text' name='phone' value='$phone_1'></input></td>";

echo "<td>Address: <input type='text' name='address' value='$address_1'></input></td>";

echo "<td>Zip Code: <input type='text' name='zip_code' value='$zip_code_1'></input></td>";

echo "<td>License: <input type='text' name='license_number' value='$license_number_1'></input></td>";

echo "<td>Country: <input type='text' name='country' value='$country_1'></input></td>";

echo "<td>City: <input type='text' name='city' value='$city_1'></input></td>";

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