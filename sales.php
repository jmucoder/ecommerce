<?php
	include 'includes/session.php';

	$payid = uniqid(); // Genera un UUID
	$date = date('Y-m-d');
	$conn = $pdo->open();
	$total = $_GET['total'];

	try{
		
		$stmt = $conn->prepare("INSERT INTO sales (user_id, pay_id, sales_date, total) VALUES (:user_id, :pay_id, :sales_date, :total)");
		$stmt->execute(['user_id'=>$user['id'], 'pay_id'=>$payid, 'sales_date'=>$date, 'total'=>$total ] );
		$salesid = $conn->lastInsertId();
		
		try{
			$stmt = $conn->prepare("SELECT * FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
			$stmt->execute(['user_id'=>$user['id']]);

			
			foreach($stmt as $row){
				$stmt = $conn->prepare("INSERT INTO details (sales_id, product_id, quantity) VALUES (:sales_id, :product_id, :quantity)");
				$stmt->execute(['sales_id'=>$salesid, 'product_id'=>$row['product_id'], 'quantity'=>$row['quantity']]);

				// Disminuir la cantidad de productos
				$stmt = $conn->prepare("UPDATE products SET cantidad = cantidad - :quantity WHERE id = :id");
				$stmt->execute(['quantity'=>$row['quantity'], 'id'=>$row['product_id']]);
			}

			$stmt = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id");
			$stmt->execute(['user_id'=>$user['id']]);

			$_SESSION['success'] = 'Transaccion exitosa, Gracias.';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

	}
	catch(PDOException $e){
		$_SESSION['error'] = $e->getMessage();
	}

	$pdo->close();
	
	header('location: profile.php');
	
?>

