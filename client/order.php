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
		padding: 2px 10px;
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
		width: 180px;
		text-layout: fixed;
	}
	
	.cell
	{
		max-width: 100px;
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
	
	input[type=text], .option select {
		padding: 1px 1px;
		margin: 8px 0;
		box-sizing: border-box;
		table-layout: fixed;
		border: 2px solid red;
		border-radius: 4px;
		border-collapse: collapse;
	}
	
	input, .option select
	{
		text-align: center;
		width: 200px;
		border-collapse: collapse;
	}
	
	
	
	.fillform td
	{
		text-align: center;
		font-weight: bold;
		font-size: 15px;
	}
	
	.narrow th, td {
		width: 50px;
		text-align: center;
	}
</style>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>

<title>Заказы</title>

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
	$order_id = $_GET["edit"];
	$update = true;
	$query = "SELECT * FROM `order` WHERE order_id = $order_id";
	$record = mysqli_query($connection, $query);

	if (mysqli_num_rows($record) == 1 ) {
		$n = mysqli_fetch_assoc($record);
		$employee_1 = $n["employee_id"];
		$customer_1 = $n["customer_id"];
		$car_1 = $n["car_id"];
		$date_processed_1 = $n["date_processed"];
		$rent_start_date_1 = $n["rent_start_date"];
		$rent_end_date_1 = $n["rent_end_date"];
		$days_1 = $n["days"];
		$rate_applied_1 = $n["rate_applied"];
		$order_total_1 = $n["order_total"];
		$order_status_1 = $n["order_status"];
	}
}
			
	if (isset($_GET['del'])) 
		{
			$order_id = $_GET['del'];
			$query = "CALL deleteOrder($order_id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
				if (!mysqli_query($connection, $query))
			{
				DIE('Error: ' . mysqli_error($connection));
			}
			echo "Record deleted!";
		}
mysqli_set_charset($connection, "utf8mb4");

$order_id;
$employee = $_POST["employee"];
$customer = $_POST["customer"];
$car = $_POST["car"];
$date_processed = $_POST["date_processed"];
$rent_start_date = $_POST["rent_start_date"];
$rent_end_date = $_POST["rent_end_date"];
$days = $_POST["days"];
$rate_applied = $_POST["rate_applied"];
$order_total = $_POST["order_total"];
$order_status = $_POST["order_status"];

