$(document).ready(function() {
	//Start code...


	
	// var validator = $( "#myform" ).validate();
	// validator.form();
	/*
	$.validator.addMethod("charcheck", function(value, element) {
	  return this.optional(element) || /^[a-zA-Zа-яА-Я ]$/.test(value);
	}, "Please specify the correct domain for your documents");
	*/
	// var validator = $( "#myform" ).validate();
	// validator.element( "#myselect" );


	//Подсветка выбранного языка btn-primary
	
	$('div.lang a').removeClass('active-trail');
	
	var currLang = sessionStorage['language'];
	if (currLang) {$('div.lang a#'+currLang).addClass('active-trail');}
	if (!currLang){$('div.lang a#ru').addClass('active-trail');}
	$('div.lang a').click(function (e) {
		var currLink = $(this);
		currId = currLink.attr('id');
		sessionStorage['language'] = currId;

	});
	

	//Установка значения remember
	//В зависимости от того что выбрал пользователь
	$('#remember').click(function () {
		var remember = $(this);
		if(remember.val() == "1") remember.val("0");
		else {remember.val("1");}
	})

	//Ajax Валидация формы авторизации
	$('#form-auth #auth').on('click', function(e){
			var mesContainer = $('#result');
			$.ajax({    
				   type: "POST", 
				   url: "/user/login",  
				   data: 	({
				   				"login" : $('#login').val(),
				   				"password" : $('#password').val(),
				   				"remember" : $('#remember').val(),				   				
				   			}),

				   dataType: "html",
				   success: function(obj){
				   	   	result = $(obj).find('#message');
				   	   	if(result.text() == "") {location.reload();}
				   	   	if(result.text() != "") {mesContainer.removeClass('hide').text('').append(result.html());	}
				    } 
				});
			e.preventDefault();
			//return false;
	});

	//Ajax Валидация поля login при Регистрации
	//Определение занят ли логин
	$( "#form_registr #login").blur(function(e) {
		$('div#login').text('');
		$.ajax({    
				   type: "POST", 
				   url: "/user/registr",  
				   data: 	({"login" : $('#login').val()}),

				   dataType: "html",
				   success: function(obj){

				   	   	var result = $(obj).find('#message');
				   	   	mesId = result.attr('class');

				   	   	if (mesId == "logintake") {$('div#login').append(result.text());} 
				    } 
				});
		});

	//jQuery валидация формы регистрации
	//========================================
	//"checkLogin" Дополнительный метод валидации поля "login"
	// "Login должно состоять только из букв латинского алфавита и нижнего подчеркивания"
	var regExpLogin = new RegExp("^[a-zA-Z0-9_]+$"); 
	$.validator.addMethod("checkLogin", function(value, element) {
		  return this.optional(element) || regExpLogin.test(value);
	}, "Ошибка ввода. Допустимые символы - (A-Z,a-z,0-9,'_')");

	//"checkName" Дополнительный метод валидации поля "name"
	// "Имя должно состоять только из букв и пробелов"
	var regExpName = new RegExp("^[A-zА-яЁё\\s]+$"); 
	$.validator.addMethod("checkName", function(value, element) {
		  return this.optional(element) || regExpName.test(value);
	}, "Имя должно состоять только из букв и пробелов");

	//"checkAvatar" Дополнительный метод валидации поля "avatar"
	// "Login должно состоять только из букв латинского алфавита и нижнего подчеркивания"
	var regExpAvatar = new RegExp("\.(jpg|jpeg|png|JPG|JPEG)"); 
	$.validator.addMethod("checkAvatar", function(value, element) {
		  return this.optional(element) || regExpAvatar.test(value);
	}, "Неверный формат. Допустимые форматы: *.jpg, *.jpeg, *.png");

	$( "#form_registr" ).validate({
		rules: {
			login: {
				required:true,
				minlength: 4,
				maxlength: 16,
				checkLogin:true,
			},
			name: {
				required:true,
				minlength: 3,
				maxlength: 50,
				checkName: true,
			},
			password: {
				required:true,
			},
			password2: {
				required:true,
				equalTo:"#password",
			},
			avatar: {				
				checkAvatar:true,			
			},
		},
		messages: {
			login: {
				required: "Поле обязательно для заполнения",
				minlength: "Поле должно быть не короче 4 символов",
				maxlength: "Поле должно быть не длиннее 16 символов",
			},
			name: {
				required: "Поле обязательно для заполнения",
				minlength: "Поле должно быть не короче 3 символов",
				maxlength: "Поле должно быть не длиннее 50 символов",
			},
			password: {
				required: "Поле обязательно для заполнения",
			},
			password2: {
				required: "Поле обязательно для заполнения",
				equalTo:"Пароли не совпадают",
			},
		}
	});











	//End code...
});