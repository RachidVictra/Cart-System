<?php require_once'header.php';?>
<div id='content'>
	<div id="lstArticl">
		
	</div>
	<div class="loading">Téléchargement ...</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var loadTabOrders = function(data){
			$('#lstArticl').html('');
			var template = "<table id='lstOrders'>\
								<tr class='tb_h'>\
									<th>Articl</th>\
									<th>Unit price</th>\
									<th>Quantity</th>\
									<th>Amount</th>\
									<th>Remove</th>\
								</tr>\
								{{#row}}\
								<tr id='{{id}}'>\
									<td>{{name}}</td>\
									<td>{{price}}</td>\
									<td>{{quantity}}</td>\
									<td>{{amount}}</td>\
									<td class='removeAction'><img src='<?= WEBROOT ?>css/images/trach.png' /></td>\
								</tr>\
								{{/row}}\
								<tr>\
									<td colspan='2' ></td>\
									<td class='sumQty'><b>{{quantity}}</b></td>\
									<td class='sumTtl'><b>{{total}} €</b></td>\
									<td class='orderNow'><img src='<?= WEBROOT ?>css/images/order_now.gif' /></td>\
								</tr>\
							</table>";
            $('.loading').removeClass('hidden');
			var html = Mustache.to_html(template, {'row':data.lstOrders,
													'quantity':data.quantity,
	                								'total':data.total});
            $('#quantity').text(data.quantity);
			$('#total').text(data.total+' €');


            $('#lstArticl').append(html).removeClass('hidden');
            $('.loading').addClass('hidden');
		};

		var loadOrders = function(){
			$.post('<?= WEBROOT ?>backEnd.php', {action:'lstArticlsOrder'}, function(data){
				loadTabOrders(data);
			}, 'json');
		}

		loadOrders();

		$('.removeAction').live('click', function(){
			var idArt = $(this).parent('tr').attr('id');
			if(confirm('Would you like remove this Articl(s) to the Cart  ?')){
				$.post('<?= WEBROOT ?>backEnd.php', {action:'removeAction', id:idArt}, function(data){
					loadTabOrders(data);
				}, 'json');
			}
		});

		$('.orderNow').live('click', function(){
			if(confirm('You really want to order these items  ?')){
				$.post('<?= WEBROOT ?>backEnd.php', {action:'orderNow'}, function(){
					window.location.replace("<?= WEBROOT ?>listeArticls");
				});
			}
		});

	});
</script>
<?php require_once 'footer.php'?>