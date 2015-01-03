<?php
	//Config part
	//FIXME: There are some static parts in the end
	//Host Array, includes Hostname and GPIO-Port for relay
	$hosts = array(
			array(
				"hostname" => "lxc01", 
				"gpio_port" => 3
			),
			array(
                                "hostname" => "lxc02",
				"gpio_port" => 2
			)
		);

	$status_path = "/mnt/cluster";
	
	function is_online($host) {
		if(!shell_exec("ping -w1 -c1 ".$host." >/dev/null")) {
			return "<font color=#00aa00>online</font>";
		} else {
			return "<font color=#AA0000>offline</font>";
		}
	}

	function has_power($hostname) {
		global $hosts;
		$port = -1;

		foreach($hosts as $host) {
			if($host["hostname"] == $hostname) {
				$port = $host["gpio_port"];
				break;
			}
		}

		if($port == -1) {
			return "CHECK-FAILED";
		} 
		
		if(trim(shell_exec("cat /sys/class/gpio/gpio".$port."/value")) == "1" ) {
			return "<font color=#00aa00>ON</font>";
		} else {
			return "<font color=#AA0000>OFF</font>";
		}
	}

	function show_power_form($host) {
		return ("
			<form action=power.php method=post>
			<select name=mode>
        			<option>ON</option>
        			<option>OFF</option>
       				<option>RESET</option>
			</select>
			<input type=hidden value=".$host." name=node>
			<input type=submit value='Send'>
			</form>
		");
	}

	function show_uptime($host) {
		return trim(shell_exec("cat ".$status_path."/".$host.".uptime"));
	}
?>

<html><head>
<title>LXC Cluster RB</title>
</head>
<body>
<center>
<table border=0 cellspacing=10><tr>

<?php 
	foreach($hosts as $host) {
	echo ('<td>
		<table border=1><tr><th>Node</th><th>Power</th><th>Network</th><th>Temperature</th><th>Power control</th></tr>
			<tr><td><a href=?console='.$host["hostname"].'>'.$host["hostname"].'</a></td><td>'.has_power($host["hostname"]).'</td><td>'.is_online($host["hostname"]).'</td>
			<td>'.shell_exec("cat ".$status_path."/".$host["hostname"].".temp").'C</td><td>'.show_power_form($host["hostname"]).'</td></tr>
		</table>
	<td>'.show_uptime($host["hostname"]).'</td></td></tr>');
}
?>
</tr></table>

<?php 
	//FIXME: Static Hostnames & URL
	if(isset($_GET["console"]) && ( $_GET["console"] == "lxc01" || $_GET["console"] == "lxc02" )) {
		echo '<iframe width="90%" height="80%" src="http://192.168.1.115/'.$_GET["console"].'"></iframe>';
	} else {
		echo "</center>";

		//This is a "ClusterMon" generated HTML-File:
		include 'status.html';
			
	}

?>
</body>
</html>
