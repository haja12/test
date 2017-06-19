<?php

// DB connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "midinfi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Database Connection failed: " . $conn->connect_error);
}

// last updated date condition
$last_updated_gt_30_days = "WHERE (datediff(NOW(), last_updated_date) > 30)";

// choose one hospital among which has more than 80 doctors
$one_hospital_name_morethan_80 = "AND hospital_name IN (SELECT IF(COUNT(count)>1, 
(SELECT hospital_name  FROM doctor ORDER BY RAND() LIMIT 0,1),
(SELECT hospital_name  FROM doctor ORDER BY id ASC LIMIT 0,1)) AS hospital_name 
FROM (SELECT COUNT(id) AS count 
FROM doctor
GROUP BY hospital_name
HAVING count > 80) as A)";

// hospitals which has less than or equal to 80 doctors
$hospitals_name_lessthan_80 = "OR 
hospital_name IN (SELECT IF(count(id)<=80,hospital_name,'') AS Hospital FROM doctor GROUP BY hospital_name)";

// doctors listed together by hospital, location and doctor name
$same_hospital_doctor_listed_together = "ORDER BY hospital_name, location, doctor_name LIMIT 0, 150";

//echo "SELECT * FROM doctor $last_updated_gt_30_days $one_hospital_name_morethan_80 $hospitals_name_lessthan_80 $same_hospital_doctor_listed_together"; exit;
//$diseases = $conn->query("SELECT * FROM doctor $last_updated_gt_30_days $same_hospital_doctor_listed_together LIMIT 0, 5");
$diseases = $conn->query("SELECT * FROM doctor $last_updated_gt_30_days $one_hospital_name_morethan_80 $hospitals_name_lessthan_80 $same_hospital_doctor_listed_together");
//echo "No. of Rows: ".$diseases->num_rows;
if(isset($diseases->num_rows) && $diseases->num_rows > 0) {
	$data = [];
	while ($row = $diseases->fetch_assoc()) {
		$data[] = $row;
	}
	echo json_encode($data);
} else echo 0;
?>
