<?php
session_start( );

if( !isset( $_SESSION['currentUser'] ) ) header('location: ./ ');

require_once( 'definitions.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/mysql.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'scripts/scripts.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/reservacion.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/cobro.cls.php' );

require_once('./includes/layout/header.php');

$r			= new Reservacion( );
$_R			= $r->reservaciones_get( $_POST['_data0'] );
$_R 		= $_R[ $_POST['_data0'] ];

$r			= new Cliente( );
$cliente	= $r->get_cliente( $_R[ 'clienteId' ] );
$cliente	= $cliente[ $_R[ 'clienteId' ] ];

$r			= new Cobro( );
$cobro		= $r->get_cobro( $_POST['_data1'] );

?>
<script type="text/javascript">

</script>

<main class="container" role="main">
	<div class="row d-flex mt-5">
		<div class="col-sm">
			<img class="mb-5" src="./images/logo.png" alt="" width="150">
		</div>
		<div class="col-sm text-right">
			<strong>
				TURISMO SALOMON
			</strong>
			<p>
				SUCURSAL <?= $sucursal['sucursalNombre']; ?> <br>
				<?= $sucursal['sucursalDomicilio']; ?> <br>
				<?= $sucursal['sucursalTelefono']; ?> <br>
				<?= $sucursal['sucursalEmail']; ?>
			</p>
			<p>Elaboró <strong><?= $cobro['cobroUsuario']; ?></strong></p>
		</div>
	</div>
	<hr class="my-4">
	<div class="d-flex p-0">
		<div class="col-6 mr-auto px-0">
			<span class="text-muted">Localizador de la Reservación</span>
			<h4 class="mt-2"><?= antepon_ceros( $_R['reservacionId'], 3 ); ?></h4>
		</div>
		<div class="col-6 text-right px-0">
			<span class="text-muted">Fecha del Pago</span>
			<h4 class="mt-2"><?= toHTML( $cobro['cobroFecha'], 'datetime' ); ?></h4>
		</div>
	</div>

	<hr class="my-4">
	<div class="d-flex col-12 p-0">
		<div class="col-6 mr-auto px-0">
			<span class="text-muted">Descripción del Servicio</span>
			<h4 class="mt-2"><?= $_R['reservacionServicioVer']; ?></h4>
			<p>
				<?= $_R['reservacionHotel']; ?><br />
				<?= $_R['reservacionDestino']; ?><br />
				Del <?= $_R['reservacionCheckInVer']; ?> al <?= $_R['reservacionCheckOutVer']; ?><br />
				<?= $_R['reservacionHabitaciones']; ?> Habitación(es)
			</p>
		</div>
		<div class="col-6 mr-auto text-right px-0">
			<span class="text-muted">Datos del Cliente</span>
			<h4 class="mt-2"><?= $_R['clienteNombre']; ?></h4>
			<?= $cliente['clienteDomicilio']; ?> <br>
			<?= $cliente['clienteMovil']; ?> <br>
			<?= $cliente['clienteEmail']; ?>
		</div>
	</div>
	<hr class="my-2">
	<div class="d-flex p-0">
		<div class="mr-auto px-0">
			<?= $_R['reservacionDetalle']; ?>
		</div>
	</div>

	<table class="table mt-5 text-right px-0">
		<tbody>
			<tr>
				<td class="px-0"><small class="text-muted">Precio de la Reservación</small> <strong>$ <?= $_R['reservacionPrecio']; ?></strong></td>
			</tr>
			<tr>
				<td class="px-0"><small class="text-muted">Acumulado de Pagos</small> <strong>$ <?= number_format( $cobro['acumulado'], 2 ); ?></strong></td>
			</tr>
			<tr>
				<td class="px-0"><small class="text-muted">Saldo</small> <strong>$ <?= number_format( $cobro['saldoFinal'], 2 ); ?></strong></td>
			</tr>
			<tr>
				<td class="h4 px-0">SU PAGO <strong class="text-success">$ <?= $cobro['cobroMonto']; ?></strong></td>
			</tr>
		</tbody>
	</table>

	<div class="d-flex p-0">
		<div class="col-12 mr-auto px-0 text-center my-5">___________________________<br />
			Recibí: <strong><?= $_SESSION['currentUser']['usuarioNombre'] . ' ' . $_SESSION['currentUser']['usuarioApellido']; ?></strong>
		</div>
	</div>

	<hr class="my-5">
	<p class="mt-5">
		<strong>Notas Adicionales</strong>
		Este recibo solo será válido si no presenta alteraciones, para cualquier aclaración no dude en contactarnos.
	</p>
</main>


<?php
require_once('./includes/layout/footer.php');
?>
