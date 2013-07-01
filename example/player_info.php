<?php
	include "../src/xfire.php";
	
	$user = new XUsers("revolution96");
	
	if (!$user->NoErrors())
	{
		echo "Si &eacute; verificato un errore!";
		die();
	}
?>
<!doctype html>
<html>
	<head>
    	<title>Player Info</title>
    </head>
    
    <body>
    	Info per <?php echo $user->GetUserInfo("nickname"); ?>. <br />
        Friends: <?php echo $user->GetUserInfo("friends"); ?><br />
        Gender: <?php echo $user->GetUserInfo("gender"); ?><br />
        Gaming Style:<?php echo $user->GetUserInfo("gstyle"); ?> <br />
        Country: <?php echo $user->GetUserInfo("country"); ?><br />
        Location: <?php echo $user->GetUserInfo("location"); ?><br />
        Join date: <?php echo $user->GetUserInfo("joindate"); ?><br />
        Status: <?php echo $user->GetUserInfo("status"); ?><br />
        Web site: <?php echo $user->GetUserInfo("website"); ?><br />
        Real name: <?php echo $user->GetUserInfo("realname"); ?><br />
        Occupation: <?php echo $user->GetUserInfo("occupation"); ?><br />
        Bio: <?php echo $user->GetUserInfo("bio"); ?><br />
        Interessi: <?php echo $user->GetUserInfo("interessi"); ?><br />
    </body>
</html>