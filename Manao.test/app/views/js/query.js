$( document ).ready(function() {
		
	$('#btn-reg').click(function(event){
		event.preventDefault();
    $.post(
        '/checkform', // адрес обработчика        
        {
            login: $('#login').val(), 
            password: $('#password').val(),
            confirm: $('#confirm').val(),
            email: $('#email').val(),
            user_name: $('#user_name').val()
        },
        
        function(msg) { // получен ответ сервера — это json! 
            if(msg.status)
            { //если нету ошибок
            	$('.error').addClass('none');
            	document.location.href='/thankyou';
            }
            else
            { //если есть ошибки
            	if(msg.errors.password_fail)
            	{	//если ошибка связана с несвпадением паролей
	            	$('#confirm').focus();	
            		$('.error').removeClass('none').text(msg.errors_message.password_error);
            	}
            	if(msg.errors.dublicate)
            	{	//если ошибка связана с повторяющимся логином или емейлом
            		msg.errors.dublicate.forEach(function(field)
            		{

	            	$('#'+field).focus();	
            		$('.error').removeClass('none').text(msg['errors_message']['dublicate_error'][field]);

            		})
            	}
	            if(msg.errors.empty_field)
	            {	//если ошибка связана с пустой строкой
	            	// msg.fields
	            	msg.errors.empty_field.forEach(function(field)
	            	{
	            	$('#'+field).focus();	
	            	$('.error').removeClass('none').text(msg.errors_message.field_error);

	            	})	
            	}
            }
        },
        'json' // тип ответа
    );
});


$('#btn-login').click(function(event){
		event.preventDefault();
        let checkbox_value=$('#check').is(":checked")?true:false;
    $.post(
        '/checklogin', // адрес обработчика        
        {
            login: $('#login').val(), 
            password: $('#password').val(),
            check: checkbox_value,
            //check: $('#check').val(),
        },
        
        function(msg) { // получен ответ сервера — это json! 
            if(msg.status){ //если нету ошибок
             	$('.error').addClass('none');
            document.location.href='/profile';
            }
            else{ //если есть ошибки
            if(msg.errors.notMatchPassword || msg.errors.noMatchUser)
            {	//если ошибка связана с несвпадением паролей	
            	$('.error').removeClass('none').text(msg.errors_message.login_error);
            }
	        if(msg.errors.empty_field)
	        {	//если ошибка связана с пустой строкой
	            msg.errors.empty_field.forEach(function(field)
	            {
	            	$('#'+field).focus();	
	            	$('.error').removeClass('none').text(msg.errors_message.field_error);
	            })
            }
            }
        },
        'json' // тип ответа
    );
});
//CheckPassword();
IsEmail();
	

});


function IsEmail()
{
	$("#email").keyup(function()
	{
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		var address = $('#email').val();
 		if(reg.test(address) == false) 
		{
    		$("#errmsg").removeClass('none').text("Введите коректный e-mail!");
    		document.getElementById("btn-reg").disabled = true; 
   		}
   		else
   		{
   			$("#errmsg").addClass('none');
   			document.getElementById("btn-reg").disabled = false; 
   		}
	})
}





