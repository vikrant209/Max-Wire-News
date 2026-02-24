<?php include_once("header.php");?>
  <div class="body-container">
    <div class="main">
             
      <div class="loginpageBG">
        <div id="box_bg">

<div id="content">
	<h1>Sign UP</h1>
	
	<!-- Login Fields -->
	<div id="login">
	<input type="text" onBlur="if(this.value=='')this.value='Name';" onFocus="if(this.value=='Name')this.value='';" value="Name" class="login user"> 
	
	<input type="email" onBlur="if(this.value=='')this.value='Email ID';" onFocus="if(this.value=='Email ID')this.value='';" value="Email ID" class="login email"> 
	
	<input type="button" value="Check Availability" class="availabilty" /> <span><!-- to display text of Availabilty --></span>
	
	<input type="tel" onBlur="if(this.value=='')this.value='Phone Number';" onFocus="if(this.value=='Phone Number')this.value='';" value="Phone Number" class="login phone"> 
	</div>
	
	<!-- Green Button -->
	<div class="signuparea">
	<div class="cl"></div>
	<div class="roboArea">
		<div class="leftPnl"><span><input type="checkbox" class="chkbox"></span><span class="notrobo">I'm not a robot</span></div>
		<div class="rightPnl"><span><a href="#"><img src="images/captcha.png" /></a><br/>reCaptcha<br/><font class="fnt12">Privacy - Terms</font></span></div>
	</div>
	<div class="cl"></div>
	<div class="mt15">
		<input type="checkbox" class="chkbox2" /> <span class="valignTxt">I have read, understood and accept the <a href="#" class="tnc">Terms and Conditions</a> of use on abnewswire.com in its entirety.</span>
	</div>
	<div class="cl"></div>
	<div class="margbot10">
		<span class="button orange">
		<a href="#">Signup</a>
		
	</span>
	</div>
	</div>

	<!-- Checkbox -->
	

</div>
</div>
        <div class="cl"></div>
      </div>
    </div>
  </div>
  
<?php include_once("footer.php");?>