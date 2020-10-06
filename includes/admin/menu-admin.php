<header>
	<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
		<div class="container d-flex justify-content-between">
			<a class="navbar-brand" href="<?= $_SESSION['PATH_HOME']; ?>">
				<img src="<?= $_SESSION['PATH_HOME']; ?>WebDesk.svg" width="30" height="30" alt="" loading="lazy">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<a class="nav-link" href="<?= $_SESSION['PATH_HOME']; ?>reservaciones.php">Reservaciones</a>
					<a class="nav-link" href="<?= $_SESSION['PATH_HOME']; ?>pagos.php">Pagos</a>
					<a class="nav-link" href="<?= $_SESSION['PATH_HOME']; ?>cobros.php">Cobros</a>
					<? if( $_SESSION['currentUser']['usuario_rol'] == 'A' ) { ?>
					<div class="nav-item dropdown">
						<a class="nav-link dropdown-toggle bg-transparent" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Administrar
						</a>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item" href="<?= $_SESSION['PATH_HOME']; ?>clientes.php">Clientes</a>
							<a class="dropdown-item" href="<?= $_SESSION['PATH_HOME']; ?>usuarios.php">Usuarios</a>
							<a class="dropdown-item" href="<?= $_SESSION['PATH_HOME']; ?>sucursales.php">Sucursales</a>
							<a class="dropdown-item" href="<?= $_SESSION['PATH_HOME']; ?>proveedores.php">Proveedores</a>
							<a class="dropdown-item" href="<?= $_SESSION['PATH_HOME']; ?>cuentas.php">Cuentas</a>
						</div>
					</div>
					<? } ?>
					<a class="nav-link" href="<?= $_SESSION['PATH_HOME']; ?>">Salir</a>
				</div>
			</div>
			<div class="float-right text-white"><?= $_SESSION['currentUser']['usuario_nombre']; ?></div>
		</div>
	</nav>
</header>
