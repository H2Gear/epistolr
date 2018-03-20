<?php
/*

// ___ CONNEXION P	DO A LA BDD ___ 
$host = '127.0.0.1';
$db   = 'bddepistolr';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);


?>
*/

// ___ CONNEXION P	DO A LA BDD ___ 



$host = '127.0.0.1';
$db   = 'epistolr';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$user = 'root';
$pass = '';
$opt = 	[
		//    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		//    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		//    PDO::ATTR_EMULATE_PREPARES   => false,
		];

return [
    'DB_HOST' => $dsn,
    'DB_USER' => $user,
    'DB_PASS' => $pass,
    'DB_OPT' => $opt,
];



/* ___ CREATION DU PDO ___

$config = (require 'config.php');
$conn = new PDO($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS'], [$config['DB_OPT']]);

*/

?>
