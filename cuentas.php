<?php
session_start();
require_once( 'definitions.php' );
require_once('./includes/layout/header.php');
require_once('./includes/admin/menu-admin.php');
?>
<main class="container" role="main">
	<div class="mt-5 mx-auto" style="width: 300px;">
		<img src="<?= $_SESSION['PATH_IMAGES']; ?>logo.png" alt="WebDesk Turismo Salomón">
	</div>
</main>
<?php
require_once('./includes/layout/footer.php');
?>
