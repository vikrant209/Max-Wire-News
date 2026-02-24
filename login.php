<?php include_once("header.php");?>
  <div class="body-container">
    <div class="main">
             
      <div class="loginpageBG">
        <div id="box_bg">

<div id="content">
	<h1>Sign In </h1><p class="login-box-msg error" style="color: red;"></p>
	
	<!-- Social Buttons -->
	<div class="social">
	Sign in using social network:<br>
	<div class="twitter"><a href="#" class="btn_1">Login with Twitter</a></div>
	<div class="fb"><a href="#" class="btn_2">Login with Facebook</a></div>
	</div>
	
	<!-- Login Fields -->
	<form>
    
	<div id="login">Sign in using your registered account: <br>
		<input type="text" name="username" id="username" onBlur="if(this.value=='')this.value='Username';" onFocus="if(this.value=='Username')this.value='';" value="Username" class="login user">
		
		<input type="password" name="pass" id="pass" onBlur="if(this.value=='')this.value='Password';" onFocus="if(this.value=='Password')this.value='';" value="Password" class="login password">
	</div>
	
	<!-- Green Button -->
	<div class="signuparea">
	<button type="button" class="submitbtn sigh_in">Sign In</button>
	<ul>
		<li><a href="#">Forgot your Password?</li>
		<li>Don't have an account <a href="register.php" class="register">Register here.</a></li>
	</ul>
	</div>
</form>
	<!-- Checkbox -->
	

</div>
</div>
        <div class="cl"></div>
      </div>
    </div>
  </div>
  
    <?php include_once("footer.php");?>
     <!-- jQuery 2.1.4 -->
        <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="bootstrap/js/common.js"></script>
        <!-- iCheck -->
        <script src="plugins/iCheck/icheck.min.js"></script>
 <script>
            $(document).ready(function () {
               
                $('.sigh_in').on('click', function () { 
                    var datastring = {"email": $("#username").val(), "pass": $("#pass").val()};
                    $.ajax({
                        type: "POST",
                        url: "load.php?q=Login/index",
                        data: datastring,
                        success: function (data) {
                            if (data == 'login') {
                               
                                window.location = 'myaccount.php';
                            } else {
                                $('.error').html('Invalid Login.');
                            }
                        }
                    });
                    return false;
                });
                
                
                
            });
			
			</script>