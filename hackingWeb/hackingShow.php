<?php
require_once('hackingDb.php');
require_once("mysql_connect_data.inc.php");

$db = new Database($host, $userName, $password, $database);
$db->openConnection();
if (!$db->isConnected()) {
	header("Location: cannotConnect.html");
	exit();
}
$db->openConnection();
$username = $_REQUEST['username'];
$items = $db->userExists($username);
$db->closeConnection();
?>

<html>
<head><title>Booking 1</title><head>
<body><h1>Store</h1>
Current user: <?php print $userId ?>
<p>
	Items:
<p>
	<ul name="item">
		<?php
		$first = true;
		foreach ($items as $item) {
			if ($first) {
				print "<li>";
				$first = false;
			} else {
				print "</li>";
			}
			print "User: {$item[0]}";
		}
		?>
	</ul>
</body>
</html>
