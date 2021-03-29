<?php
session_start( );
require_once( 'definitions.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/mysql.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'scripts/scripts.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/reservacion.cls.php' );
require_once( $_SESSION['PATH_INCLUDES_REAL'] . 'classes/cobro.cls.php' );

$r		= new Reservacion( );
$_R	= $r->reservaciones_get( $_POST['_data0'] );

$r		= new Cobro( );
$cobro	= $r->get_cobro( $_POST['_data1'] );

echo '<pre>';print_r( $_R );echo '</pre>';
echo '<pre>';print_r( $cobro );echo '</pre>';

?>
<script type="text/javascript">

</script>
<main class="container" role="main">

    <div class="py-5 text-center">
        <h2>Recibo</h2>
    </div>

</main>
<?php
require_once('./includes/layout/footer.php');
?>
