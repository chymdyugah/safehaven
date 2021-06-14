<?php
	session_start();
	include "conn.php";
	
	if(isset($_POST['pword'])){
		$id = $_SESSION['di'];
		$sql = "select * from users where id=$id";
		$result = $conn->query($sql);
		if ($result->num_rows != 0){
			$row = $result->fetch_assoc();
			if ($row['decrypt_key'] == md5($_POST['key'])){
				$pword = $_POST['pword'];
				$pword = convert_uudecode($pword);
				$pword = substr($pword,13);
				echo $pword;
			}else{
				echo "";
			}
		}
		
	}
?>