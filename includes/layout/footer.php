

		<script src="<?= $_SESSION['PATH_JS']; ?>jquery-3.6.0.min.js"></script>
		<script src="<?= $_SESSION['PATH_JS']; ?>jquery-ui.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="<?= $_SESSION['PATH_JS']; ?>bootstrap.min.js"></script>
		<script src="<?= $_SESSION['PATH_JS']; ?>stupidtable.js" type="text/javascript"></script>
		<script src="<?= $_SESSION['PATH_JS']; ?>tinymce/tinymce.min.js"></script>
		<script src="<?= $_SESSION['PATH_JS']; ?>tinymce/jquery.tinymce.min.js"></script>
        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
	                        
							event.preventDefault( );
							event.stopPropagation( );

							form.classList.add('was-validated');

							if( form.checkValidity( ) === false ) {

								console.log( 'validar: ' + form.name + ', ' + form.checkValidity( ) );

							} else {
						
								console.log( 'ok: ' + form.name );

								switch( event.target.id.toLowerCase( ) ) {

									case 'form_clientes'			:

											setTimeout( guarda_cliente			, <?= DELAY_XHR * 1000; ?> );

										break;

									case 'form_usuarios'			:

											setTimeout( guarda_usuario			, <?= DELAY_XHR * 1000; ?> );

										break;

									case 'form_sucursales'			:

											setTimeout( guarda_sucursal			, <?= DELAY_XHR * 1000; ?> );

										break;

									case 'form_proveedores'			:

											setTimeout( guarda_proveedor		, <?= DELAY_XHR * 1000; ?> );

										break;

									case 'form_proveedorcuentas'	:

											setTimeout( guarda_proveedor_cuenta	, <?= DELAY_XHR * 1000; ?> );

										break;

									case 'form_reservacion'			:
									
											console.log( 'guardar' );

											setTimeout( guarda_reservacion		, <?= DELAY_XHR * 1000; ?> );

										break;

									case 'form_cuentas'				:

											setTimeout( guarda_cuenta			, <?= DELAY_XHR * 1000; ?> );

										break;

									case 'form_cobro'				:

											setTimeout( guarda_cobro			, <?= DELAY_XHR * 1000; ?> );

										break;

									case 'form_pago'				:

											setTimeout( guarda_pago				, <?= DELAY_XHR * 1000; ?> );

										break;

									default							:

											console.log( event.target.id );

										break;

								}

							}


                        }, false);
                    });
                }, false);
            })();
            $(document).ready(function() {
                $(function() {
					var table = $("table").stupidtable({
						"date": function(a,b) {
			            	// Get these into date objects for comparison.
							aDate = date_from_string(a);
			    			bDate = date_from_string(b);
							return aDate - bDate;
						}
			        });

		        	table.on("beforetablesort", function (event, data) {
						// Apply a "disabled" look to the table while sorting.
						// Using addClass for "testing" as it takes slightly longer to render.
						$("#msg").text("Sorting...");
						$("table").addClass("disabled");
					});
					table.on("aftertablesort", function (event, data) {
						// Reset loading message.
						$("#msg").html("&nbsp;");
						$("table").removeClass("disabled");
						var th = $(this).find("th");
						th.find(".arrow").remove();
						var dir = $.fn.stupidtable.dir;
		 				var arrow = data.direction === dir.ASC ? " &and;" : " &or;";
						th.eq(data.column).append('<span class="arrow" style="font-size: 1.15em;">' + arrow +'</span>');
					} );

					tinymce.init({
					    selector: 'textarea',
						force_br_newlines : true,
            			force_p_newlines : false,
						plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
  						imagetools_cors_hosts: ['picsum.photos'],
  						menubar: '',
  						toolbar: 'undo redo | bold italic underline | formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | charmap emoticons | image'
					});
                });
				$.datepicker.setDefaults({
				  yearRange: "1920:2030",
				  changeMonth: true,
				  changeYear: true,
				  numberOfMonths: 2,
				  stepMonths: 1,
				  dateFormat: "dd/mm/yy"
				});
				$( ".hasDatePicker" ).datepicker();
            });
        </script>
    </body>
</html>
