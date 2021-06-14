<?php 
	session_start();
	if(!isset($_SESSION['di'])){
		Header('location:login.php');
		exit();
	}
	
	include "conn.php";
	if(isset($_POST['submit'])){
		$password = uniqid().$_POST['password'];
		$password = convert_uuencode($password);
		$url = $_POST['url'];
		$username = $_POST['username'];
		$user = $_SESSION['di'];
		$sql = "insert into platforms (username,url,password,user)values(?,?,?,?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('sssi',$username, $url, $password, $user);
		if ($stmt->execute()){
			echo "<script>location.assign('index.php')</script>";
		}else{
			echo $conn->error;
		}
		$stmt->close();
	}
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
		<title>Safe Haven</title>
	</head>
	<body class="container-fluid backimage">
		<div class='row'>
			<div class='col-xs-12 col-lg-offset-3 col-lg-6'>
				<div id="home">
					<img id="img" src="assets/images/key.jpg" width="50" height="50" class="img-responsive img-circle">
					<h2 class="h2" id="tit">&nbsp&nbsp<a href="/">SAFE HAVEN</a></h2>
					<div class="row">
						<div class="col-xs-12 form-group">
							<div class="table-responsive" id='passwords'>
								<table class="table table-hover">
									<?php
										include "conn.php";
										$key = $_SESSION['di'];
										$sql = "select P.* from platforms as P join users as U on U.id=P.user where P.user=$key";
										$result = $conn->query($sql);
										if ($result->num_rows > 0){
											while($rows = $result->fetch_assoc()){
									?>
									<tr>
										<td><?php echo $rows['url']; ?></td>
										<td><span><?php echo $rows['password']; ?></span></td>
										<td><button type="button" class="btn btn-link show" title="Decrypt Password"><span class="fa fa-eye"></span></button></td>
									<tr>
									<?php
										}
										}else{
											echo "<center><p>No password in safe</p></center>";
										}
									?>
								</table>
							</div>
						</div>
						<div class="col-xs-6">
							<button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal">Add</button>
						</div>
						<div class="col-xs-6 text-right">
							<a class="btn btn-link" href="logout.php">Logout</a>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add new platform</h4>
        </div>
        <div class="modal-body">
			<form role="form" method="post">
            <div class="form-group">
				<label>URL</label>
				<input type="text" name="url" class="form-control" required>
            </div>
            <div class="form-group">
				<label>Username/Email</label>
				<input type="text" name="username" class="form-control" required>
            </div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" name="password" class="form-control" required>
            </div>
            
              <button type="submit" name="submit" class="btn btn-success btn-block">Add New</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
	</body>
<script>
$('.show').click(function(){
	var decrypt = prompt('Please enter your decryption password', 'sAfEhAvEn');
	var tp = $(this).parent().prev().find('span');
	var t = tp.text();
	$.post('ajx.php', {'pword':t, 'key':decrypt}, function(data){
		if(data==""){
			alert("Wrong Key!");
		}else{
			tp.text(data);
			setTimeout(function(){location.replace('index.php')}, 5000);
		}
		
	})
})
</script>

</html>