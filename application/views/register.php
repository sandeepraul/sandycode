<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>KARMA</title>
<link href="<?php echo $this->config->item('base_url'); ?>/css/style.css" type="text/css" rel="stylesheet">

<!-- for form validations on client side with jquery.validate plugin !-->
<script src="<?php echo $this->config->item('base_url'); ?>/js/jquery-1.7.2.min.js" type="text/javascript" ></script>
<script src="<?php echo $this->config->item('base_url'); ?>/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url'); ?>/js/form.validate.js" type="text/javascript"></script>

</head>
<body>
<div id="wrapper">
  <div class="header"><a href="#"><img src="<?php echo $this->config->item('base_url'); ?>/images/logo.png" alt=""></a></div>
  <div class="middle">
	<form id="register" name="regForm" action="<?php echo $this->config->item("base_url")."/register/save" ?>" method="post" >
      <!--<form id="register" name="regForm" action="" method="post" >-->
		<div class="regfoam">
		  <h2>Registration Form</h2>
		  <p>
			<input type="text" name="firstName" class="reginput" placeholder="First Name">
		  </p>
		  <p>
			<input type="text" name="lastName"  class="reginput" placeholder="Last Name">
		  </p>
		  <p>
			<input type="text" name="mobileNumber"  class="reginput" placeholder="Mobile No.">
		  </p>
		  <p>
			<input type="text" name="email"  class="reginput" placeholder="Email">
		  </p>
		  <p>
			<input type="text" name="otherContactNumber"  class="reginput" placeholder="Other Contact No.">
		  </p>
		  <p>
			<input type="text" name="area"  class="reginput" placeholder="Area">
		  </p>
		  <p class="txtcen">
			<input type="submit" id="submit" class="subbtn" value="Submit">
		  </p>
		</div>
	</form>
  </div>
</div>
</body>
</html>

