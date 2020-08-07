<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="stylesheet" href="/app/views/css/style.css">
	<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
</head>
<body class="centerpage">
	<div class="container">
		<form class="base_setting" id="my_form">			
			<input type="text" class="form-control" id="login" name="login" placeholder="Логин" autocomplete="off">
			<input type="password" class="form-control" name="password" id="password" placeholder="Пароль" autocomplete="off">
			<div class="form-group">
			 <label class="form-check-label"><input type="checkbox" class='base_setting'  id="check"> запомнить меня<label>
			</div>
			<button  class="btn btn-lg btn-dark btn-block" id="btn-login" type="button">Войти</button>
			<p class="error none" id="errmsg"></p>
		</form>
	</div>

 	<script type="text/javascript" src="/app/views/js/query.js"></script>
</body>
</html> 