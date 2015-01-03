<?php
	$node = $_POST["node"];
	$mode = strtolower($_POST["mode"]);

	//need NOPASSWD sudo rights for power_lxc.sh script
	shell_exec("sudo /usr/local/bin/power_lxc.sh ".$node." ".$mode."&>/dev/null &");
	header("Location: index.php");
?>
