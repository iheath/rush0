<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Products</title>

<?php
	$link = mysql_connect('localhost', 'root', 'root');
if (!$link) {
   die('Impossible de se connecter : ' . mysql_error());
}

// Rendre la base de données foo, la base courante
$db_selected = mysql_select_db('products', $link);
if (!$db_selected) {
   die ('Impossible de sélectionner la base de données : ' . mysql_error());
}
?>

</head>

<body>


<table border="1">

	<?php
		
		$sql = "SELECT id, name, description, price FROM php_shop_products;";
		
		$result = mysql_query($sql);
		
		while(list($id, $name, $description, $price) = mysql_fetch_row($result)) {
		
			echo "<tr>";
			
				echo "<td>$name</td>";
				echo "<td>$description</td>";
				echo "<td>$price</td>";
				echo "<td><a href=\"cart.php?action=add&id=$id\">Add To Cart</a></td>";
			
			echo "</tr>";
		}
		
	?>
</table>


<a href="cart.php">View Cart</a>

</body>
</html>