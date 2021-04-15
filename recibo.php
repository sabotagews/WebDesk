<?php
session_start( );
require_once( 'definitions.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/mysql.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'scripts/scripts.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/reservacion.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/cobro.cls.php' );

require_once('./includes/layout/header.php');
require_once('./includes/admin/menu-admin.php');

$r			= new Reservacion( );
$_R			= $r->reservaciones_get( $_POST['_data0'] );
$_R 		= $_R[ $_POST['_data0'] ];

$r			= new Cliente( );
$cliente	= $r->get_cliente( $_R[ 'clienteId' ] );
$cliente	= $cliente[ $_R[ 'clienteId' ] ];

$r			= new Cobro( );
$cobro		= $r->get_cobro( $_POST['_data1'] );

$r			= new Sucursal( );
$sucursal	= $r->get_sucursal( $_SESSION['currentUser']['sucursalId'] );
$sucursal	= $sucursal[ $_SESSION['currentUser']['sucursalId'] ];

// echo '<pre>';print_r( $_R );echo '</pre>';
// echo '<pre>';print_r( $cliente );echo '</pre>';
// echo '<pre>';print_r( $cobro );echo '</pre>';

// echo '<pre>';print_r( $sucursal );echo '</pre>';

// echo $_SESSION['PATH_HOME'] . 'cobros' . S . $cobro['cobroArchivo'];

?>
<script type="text/javascript">

</script>


<style>
	.receipt-content .logo a:hover {
  text-decoration: none;
  color: #7793C4;
}

.receipt-content .invoice-wrapper {
  background: #FFF;
  border: 1px solid #CDD3E2;
  box-shadow: 0px 0px 1px #CCC;
  padding: 40px 40px 60px;
  margin-top: 40px;
  border-radius: 4px;
}

.receipt-content .invoice-wrapper .payment-details span {
  color: #A9B0BB;
  display: block;
}
.receipt-content .invoice-wrapper .payment-details a {
  display: inline-block;
  margin-top: 5px;
}

.receipt-content .invoice-wrapper .line-items .print a {
  display: inline-block;
  border: 1px solid #9CB5D6;
  padding: 13px 13px;
  border-radius: 5px;
  color: #708DC0;
  font-size: 13px;
  -webkit-transition: all 0.2s linear;
  -moz-transition: all 0.2s linear;
  -ms-transition: all 0.2s linear;
  -o-transition: all 0.2s linear;
  transition: all 0.2s linear;
}

.receipt-content .invoice-wrapper .line-items .print a:hover {
  text-decoration: none;
  border-color: #333;
  color: #333;
}

.receipt-content {
  /* background: #ECEEF4; */
}
@media (min-width: 1200px) {
  .receipt-content .container {width: 900px; }
}

.receipt-content .logo {
  text-align: center;
  margin-top: 50px;
}

.receipt-content .logo a {
  font-family: Myriad Pro, Lato, Helvetica Neue, Arial;
  font-size: 36px;
  letter-spacing: .1px;
  color: #555;
  font-weight: 300;
  -webkit-transition: all 0.2s linear;
  -moz-transition: all 0.2s linear;
  -ms-transition: all 0.2s linear;
  -o-transition: all 0.2s linear;
  transition: all 0.2s linear;
}

.receipt-content .invoice-wrapper .intro {
  line-height: 25px;
  color: #444;
}

.receipt-content .invoice-wrapper .payment-info {
  margin-top: 25px;
  padding-top: 15px;
}

.receipt-content .invoice-wrapper .payment-info span {
  color: #A9B0BB;
}

.receipt-content .invoice-wrapper .payment-info strong {
  display: block;
  color: #444;
  margin-top: 3px;
}

@media (max-width: 767px) {
  .receipt-content .invoice-wrapper .payment-info .text-right {
  text-align: left;
  margin-top: 20px; }
}
.receipt-content .invoice-wrapper .payment-details {
  border-top: 2px solid #EBECEE;
  margin-top: 30px;
  padding-top: 20px;
  line-height: 22px;
}


@media (max-width: 767px) {
  .receipt-content .invoice-wrapper .payment-details .text-right {
  text-align: left;
  margin-top: 20px; }
}
.receipt-content .invoice-wrapper .line-items {
  margin-top: 40px;
}
.receipt-content .invoice-wrapper .line-items .headers {
  color: #A9B0BB;
  font-size: 13px;
  letter-spacing: .3px;
  border-bottom: 2px solid #EBECEE;
  padding-bottom: 4px;
}
.receipt-content .invoice-wrapper .line-items .items {
  margin-top: 8px;
  border-bottom: 2px solid #EBECEE;
  padding-bottom: 8px;
}
.receipt-content .invoice-wrapper .line-items .items .item {
  padding: 10px 0;
  color: #696969;
  font-size: 15px;
}
@media (max-width: 767px) {
  .receipt-content .invoice-wrapper .line-items .items .item {
  font-size: 13px; }
}
.receipt-content .invoice-wrapper .line-items .items .item .amount {
  letter-spacing: 0.1px;
  color: #84868A;
  font-size: 16px;
 }
@media (max-width: 767px) {
  .receipt-content .invoice-wrapper .line-items .items .item .amount {
  font-size: 13px; }
}

.receipt-content .invoice-wrapper .line-items .total {
  margin-top: 30px;
}

.receipt-content .invoice-wrapper .line-items .total .extra-notes {
  float: left;
  width: 40%;
  text-align: left;
  font-size: 13px;
  color: #7A7A7A;
  line-height: 20px;
}

@media (max-width: 767px) {
  .receipt-content .invoice-wrapper .line-items .total .extra-notes {
  width: 100%;
  margin-bottom: 30px;
  float: none; }
}

.receipt-content .invoice-wrapper .line-items .total .extra-notes strong {
  display: block;
  margin-bottom: 5px;
  color: #454545;
}

.receipt-content .invoice-wrapper .line-items .total .field {
  margin-bottom: 7px;
  font-size: 14px;
  color: #555;
}

.receipt-content .invoice-wrapper .line-items .total .field.grand-total {
  margin-top: 10px;
  font-size: 16px;
  font-weight: 500;
}

.receipt-content .invoice-wrapper .line-items .total .field.grand-total span {
  color: #20A720;
  font-size: 16px;
}

.receipt-content .invoice-wrapper .line-items .total .field span {
  display: inline-block;
  margin-left: 20px;
  min-width: 85px;
  color: #84868A;
  font-size: 15px;
}

.receipt-content .invoice-wrapper .line-items .print {
  margin-top: 50px;
  text-align: center;
}



.receipt-content .invoice-wrapper .line-items .print a i {
  margin-right: 3px;
  font-size: 14px;
}

.receipt-content .footer {
  margin-top: 40px;
  margin-bottom: 110px;
  text-align: center;
  font-size: 12px;
  color: #969CAD;
}
.row {
	margin: auto;
}
</style>
<main class="container" role="main">
    <div class="container pb-4">



<div class="receipt-content">
	<div class="logo"><img class="mb-4" src="./images/logo.png" alt="" width="100"></div>
    <div class="container bootstrap snippets bootdey">
		<div class="row">
			<div class="col-md-12">
				<div class="invoice-wrapper">
					<div class="intro">
						Hola <strong><?= $_R['clienteNombre']; ?></strong>,
						<br>
						Este es su recibo por el pago de <strong>$ <?= number_format( $cobro['cobroMonto'] , 2 ); ?></strong> de su Reservaci&oacute;n <?= antepon_ceros( $_R['reservacionId'], 3 ); ?>
					</div>

					<div class="payment-info">
						<div class="row">
							<div class="col-sm-6">
								<span>Reservación No.</span>
								<strong><?= antepon_ceros( $_R['reservacionId'], 3 ); ?></strong>
							</div>
							<div class="col-sm-6 text-right">
								<span>Fecha de Pago</span>
								<strong><?= $cobro['cobroFecha']; ?></strong>
							</div>
						</div>
					</div>

					<div class="payment-details">
						<div class="row">
							<div class="col-sm-6">
								<span>Cliente</span>
								<strong>
									<?= $_R['clienteNombre']; ?>
								</strong>
								<p>
									<?= $cliente['clienteDomicilio']; ?> <br>
									<?= $cliente['clienteMovil']; ?> <br>
									<?= $cliente['clienteEmail']; ?>
								</p>
							</div>
							<div class="col-sm-6 text-right">
								<span>Pagado a</span>
								<strong>
									TURISMO SALOMON
								</strong>
								<p>
									<?= $sucursal['sucursalNombre']; ?> <br>
									<?= $sucursal['sucursalDomicilio']; ?> <br>
									<?= $sucursal['sucursalTelefono']; ?> <br>
									<?= $sucursal['sucursalEmail']; ?>
								</p>
							</div>
						</div>
					</div>

					<div class="line-items">
						<div class="headers clearfix">
							<div class="row">
								<div class="col-xs-4">Description</div>
							</div>
						</div>
						<div class="items">
							<div class="row item">
								<p>
									<?= $_R['reservacionServicioVer']; ?><br />
									<?= $_R['reservacionHotel']; ?><br />
									<?= $_R['reservacionDestino']; ?><br />
									Del <?= $_R['reservacionCheckInVer']; ?> al <?= $_R['reservacionCheckOutVer']; ?><br />
									<?= $_R['reservacionHabitaciones']; ?> Habitación(es)
								</p>
							</div>
							<div class="item">
								<?= $_R['reservacionDetalle']; ?>
							</div>
						</div>
						<div class="total text-right">
							<p class="extra-notes">
								<strong>Notes Adicionales</strong>
								Este recibo solo será válido si no presenta alteraciones, para cualquier aclaración no dude en contactarnos.
							</p>
							<div class="field">
								Precio de la Reservación <span><?= number_format( $_R['reservacionPrecio'], 2 ); ?></span>
							</div>
							<div class="field">
								Usted ha pagado <span><?= number_format( $cobro['acumulado'], 2 ); ?></span>
							</div>
							<div class="field">
								Saldo <span><?= number_format( $cobro['saldoFinal'], 2 ); ?></span>
							</div>
							<div class="field grand-total">
								SU PAGO <span><?= number_format( $cobro['cobroMonto'], 2 ); ?></span>
							</div>
						</div>

						<!-- <div class="print">
							<a href="#">
								<i class="fa fa-print"></i>
								Imprimir
							</a>
						</div> -->
					</div>
				</div>

				<!-- <div class="footer">
					Turismo Salomón
				</div> -->
			</div>
		</div>
	</div>
</div>

	</div>
</main>


<?php
require_once('./includes/layout/footer.php');
?>
