<?php
	session_start();

	function executeQuery($query, $param = array()){
		$host = 'localhost';
		$user = 'root';
		$password = '';
		$database = 'panier';
		$db;
		
		try{
			$db = new PDO('mysql:host='.$host.';dbname='.$database, $user, 
						$password, 
						array(PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES UTF8',
						PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
		}catch(PDOException $e){
			die($e->getTraceAsString());
		}
		$statement = $db->prepare($query);
		$statement->execute($param);
		return $statement->fetchAll(PDO::FETCH_OBJ);
	}

	if(!isset($_SESSION['cart']))
    	$_SESSION['cart']= array();
    
    $action = '';
    if(array_key_exists('action', $_POST))
    	$action = $_POST['action'];

	if($action == 'loadArticls'){
		echo json_encode(array('lstArticls'=>executeQuery('SELECT * FROM products'), 'inCart'=>inCart()));
	}

	if($action == 'addToCart'){
		$idArticl = $_POST['id'];
		if(isset($_SESSION['cart'][$idArticl]))
            $_SESSION['cart'][$idArticl]++;
        else
            $_SESSION['cart'][$idArticl] = 1;
        echo json_encode(array('inCart'=>inCart()));
	}

	if($action == 'lstArticlsOrder'){
		echo json_encode(recoverLstArticlsOrdred());
	}

	if($action == 'removeAction'){
		unset($_SESSION['cart'][$_POST['id']]);
		echo json_encode(recoverLstArticlsOrdred());
	}

	if($action == 'orderNow'){
		if(count($_SESSION['cart'])>0){
			$lstIdInCart = array_keys($_SESSION['cart']);
			//It is assumed that the client is already an open session and we have his id 1
			foreach ($lstIdInCart as $idArt){
				executeQuery("INSERT INTO orders VALUES('', $idArt, 1, ".$_SESSION['cart'][$idArt].")");
				unset($_SESSION['cart'][$idArt]);
			}
		}
	}

	function inCart(){
		$quantity = 0;
		$total = 0;
		if(count($_SESSION['cart'])>0){
			$lstIdInCart = array_keys($_SESSION['cart']);
			if(!empty($lstIdInCart)){
				$ids = implode(', ', $lstIdInCart);
				$articls = executeQuery("SELECT id, price FROM products WHERE id IN ($ids)");
				foreach ($articls as $art){
					$quantity += $_SESSION['cart'][$art->id];
					$total += $_SESSION['cart'][$art->id] * $art->price;
				}
			}
		}
		return array('quantity'=>$quantity, 'total'=>$total);
	}

	function recoverLstArticlsOrdred(){
		$quantity = 0;
		$total = 0;
		$lstOrders = array();
		if(count($_SESSION['cart'])>0){
			$lstIdInCart = array_keys($_SESSION['cart']);
			if(!empty($lstIdInCart)){
				$ids = implode(', ', $lstIdInCart);
				$articls = executeQuery("SELECT id, name, price FROM products WHERE id IN ($ids)");
				foreach ($articls as $art){
					$lstOrders[] = array('id'=>$art->id, 'name'=>$art->name, 
										'price'=>$art->price, 'quantity'=>$_SESSION['cart'][$art->id],
										'amount'=>$_SESSION['cart'][$art->id] * $art->price);
					$quantity += $_SESSION['cart'][$art->id];
					$total += $_SESSION['cart'][$art->id] * $art->price;
				}

			}
		}

		return array('lstOrders'=>$lstOrders, 'quantity'=>$quantity, 'total'=>$total);
	}
	

?>