<?php


$uname = $_POST['uname'];
$uaddress = $_POST['uaddress'];
$email = $_POST['email'];
$phNum = $_POST['phNum'];
$myText = $_POST['myText'];

if (!empty($uname) || !empty($uaddress) || !empty($email) ||!empty($phNum) || !empty($myText)){
	$host = "localhost";
	$dbUsername = "root";
	$dbPassword ="";
	$dbName = "vcs";

	//create connection

	$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
	if(mysqli_connect_error()){
		die('Connect Error(' . mysqli_connect_error().')'. mysqli_connect_error());
	}else{
		$Select = "SELECT email From contact Where email = ? Limit 1";
		$INSERT = "INSERT Into contact (uname, uaddress, email, phNum, myText) values(?, ?, ?, ?, ?)";

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
                $stmt->bind_param("sssis",$uname, $uaddress, $email, $phNum, $myText);

				if ($stmt->execute()) {
                    echo "Thanks for Contacting us, we will soon reply you through mail";
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