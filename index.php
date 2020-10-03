<?php
session_start();
require_once( 'definitions.php' );
require_once('./includes/layout/header.php');
?>
<script>
form.action = <?= $_SESSION['PATH_HOME']; ?> + 'usuarios.php';
</script>
<div class="text-center align-self-center">
	<form class="form-signin" action="<?= $_SESSION['PATH_HOME']; ?>usuarios.php">
		<img class="mb-4" src="./images/logo.png" alt="" width="200">
		<h1 class="h3 mb-3 font-weight-normal">Bienvenido</h1>
		<label for="inputEmail" class="sr-only">Email</label>
		<input type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
		<button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar</button>
		<p class="mt-5 mb-3 text-muted">
			<img src="WebDesk-H.svg" alt="WebDesk 2020" width="150px">
		</p>
	</form>
</div>

<?php
require_once('./includes/layout/footer.php');
?>