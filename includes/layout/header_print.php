<div class="row d-print-flex d-none">
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
		<p>Elaboró <strong><?= $_SESSION['currentUser']['usuarioNombre'] . ' ' . $_SESSION['currentUser']['usuarioApellido']; ?></strong></p>
	</div>
</div>
