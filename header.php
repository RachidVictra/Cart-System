<?php 
	define('WEBROOT', dirname($_SERVER['SCRIPT_NAME']).'/'); 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Système du panier</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link media="all" rel="stylesheet" type="text/css" href="<?= WEBROOT ?>css/style.css" />
		<!--[if IE]>
    		<link rel='stylesheet' type='text/css' href='css/ie.css' />
		<![endif]-->
		<script type="text/javascript" src="<?= WEBROOT ?>js/jquery-1.7.1.min.js"></script>
	</head>
	<body>
		<div id='wrapper'>
			<div id='header'>
				<div class='logo'>
					<h1><a href="myCart">Penp</a> <span> Système du panier</span></h1>
				</div>
				<div class='panier'>
					<table>
						<tr>
							<td>
								<a href="myCart">
									Items<br>
									<span id='quantity'></span> In <img src='<?= WEBROOT ?>css/images/cart.gif' />
								</a>
							</td>
							<td>
								Total<br><span id='total'></span>
							</td>
						</tr>
					</table>
				</div>
				<div class='menu'></div>
			</div>