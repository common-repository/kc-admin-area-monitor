<?php
/*
	Plugin Name: KC Admin area Monitor
	Plugin URI: http://krumch.com/2016/07/02/kc-admin-area-monitor/
	Description: Monitors WEB connections to your admin area. The "security camera" in your Admin dashboard.
	Version: 2016.06.02
	Author: Krum Cheshmedjiev
	Author URI: http://krumch.com
	Tested up to: 5.0
	Requires at least: 3.0
	Requires: WordPress® 3.0+, PHP 5.2+
	Tags: security, security check, security camera, admin security, dashboard security, log, security log, admin connections log, security prevention, risk prevention, self protection, activity log, security tool, log tool, check tool
*/

global $KDB;

function kc_admin_monitor_activate() {}
register_activation_hook( __FILE__, 'kc_admin_monitor_activate' );
add_action('init', 'kc_admin_monitor_action', 0);

function kc_admin_monitor_deactivate() {}
register_deactivation_hook( __FILE__, 'kc_admin_monitor_deactivate' );

function kc_admin_monitor_admin() {
	echo '<form method="post" action="'.str_replace( '%7E', '~', $_SERVER['REQUEST_URI']).'"><div style="text-align:center"><h1>KC Admin area Monitor</h1></div>';
	if(isset($_POST['save']) && isset($_POST['admin_form']) and wp_verify_nonce($_POST['admin_form'], 'admin_form')) {
		kc_admin_monitor_alert('KCAM options saving');
		$options = array();
		$options['email'] = sanitize_email($_POST["option"]['email']);
		if(!is_email($options['email'])) $options['email'] = get_option('admin_email');
		$options['whitelist'] = filter_var($_POST["option"]['whitelist'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
#echo "save options -> !<pre>".print_r($options, true)."</pre>!";
		update_option('kc_admin_monitor_options', $options);
	} else {
		$options = get_option('kc_admin_monitor_options');
	}
#echo "options -> !<pre>".print_r($options, true)."</pre>!";
	wp_nonce_field('admin_form', 'admin_form');
?>
		<p><table border=0 width="100%">
			<tr><td width=50% align="right">Email to send alerts:</td><td>&nbsp;</td><td><input type="text" name="option[email]" value="<?php echo (!isset($options['email']))?get_option('admin_email'):$options['email']; ?>"></td></tr>
			<tr><td colspan="3">&nbsp;</td></tr>
			<tr><td width=50% align="right">White list:<br>(one by row, case sensitive)</td><td>&nbsp;</td><td><textarea rows="20" cols="60" name="option[whitelist]"><?php echo (isset($options['whitelist']))?$options['whitelist']:''; ?></textarea></td></tr>
			<tr><td colspan="3" align="center"><input type="submit" name="save" value="Save"></td></tr>
			<tr><td colspan="3">&nbsp;</td></tr>
<?php
#echo "<tr><td colspan='3'>custom_reg_fields -> !<pre>".print_r($kc_admin_monitor_custom_reg_prof_fields, true)."</pre>!</td></tr>";
?>
		</table>
		</p>
				</form>
<?php
}

function kc_admin_monitor_adminmenu() { add_options_page("kc_admin_monitor", "KC Admin Monitor", 'administrator', "kc_admin_monitor", "kc_admin_monitor_admin"); }
add_action('admin_menu', 'kc_admin_monitor_adminmenu');

function kc_admin_monitor_action() {
	if(strstr('wp-admin', $_SERVER['QUERY_STRING'].$_SERVER['REQUEST_URI'].$_SERVER['SCRIPT_FILENAME']) and isset($_REQUEST) and count(array_keys($_REQUEST)) > 0) {
		$message = KC_Msg();
		$options = get_option('kc_admin_monitor_options');
		$opts = explode("\n", $options['whitelist']);
		foreach($opts as $opt) {
			if(!empty($opt) and strstr($message, $opt)) return 1;
		}
		kc_admin_monitor_alert('Alert');
	}
	return 1;
}

function kc_admin_monitor_alert($msg) {
	$options = get_option('kc_admin_monitor_options');
	if(!isset($options['email'])) $options['email'] = get_option('admin_email');
	mail($options['email'], 'kc_admin_monitor::'.$msg, KC_Msg($msg), "From: ".get_option('admin_email'));
	return 1;
}

function KC_Msg($msg=false) {
	global $KDB;
	$e = new Exception;
	$message="_________CALL STACK __________\n".print_r($e->getTraceAsString(), true)."<br>\n";
	$message.="_________REQUEST__________\n";
	ksort($_REQUEST);
	foreach($_REQUEST as $keys => $values) { $message.="!$keys! -> !".print_r($values, true)."!<br>\n"; }
	$message.="\n_________SERVER__________\n";
	ksort($_SERVER);
	foreach($_SERVER as $keys => $values) { $message.="!$keys! -> !".print_r($values, true)."!<br>\n"; }
	if($KDB) $message.="\n_________ KDB __________\n$KDB";
	if($msg) $message.="\n_________MESSAGE__________\n!<pre>".print_r($msg, true)."</pre>!\n";
	return $message;
}

?>
