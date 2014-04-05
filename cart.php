<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Cart</title>


<?php


$link = mysql_connect('localhost', 'root', 'root');
if (!$link) {
   die('Impossible de se connecter : ' . mysql_error());
}

// Rendre la base de données "Products", la base courante
$db_selected = mysql_select_db('products', $link);
if (!$db_selected) {
   die ('Impossible de sélectionner la base de données : ' . mysql_error());
}

?>


</head>
<body>


<?php

	$product_id = $_GET[id];	 //Le product ID via URL 
	$action 	= $_GET[action]; //L'action via URL 

	//Si le producti_id n'existe pas, afficher message erreur
	if($product_id && !productExists($product_id)) {
		die("Error. Le produit n'existe pas");
	}

	switch($action) {	//Décide ce qu'on doit faire
	
		case "add":
			$_SESSION['cart'][$product_id]++; //Ajouter un produit depuis la variable $product_id  
		break;
		
		case "remove":
			$_SESSION['cart'][$product_id]--; //Suprime un produit depuis la variable $product_id
			if($_SESSION['cart'][$product_id] == 0) unset($_SESSION['cart'][$product_id]); 
			break;
		
		case "empty":
			unset($_SESSION['cart']); 
		break;
	
	}
	
?>


<?php	

	if($_SESSION['cart']) {	//si la panier est vide
		//Montrer le panier
		
		echo "<table border=\"1\" padding=\"3\" width=\"40%\">";	//Format HTML table du panier
		
			
			foreach($_SESSION['cart'] as $product_id => $quantity) {	
				
				
				$sql = sprintf("SELECT name, description, price FROM php_shop_products WHERE id = %d;",
								$product_id); 
					
				$result = mysql_query($sql);
					
				
				if(mysql_num_rows($result) > 0) {
				
					list($name, $description, $price) = mysql_fetch_row($result);
				
					$line_cost = $price * $quantity;		
					$total = $total + $line_cost;			//Ajout du total
				
					echo "<tr>";
						//Information produit
						echo "<td align=\"center\">$name</td>";
						echo "<td align=\"center\">$quantity <a href=\"$_SERVER[PHP_SELF]?action=remove&id=$product_id\">X</a></td>";
						echo "<td align=\"center\">$line_cost</td>";
					
					echo "</tr>";
					
				}
			
			}
			
			//Montre le total
			echo "<tr>";
				echo "<td colspan=\"2\" align=\"right\">Total</td>";
				echo "<td align=\"right\">$total</td>";
			echo "</tr>";
			
			
			echo "<tr>";
				echo "<td colspan=\"3\" align=\"right\"><a href=\"$_SERVER[PHP_SELF]?action=empty\" onclick=\"return confirm('Are you sure?');\">Empty Cart</a></td>";
			echo "</tr>";		
		echo "</table>";
		
		
	
	}else{
		echo "You have no items in your shopping cart.";
		
	}
	
	//fonction qui check si le product existe
	function productExists($product_id) {
			//Sprintf pour niquer les injections SQL :)
			$sql = sprintf("SELECT * FROM php_shop_products WHERE id = %d;",
							$product_id); 
				
			return mysql_num_rows(mysql_query($sql)) > 0;
	}
?>

<a href="products.php">Continue Shopping</a>


<?php




?>



</body>
</html>