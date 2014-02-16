<?php require_once'header.php';?>
<div id='content'>
	<div id='lstArticl'>
		{{#row}}
		<div class='box'>
			<img class='picPdt' src="<?= WEBROOT ?>imgArticls/{{id}}.gif" />
			<div class="description">
				<table>
					<tr>
						<td>{{name}}</td>
						<td class="price">{{price}}</td>
						<td class="addCart" id='{{id}}'><img src='<?= WEBROOT ?>css/images/cart.gif' /></td>
					</tr>
				</table>
			</div>
			<span>{{description}}</span>
		</div>
		{{/row}}
	</div>
	<div class="loading">Téléchargement ...</div>
</div>
<script type="text/javascript">
	<!--
		$(document).ready(function(){
			var loadArticls = function(){
				var template = $('#lstArticl').html();
				$('#lstArticl').html('');
            	$('.loading').removeClass('hidden');
				$.post('<?= WEBROOT ?>backEnd.php', {action:'loadArticls'}, function(data) {
	                var html = Mustache.to_html(template, {'row':data.lstArticls});
                    $('#quantity').text(data['inCart'].quantity);
					$('#total').text(data['inCart'].total);

                    $('#lstArticl').append(html).removeClass('hidden');
                    $('.loading').addClass('hidden');
	            }, 'json');
			};

			loadArticls();

			$('.addCart').live('click', function(){
				var id = $(this).attr('id');
				$.post('<?= WEBROOT ?>backEnd.php', {action:'addToCart', id:id}, function(data) {
					$('#quantity').text(data['inCart'].quantity);
					$('#total').html(data['inCart'].total);
				}, 'json');
			});

		});
	-->
</script>
<?php require_once 'footer.php'?>
	