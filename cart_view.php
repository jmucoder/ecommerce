<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        	<div class="col-sm-9">
	        		<h1 class="page-header">Tu carrito</h1>
	        		<div class="box box-solid">
	        			<div class="box-body">
		        		<table class="table table-bordered">
		        			<thead>
		        				<th></th>
		        				<th>Foto</th>
		        				<th>Nombre</th>
		        				<th>Precio</th>
		        				<th width="20%">Cantidad</th>
		        				<th>Subtotal</th>
		        			</thead>
		        			<tbody id="tbody">
		        			</tbody>
		        		</table>
						<div class="form-group">
							<br>
							<label for="discount_code">Código de descuento</label>
							<input type="text" class="form-control" id="discount_code" placeholder="Introduce tu código de descuento">
							<br>
							<button id="validate_code" class="btn btn-success">Validar código</button>
						</div>
						<p>Precio Final</p>
						<b>
							<p id="total"></p>
						</b>
	        			</div>
	        		</div>

					<a href="#" class="btn btn-primary" id="buyButton" style="display: none;" onclick="buy()">Comprar</a>

	        	
	        	</div>
	        	<div class="col-sm-3">
	        		<?php include 'includes/sidebar.php'; ?>
	        	</div>
	        </div>
	      </section>
	     
	    </div>
	  </div>
  	<?php $pdo->close(); ?>
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>



<script>
var total = 0;
$(function(){
	$(document).on('click', '.cart_delete', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		$.ajax({
			type: 'POST',
			url: 'cart_delete.php',
			data: {id:id},
			dataType: 'json',
			success: function(response){
				if(!response.error){
					getDetails();
					getCart();
					getTotal();
				}
			}
		});
	});

	$(document).on('click', '#validate_code', function() {
        var discount_code = $('#discount_code').val();
        $.ajax({
            url: 'verify_discount_code.php',
            type: 'POST',
            data: {discount_code: discount_code},
            success: function(response) {
                if (response == 'valid') {
                    // Aplica el descuento del 10% al total
                    total = total * 0.9;
					total = total.toFixed(2);
                    // Actualiza el total en la página
					
                    $('#total').text('$' + total);
                } else {
                    // Muestra un mensaje de error si el código de descuento no es válido
                    alert('Código de descuento no válido');
                }
            }
        });
    });

	$(document).on('click', '.minus', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var qty = $('#qty_'+id).val();
		if(qty>1){
			qty--;
		}
		$('#qty_'+id).val(qty);
		$.ajax({
			type: 'POST',
			url: 'cart_update.php',
			data: {
				id: id,
				qty: qty,
			},
			dataType: 'json',
			success: function(response){
				if(!response.error){
					getDetails();
					getCart();
					getTotal();
				}
			}
		});
	});

	$(document).on('click', '.add', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var qty = $('#qty_'+id).val();
		qty++;
		$('#qty_'+id).val(qty);
		$.ajax({
			type: 'POST',
			url: 'cart_update.php',
			data: {
				id: id,
				qty: qty,
			},
			dataType: 'json',
			success: function(response){
				if(!response.error){
					getDetails();
					getCart();
					getTotal();
				}
			}
		});
	});

	getDetails();
	getTotal();

});

function getDetails(){
	$.ajax({
		type: 'POST',
		url: 'cart_details.php',
		dataType: 'json',
		success: function(response){
			$('#tbody').html(response);
			getCart();
			if(response.length > 112){
				console.log(response.length)
				$('#buyButton').show();
			} else {
				$('#buyButton').hide();
			}
		}
	});
}

function getTotal(){
	$.ajax({
		type: 'POST',
		url: 'cart_total.php',
		dataType: 'json',
		success:function(response){
			total = response;
			// Actualiza el total en la página
			$('#total').text(total);
		}
	});
}

function buy() {
    window.location.href = 'sales.php?total=' + total;
}
</script>

</body>
</html>
