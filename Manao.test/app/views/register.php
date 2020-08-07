<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>registration</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="stylesheet" href="/app/views/css/style.css">
	<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
</head>
<body class="centerpage">
	<div class="container">
		<!-- <form action="/form" class="form-signin" method="POST"> -->
		<form class="base_setting" id="my_form">
			<h1 class="center">Регистрация</h1>
			
			<input type="text" class="form-control" id="login" name="login" placeholder="Логин" autocomplete="off">
			<input type="password" class="form-control" name="password" id="password" placeholder="Пароль" autocomplete="off">
		
			<input type="password" class="form-control" id="confirm" name="confirm"  placeholder="Повторите пароль" autocomplete="off"> 	
			<input type="email" class="form-control" id="email" name="email" placeholder="e-mail" autocomplete="off"> 
			<input type="text" class="form-control" name="user_name" id="user_name" placeholder="Имя" autocomplete="off" >
			<button  class="btn btn-lg btn-dark btn-block" id="btn-reg" type="button">Зарегистрировать</button>
			<p class="error none" id="errmsg"></p>
		</form>
	</div>

 	<script type="text/javascript" src="/app/views/js/query.js"></script>
</body>
</html> 