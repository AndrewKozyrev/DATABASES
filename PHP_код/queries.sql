// A query for adding new row in `cars` table
INSERT INTO `vehicle` (tag_number, model, make, car_year, category, mp3_layer, dvd_player, air_conditioner, navigation, available)
VALUES ('4443BCDE', 'GT-R', 'Factory 1', 2008, 'A', 1, 1, 1, 1, 1);

// A query to show number of available cars of each category (A, B, C, D)
SELECT r.category, daily, weekly, monthly, COUNT(c.car_id) AS total FROM `rate` AS r
INNER JOIN `vehicle` AS c ON c.category = r.category
WHERE c.available = TRUE
GROUP BY r.category, daily, weekly, monthly
ORDER BY category ASC;

// A query to display all available cars of given category
SELECT tag_number, concat(c.make, ' ', c.model) AS name, c.category, r.daily, r.weekly, r.monthly FROM `vehicle` AS c
INNER JOIN `rate` AS r ON c.category = r.category
WHERE c.category = 'A' AND c.available = TRUE
ORDER BY category ASC;

// A query to show all cars of given make
SELECT tag_number, concat(c.make, ' ', c.model) AS name, c.category, r.daily, r.weekly, r.monthly 
FROM `vehicle` AS c
INNER JOIN `rate` AS r ON c.category = r.category
WHERE c.make LIKE upper("%audi%")
ORDER BY c.category ASC;

/**
*A stored procedure to show all cars of make = @param1
*/

DELIMITER //
CREATE PROCEDURE showCarsByMake (param1 VARCHAR(40))
BEGIN
	SELECT tag_number, concat(c.make, ' ', c.model) AS name, c.category, r.daily, r.weekly, r.monthly 
    FROM `vehicle` AS c
	INNER JOIN `rate` AS r ON c.category = r.category
	WHERE c.make LIKE CONCAT('%' , param1 , '%')
	ORDER BY c.category ASC;
END //
DELIMITER ;

/**
*
*A stored procedure to insert data into `customer` table
*
*/

DELIMITER //
CREATE PROCEDURE `insertCustomer` (	IN c_first VARCHAR(255)
	,IN c_last VARCHAR(255)
	,IN c_phone VARCHAR(20)
	,IN c_address VARCHAR(255)
	,IN c_zip VARCHAR(6)
	,IN c_license VARCHAR(16)
	,IN c_country VARCHAR(255)
	,IN c_city VARCHAR(255) )
	
BEGIN    
        INSERT INTO `customer` (
	first_name
    , last_name
	, phone
	, address
	, zip_code
	, license_number
	, country
	, city )
    
		VALUES (
	c_first
    , c_last
    , c_phone
    , c_address
    , c_zip
    , c_license
    , c_country
    , c_city );
END //
DELIMITER ;

/**
*
*
*A query to call stored procedure insertCustomer()
*
*/

CALL insertCustomer ('FIRSTNAME', 'LASTNAME', '7(921)3843-15-15', 'New Address', 'XXXXXX', 'XXXXXXXXXXXXXXXX', 'COUNTRY', 'CITY');


/*
*
* Изменяет collation/charset
*
*/

DELIMITER //
CREATE PROCEDURE `charsetChange` ()
BEGIN
	ALTER TABLE carrental.vehicle convert to character set utf8mb4 collate utf8mb4_general_ci;
	ALTER TABLE carrental.customer convert to character set utf8mb4 collate utf8mb4_general_ci;
	ALTER TABLE carrental.employee convert to character set utf8mb4 collate utf8mb4_general_ci;
	ALTER TABLE carrental.order convert to character set utf8mb4 collate utf8mb4_general_ci;
	ALTER TABLE carrental.rate convert to character set utf8mb4 collate utf8mb4_general_ci;
END //


						// A stored procedure to insert data into `vehicle` table

DELIMITER //
CREATE PROCEDURE insertVehicle (
	IN car_tag CHAR(8)
	,IN car_model VARCHAR(255)
	,IN car_make VARCHAR(255)
	,IN car_y YEAR(4)
	,IN car_category CHAR(1)
	,IN car_mp3 BIT(1)
	,IN car_dvd BIT(1)
	,IN car_air BIT(1)
    ,IN car_nav BIT(1)
    ,IN car_avail BIT(1) )
	
    BEGIN
    
		INSERT INTO `vehicle` (
	tag_number
	, model
	, make
	, car_year
	, category
	, mp3_layer
	, dvd_player
    , air_conditioner
    , navigation
    , available)
    
		VALUES (
	car_tag
    , car_model
    , car_make
    , car_y
    , car_category
    , car_mp3
    , car_dvd
    , car_air
    , car_nav
    , car_avail);
                                 
    END//
DELIMITER ;
						//

					// A query to call stored procedure insertVehicle()
CALL insertVehicle ('12345678', 'MODEL', 'MAKE', 1234, 'X', 0, 0, 0, 0, 0);

					// A query to call stored procedure charsetChange();
CALL charsetChange();

					// A query to show current character set and collation/charset
SELECT CCSA.character_set_name FROM information_schema.`TABLES` T,
       information_schema.`COLLATION_CHARACTER_SET_APPLICABILITY` CCSA
WHERE CCSA.collation_name = T.table_collation
  AND T.table_schema = "CarRental"
  AND T.table_name = "rates";
					//
					

					// This function counts the number of vehicles of given category countCategory()
DELIMITER //
CREATE FUNCTION countCategory (value CHAR(1)) RETURNS INT
	DETERMINISTIC
BEGIN
SELECT COUNT(c.car_id) INTO @total FROM `rate` AS r
INNER JOIN `vehicle` AS c ON c.category = r.category
WHERE c.category = value;
RETURN (@total);
END //

					//
					
					
/**
* A stored procedure to insert data into `employee` table   insertEmployee()
*/

DELIMITER //
CREATE PROCEDURE insertEmployee (IN e_number INT, IN e_first VARCHAR(255),
								 IN e_last VARCHAR(255), IN e_salary DECIMAL )
BEGIN
		INSERT INTO `employee` (employee_number, first_name,
								 last_name, car_year, hourly_salary)
		VALUES (e_number, e_first, e_last, e_salary);
END
DELIMITER ;

					//
					
					// A query to call stored procedure insertEmployee()
CALL insertEmployee (999999, 'FIRSTNAME', 'LASTNAME', 100.0);


							/**
							* 	A stored procedure to update rates updateRate()
							*/
DELIMITER //
CREATE PROCEDURE updateRate(IN value1 DECIMAL, IN value2 DECIMAL, IN value3 DECIMAL, IN new_category CHAR(1) )
BEGIN
SET SQL_SAFE_UPDATES = 0;
UPDATE `rate` 
SET daily = value1, weekly = value2, monthly = value3
WHERE category = new_category; 
END //
DELIMITER ;

							//

					// A query to call stored procedure updateRate();
CALL updateRate(1, 2, 3, 'A');
							//
							
// A query to display all available vehicles

SELECT car_id, tag_number, model, make, category FROM `vehicle`
WHERE available = TRUE;

//


