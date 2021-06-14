<?php 
	session_start();
?>
<!Doctype html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<link href="index.css" rel="stylesheet" type="text/css">
		<link href="assets/extras/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="assets/extras/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link rel="icon" href="assets/images/key.jpg" type="image/x-icon">
		<script src="assets/extras/jquery.min.js"></script>
		<script src="assets/extras/bootstrap.min.js"></script>
		<script src="js/plugins.js"></script>
		<title>Register</title>
	</head>
	<body class="container-fluid backimage">
		<div class='row'>
			<div class='col-xs-12 col-lg-offset-3 col-lg-6'>
				<div id="home">
					<img id="img" src="assets/images/key.jpg" width="50" height="50" class="img-responsive img-circle">
					<h2 class="h2" id="tit">&nbsp&nbsp<a href="index.php">SAFE HAVEN</a></h2>
					<div class="row">
						<div class="col-xs-12 col-md-offset-3 col-md-6">
							<form method="post">
								<div class="col-xs-12 form-group">
									<label>Email</label>
									<input type="email" name="email" class="form-control" required>
								</div>
								<div class="col-xs-12 form-group">
									<label>Password</label>
									<input type="password" name="password" class="form-control" required>
								</div>
								<div class="col-xs-12 form-group">
									<label>Decryption Key</label>
									<input type="password" name="key" class="form-control" title="a unique password for decyrpt your passwords" required>
								</div>
								<div class="col-xs-12 form-group">
									<input type="submit" name="submit" class="btn btn-default" value="Register">
								</div>
								
							</form>
						</div><br><br>
						<div class="col-xs-12 col-ms-offset-1">
							<center><a href="login"><p>Login if you already have an account</p></a></center>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</body>
</html>
<?php
	include "conn.php";
	
	if(isset($_POST['submit'])){
		$password = md5($_POST['password']);
		$key = md5($_POST['key']);
		$email = $_POST['email'];
		$sql = "insert into users (email,password,decrypt_key)values(?,?,?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('sss',$email, $password, $key);
		if ($stmt->execute()){
			echo "<script>location.replace('login.php')</script>";
		}else{
			echo $conn->error;
		}
		$stmt->close();
	}
?>