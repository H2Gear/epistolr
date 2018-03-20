<?php



// extract($config);



function requete($stmt, $exe)
{
	
						$config = (require 'config.php');
						extract($config);
						$conn = new PDO($DB_HOST, $DB_USER, $DB_PASS, [$DB_OPT]);
						$query = $conn->prepare($stmt);
						$query->execute($exe);
						$extraction = $query->fetchAll();
						return $extraction;
}



/* ___ sql ___

*/



?>
