<?php

$myDate = $_POST['myDate'];
$sname = $_POST['sname'];
$fname = $_POST['fname'];
$mname = $_POST['mname'];
$email = $_POST['email'];
$phNum = $_POST['phNum'];
$myClass = $_POST['myClass'];
$dob = $_POST['dob'];
$myText = $_POST['myText'];

if (!empty($myDate) || !empty($sname) || !empty($fname) ||!empty($mname) || !empty($myEmail) ||!empty($phNum) ||!empty($myClass) || !empty($dob) ||!empty($myText)){
	$host = "localhost";
	$dbUsername = "root";
	$dbPassword ="";
	$dbName = "vcs";

	//create connection

	$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
	if(mysqli_connect_error()){
		die('Connect Error(' . mysqli_connect_error().')'. mysqli_connect_error());
	}else{
		$Select = "SELECT email From admission Where email = ? Limit 1";
		$INSERT = "INSERT Into admission (myDate, sname, fname, mname, email, phNum, myClass, dob, myText) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";

			$stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

			if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("sssssisss",$myDate, $sname, $fname, $mname, $email, $phNum, $myClass, $dob, $myText);

				if ($stmt->execute()) {
                    echo "Thanks for Registration. We will send you the mail regarding admission soon";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
	}

} else{
	echo "All field are required";
	die();
}
?>