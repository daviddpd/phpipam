<?php
/**
 * Script to check edited / deleted / new IP addresses
 * If all is ok write to database
 *************************************************/

# include required scripts
require_once( dirname(__FILE__) . '/../../functions/functions.php' );
require_once ( dirname(__FILE__) . '/../../functions/classes/class.dpdMeta.php' );

# initialize required objects
$Database 	= new Database_PDO;
$Result		= new Result;
$User		= new User ($Database);
$Subnets	= new Subnets ($Database);
$Tools	    = new Tools ($Database);
$Addresses	= new Addresses ($Database);
$Log 		= new Logging ($Database, $User->settings);
$Zones 		= new FirewallZones($Database);
$Ping		= new Scan ($Database);

# verify that user is logged in
$User->check_user_session();
# check maintaneance mode
$User->check_maintaneance_mode ();

// # validate csrf cookie
// if($_POST['action']=="add") {
// 	$User->Crypto->csrf_cookie ("validate", "address_add", $_POST['csrf_cookie']) === false ? $Result->show("danger", _("Invalid CSRF cookie"), true) : "";
// }
// else {
// 	$User->Crypto->csrf_cookie ("validate", "address_".$_POST['id'], $_POST['csrf_cookie']) === false ? $Result->show("danger", _("Invalid CSRF cookie"), true) : "";
// }
// 
// # validate action
// $Tools->validate_action ($_POST['action']);
// $action = $_POST['action'];
// //reset delete action form visual visual
// if(isset($_POST['action-visual'])) {
// 	if(@$_POST['action-visual'] == "delete") { $action = "delete"; }
// }
// 

$meta = new dpdMeta($Database);
$set = 0;
if (isset($_GET['ref']))   { $ref = $_GET['ref']; $set++; }
if (isset($_GET['refid'])) { $refid = $_GET['refid']; $set++; }
if ( $set == 2 ) {
	$meta->setRef($ref, $refid);
}

if  (isset($_POST['action']) && $_POST['action'] == "delete" )  
{
	$meta->delete( $_POST['pk'] );
} else if  (isset($_POST['action']) && $_POST['action'] == "add" )  
{
	$meta->insert();
} else if ( isset($_POST['pk']) ) 
{
	$meta->inlineUpdate( $_POST['pk'], $_POST['name'], $_POST['value'] );
} 

if ( !isset($_GET['q']) ) {
	$meta->fetch_mutliple($ref, $refid);
	$meta->refreshView("table");
}


?>