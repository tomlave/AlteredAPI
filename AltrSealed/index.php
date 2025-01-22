<?php
error_reporting(0);
ini_set("display_errors", 0);

session_start();
$id = session_id();
if($_POST['close'] == 'Faire un tirage') {
	unset($_SESSION["json"]);
}
// if(isset($_SESSION["json"])){
// echo 'isset';
// } else {
// echo 'not';
// }
?>

<!DOCTYPE html>
<html>

<head>
<?php
include 'serveur/head.php';
?>
</head>

<body>
<?php
include 'serveur/home.php'
?>
</body>

</html>