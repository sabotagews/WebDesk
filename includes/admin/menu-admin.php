<header>
	<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
		<a class="navbar-brand" href="<?= $_SESSION['PATH_HOME']; ?>">
			<img src="<?= $_SESSION['PATH_HOME']; ?>WebDesk.svg" width="30" height="30" alt="" loading="lazy">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			<div class="navbar-nav">
				<div class="nav-item dropdown">
					<a class="nav-link dropdown-toggle bg-transparent" role="button" id="dropdownReservaciones" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Reservaciones
					</a>
					<div class="dropdown-menu" aria-labelledby="dropdownReservaciones">
						<a class="dropdown-item" href="<?= $_SESSION['PATH_HOME']; ?>nueva_reservacion.php">Nueva Reservación</a>
						<a class="dropdown-item" href="<?= $_SESSION['PATH_HOME']; ?>reservaciones.php">Listado de Reservaciones</a>
					</div>
				</div>
				<a class="nav-link" href="<?= $_SESSION['PATH_HOME']; ?>pagos.php">Pagos</a>
				<a class="nav-link" href="<?= $_SESSION['PATH_HOME']; ?>cobros.php">Cobros</a>

				<div class="nav-item dropdown">
					<a class="nav-link dropdown-toggle bg-transparent" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Administrar
					</a>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item" href="<?= $_SESSION['PATH_HOME']; ?>clientes.php">Clientes</a>
					<? if( $_SESSION['currentUser']['usuarioRol'] == 'A' ) { ?>
						<a class="dropdown-item" href="<?= $_SESSION['PATH_HOME']; ?>usuarios.php">Usuarios</a>
						<a class="dropdown-item" href="<?= $_SESSION['PATH_HOME']; ?>sucursales.php">Sucursales</a>
						<a class="dropdown-item" href="<?= $_SESSION['PATH_HOME']; ?>proveedores.php">Proveedores</a>
						<a class="dropdown-item" href="<?= $_SESSION['PATH_HOME']; ?>cuentas.php">Cuentas</a>
					<? } ?>
					</div>
				</div>

				<a class="nav-link" href="<?= $_SESSION['PATH_HOME']; ?>">Salir</a>
			</div>
		</div>
		<div class="float-right text-white"><?= $_SESSION['currentUser']['usuarioNombre']; ?></div>
	</nav>
</header>