{
		if (isset($_POST['update'])) 
			{	
				$order_id = $_POST["order_id"];
				$employee_2 = $_POST["employee"];
				$customer_2 = $_POST["customer"];
				$car_2 = $_POST["car"];
				$date_processed_2 = $_POST["date_processed"];
				$rent_start_date_2 = $_POST["rent_start_date"];
				$rent_end_date_2 = $_POST["rent_end_date"];
				$days_2 = $_POST["days"];
				$rate_applied_2 = $_POST["rate_applied"];
				$order_total_2 = $_POST["order_total"];
				$order_status_2 = $_POST["order_status"];
				
				/*echo "<br>" . "order_id ----> ". "$order_id" . "<br>";
				echo "<br>" . "employee_2 ----> ". "$employee_2" . "<br>";
				echo "<br>" . "customer_2 ----> ". "$customer_2" . "<br>";
				echo "<br>" . "car_2 ----> ". "$car_2" . "<br>";
				echo "<br>" . "date_processed_2 ----> ". "$date_processed_2" . "<br>";
				echo "<br>" . "rent_start_date_2 ----> ". "$rent_start_date_2" . "<br>";
				echo "<br>" . "rent_end_date_2 ----> ". "$rent_end_date_2" . "<br>";
				echo "<br>" . "days_2 ----> ". "$days_2" . "<br>";
				echo "<br>" . "rate_applied_2 ----> ". "$rate_applied_2" . "<br>";
				echo "<br>" . "order_total_2 ----> ". "$order_total_2" . "<br>";
				echo "<br>" . "order_status_2 ----> ". "$order_status_2" . "<br>";
				*/
				{
					$sub_query = "SELECT getRate($rate_applied_2)";
					$sub_result = mysqli_query($connection, $sub_query);
					$sub_row = mysqli_fetch_assoc($sub_result);
					$new_rate = $sub_row["getRate($rate_applied_2)"];
				}
				
				$query = "CALL updateOrder($order_id, $employee_2, $customer_2, $car_2, '$date_processed_2', '$rent_start_date_2', '$rent_end_date_2', $days_2, '$new_rate', $order_total_2, $order_status_2)";
				if (!mysqli_query($connection, $query))
					{
						DIE('Error: ' . mysqli_error($connection));
					}
				
				echo "Record updated!"; 
			
			}
			
		if (isset($_POST['insert']))
			{				
				{
					$sub_query = "SELECT getRate($rate_applied)";
					$sub_result = mysqli_query($connection, $sub_query);
					$sub_row = mysqli_fetch_assoc($sub_result);
					$new_rate = $sub_row["getRate($rate_applied)"];
				}
				
				$query = "CALL insertOrder($employee, $customer, $car, '$date_processed', '$rent_start_date', '$rent_end_date', $days, '$new_rate', $order_total, $order_status)";
					if (!mysqli_query($connection, $query))
					{
						DIE('Error: ' . mysqli_error($connection));
					}

				echo "1 record added";
				
			}
	{	
		$query = "CALL showCuteOrder()";
		//$query = "SELECT * FROM `order`";
		$result = mysqli_query($connection, $query);

		if (mysqli_num_rows($result) == 0)
		{

		  echo "Sorry, empty list <br><br>";

		}

		 else

		{
			 echo "<table border='1' cols='10' cellpadding='1' cellspacing='2' class = 'gamma'>";

			 echo  "<tr>
						<th class='alpha'>Employee</th>
						<th class='alpha'>Customer</th>
						<th class='alpha'>Vehicle</th>
						<th class='alpha'>Date Processed</th>
						<th class='alpha'>Start Date</th>
						<th class='alpha'>End Date</th>
						<th class='narrow'>Days</th>
						<th class='narrow'>Applied Rate</th>
						<th class='narrow'>Order Total</th>
						<th class='narrow'>Order Status</th>						
					</tr>";

			  while ($row = mysqli_fetch_assoc($result)) {

				echo "<tr>";

					echo "<td class='alpha cell expand'>".$row["EMPLOYEE"]."</td>";

					echo "<td class='alpha'>".$row["CUSTOMER"]."</td>";

					echo "<td class='alpha cell expand'>".$row["VEHICLE"]."</td>";
					
					echo "<td class='alpha cell expand'>".$row["date_processed"]."</td>";

					echo "<td class='alpha cell expand'>".$row["rent_start_date"]."</td>";

					echo "<td class='alpha cell expand'>".$row["rent_end_date"]."</td>";

					echo "<td class='narrow'>".$row["days"]."</td>";
					
					echo "<td class='cell expand'>".$row["rate_applied"]."</td>";

					echo "<td class='narrow'>".$row["order_total"]."</td>";
					
					echo "<td class='narrow'>".$row["order_status"]."</td>";
					
					echo "<td>";

					echo "<a href='order.php?edit=". $row["order_id"] . "'" . " class='edit_btn'>Edit</a>";

					echo "</td>";

					echo "<td>";

					echo "<a href='order.php?del=" . $row["order_id"] . "'" . " class='del_btn'>Delete</a>";

					echo "</td>";

				 echo "</tr>";

			}
			
			echo "</table><br>";
		}
		while($connection->next_result()) $connection->store_result();
	}
}
{
		echo "<form action='order.php' method='post' name='order_form'>";

		echo "<table class = 'delta' cols='5'>";

		echo "<tr class = 'fillform'>";

		echo "<td style='display: none;'><input type='hidden' name='order_id' value='$order_id'>";

		echo "<td class='option'>Employee: <select class='delta' name='employee'>";
		{
			$query = "SELECT `employee_id`, `employee_number` FROM `CarRental`.`employee` ORDER BY `employee`.employee_number";

			if ($result = mysqli_query($connection, $query))
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$temp_id = $row["employee_id"];
					$sub_query = "SELECT getEmployee($temp_id)";
					$sub_result = mysqli_query($connection, $sub_query);
					$sub_row_1 = mysqli_fetch_assoc($sub_result);
					if ($employee_1 != $row["employee_id"])
					{
						echo "<option value='" . $row["employee_id"] . "'>" . $sub_row_1["getEmployee($temp_id)"] . "</option>";
					}
					else
					{
						echo "<option selected='selected' value='". $row["employee_id"] . "'>" . $sub_row_1["getEmployee($temp_id)"] . "</option>";
					}
				}
			}
			
			else 
				DIE('Error: <br/>' . mysqli_error($connection));
					
			while($connection->next_result()) $connection->store_result();
		}
		echo "</select></td>";

		echo "<td class='option'>Customer: <select class='delta' name='customer'>";

		{
			$query = "SELECT `customer_id`, `first_name` FROM `CarRental`.`customer` ORDER BY `customer`.first_name";

			if ($result = mysqli_query($connection, $query))
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$temp_id = $row["customer_id"];
					$sub_query = "SELECT getCustomer($temp_id)";
					$sub_result = mysqli_query($connection, $sub_query);
					$sub_row = mysqli_fetch_assoc($sub_result);
					
					if ($customer_1 != $row["customer_id"])
					{
						echo "<option value='" . $row["customer_id"] . "'>" . $sub_row["getCustomer($temp_id)"] . "</option>";
					}
					else
					{
						echo "<option selected='selected' value='". $row["customer_id"] . "'>" . $sub_row["getCustomer($temp_id)"] . "</option>";
					}
				}
			}
			
			else 
				DIE('Error: <br/>' . mysqli_error($connection));
		}
		echo "</select></td>";

		echo "<td class='option'>Vehicle: <select class='delta' name='car'>";

		{
		
			$query = "SELECT `car_id`, `category` FROM `CarRental`.`vehicle` ORDER BY `vehicle`.category";

			if ($result = mysqli_query($connection, $query))
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$temp_id = $row["car_id"];
					$sub_query = "SELECT getCar($temp_id)";
					$sub_result = mysqli_query($connection, $sub_query);
					$sub_row = mysqli_fetch_assoc($sub_result);
					
					if ($car_1 != $row["car_id"])
						echo "<option value='" . $row["car_id"] . "'>" . $sub_row["getCar($temp_id)"] . "</option>";
					else
						echo "<option selected='selected' value='". $row["car_id"] . "'>" . $sub_row["getCar($temp_id)"] . "</option>";
				}
			}
			
			else 
				DIE('Error: <br/>' . mysqli_error($connection));
		}
		echo "</select></td>";

		echo "<td>Date Processed: <input type='text' name='date_processed' value='$date_processed_1'></input></td>";

		echo "<td>Start Date: <input type='text' name='rent_start_date' value='$rent_start_date_1'></input></td>";

		echo "</tr>";

		echo "<tr class = 'fillform'>";
		
		echo "<td>End Date: <input type='text' name='rent_end_date' value='$rent_end_date_1'></input></td>";

		echo "<td>Days: <input type='text' name='days' value='$days_1'></input></td>";

		echo "<td class='option'>Applied Rate: <select class='delta' name='rate_applied'>";

		{
			$query = "SELECT * FROM `CarRental`.`rate` ORDER BY `rate`.category";

			if ($result = mysqli_query($connection, $query))
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$temp_id = $row["rate_id"];
					$sub_query = "SELECT getRate($temp_id)";
					$sub_result = mysqli_query($connection, $sub_query);
					$sub_row = mysqli_fetch_assoc($sub_result);
					
					if ($rate_applied_1 != $sub_row["getRate($temp_id)"])
						echo "<option value='" . $row["rate_id"] . "'>" . $sub_row["getRate($temp_id)"] . "</option>";
					else
						echo "<option selected='selected' value='" . $row["rate_id"] . "'>" . $rate_applied_1 . "</option>";
				}
			}
			
			else 
				DIE('Error: <br/>' . mysqli_error($connection));
		}
		echo "</select></td>";

		echo "<td>Order Total: <input type='text' name='order_total' value='$order_total_1'></input></td>";

		echo "<td>Order Status: <input type='text' name='order_status' value='$order_status_1'></input></td>";

		echo "</tr>";

		echo "</table>";
}

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