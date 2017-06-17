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

//echo "connection"; exit;
/*$name = array("Robin", "Flix", "Nithya", "Beula", "Rajkumar", "Chathrabathy", "Durga Reddy", "Kavin", "Vasanth", "Sam", "Santhosh", "Lakshmi", "Sakthi", "Venkat", "Anil", "Athithya", "Senthil",
"Ramya", "Abirami", "Sunil", "Sundar", "Naveen", "Parthi", "Bhuvanesh", "Geethu", "Manju", "Srini", "Sredha", "Lokesh", "Malaichamy", "Mathi", "Jabeer", "Nithyanandhan", "Prabha", "Srijith",
"Dharsan", "Sathish", "Arul", "Suresh", "Prasanna");
$qualification = ['MS', 'MSurg', 'MD', 'MCh', 'ChM', 'CM', 'MCM', 'DM', 'DS'];
$hospital = "Narayana";
$location = "Delhi";
$updated_date = ['2017-01-05 13:22:19', '2017-02-15 10:12:39', '2017-03-19 11:14:29', '2017-04-21 15:20:11', '2017-05-15 17:47:22', '2017-05-10 13:22:19', '2017-04-25 13:22:19',
'2017-03-28 13:22:19', '2017-02-15 13:22:19', '2017-01-25 13:22:19'];

//echo $updated_date[array_rand($updated_date)]; exit;

for($i=0; $i<10; $i++) {
	//echo "INSERT INTO `doctor` (`id`, `doctor_name`, `hospital_name`, `qualification`, `location`, `last_updated_date`) VALUES (NULL, '" . $name[array_rand($name)] . "', '".$hospital."', '" . $qualification[array_rand($qualification)] . "', '".$location."',  '" . $updated_date[array_rand($updated_date)] . "')"; exit;
	$conn->query("INSERT INTO `doctor` (`id`, `doctor_name`, `hospital_name`, `qualification`, `location`, `last_updated_date`) VALUES (NULL, '" . $name[array_rand($name)] . "', '".$hospital."', '" . $qualification[array_rand($qualification)] . "', '".$location."',  '" . $updated_date[array_rand($updated_date)] . "')");
}*/

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