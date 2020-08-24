$(document).ready(function(){
 
 $(".registration").click(function(){
 	$(".reg_form").toggle();
 });

 $(".reg_button").click(function(){
 	var login=$('[name = "reg_login"]').val();
 	var password=$('[name = "reg_password"]').val();
  console.log(login);
  console.log(password);
    $(".system_tablo_mess").html("");
 	/*  // тут нужна проверка на длинный/короткий логин/пароль
if (login.length<1) {
	return;
}
 if (password.length<5){
 	return;
 }
 */
    $.ajax({
        type:'post',
        url:'ajax/ajaxrequest.php',
        data:{'label':'register_new_user',
              'login': login,
              'password': password
              
      },                    
           success: function(data){
           	console.log("data="+ data);
            if (data == "login_have") {
              $(".system_tablo_mess").html("Пользователь с таким логином уже существует в базе данных");
            }

            if (data == "saved") {
              $(".reg_saved").show();
              $(".reg_form").hide();
              $(".registration").hide();
            }
           }
       });

 });
 $(".login_pass").click(function(){
  
  $(".avtoriz_form").toggle();

    $(".enter_log_pass").click(function(){
      
      var login= $("[name = 'avtoriz_login']").val();
      var password= $("[name = 'avtoriz_password']").val();
       console.log (login +"  " +password);
       $.ajax({
        type:'post',
        url:'ajax/ajaxrequest.php',
        data:{'label':'enter_log_pass',
              'login': login,
              'password': password
              
      },                    
           success: function(data){
            console.log("hash="+data);
            localStorage.setItem('user_hash', data);

           var a= localStorage.getItem('user_hash');
            console.log("считано из user_hash="+a);
            
           }
           });
    });//end .enter_log_pass
 });


});