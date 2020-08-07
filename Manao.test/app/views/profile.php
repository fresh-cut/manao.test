<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Profile</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="stylesheet" href="/app/views/css/style.css">
	
</head>
<body class="centerpage">
	<div class="container centerpage">
		<h1>Hello, <?=$_SESSION['user_name'];?>!</h1>
		<div>
		<a href="/logout"><button  class="btn btn-lg btn-dark btn-lg">Выйти</button></a>
	</div>
	</div>
</body>
</html> 