<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>KARMA - Thank you!</title>
<link href="<?php echo $this->config->item('base_url'); ?>/css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
<div id="wrapper">
  <div class="header"><a href="#"><img src="<?php echo $this->config->item('base_url'); ?>/images/logo.png" alt=""></a></div>
  <div class="middle">
    <div class="regfoam" style="width: 350px;">
        <?php if(!empty($recordObj)){ ?>
        <h2>Thank You for Registration. </h2>
        <br/><br/>
        Your Registration details are: <br/>
        <BR><B> Member Code: <?php echo $recordObj->getUserCode(); ?></B> 
        <BR> First Name: <?php echo $recordObj->getFirstName(); ?>
        <BR> Last Name: <?php echo $recordObj->getLastName(); ?>
        <BR> Mobile Number: <?php echo $recordObj->getMobileNumber(); ?>
        <BR> Email: <?php echo $recordObj->getEmail(); ?>
        <BR> Other Contact Number: <?php echo $recordObj->getOtherContactNumber(); ?>
        <BR> Area: <?php echo $recordObj->getArea(); ?>
        <?php } else { ?>
        <h2>Thank you!</h2>
        <?php } ?>
    </div>
  </div>
</div>
</body>
</html>

