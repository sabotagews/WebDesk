        <script src="<?= $_SESSION['PATH_JS']; ?>jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="<?= $_SESSION['PATH_JS']; ?>bootstrap.min.js"></script>
        <script src="<?= $_SESSION['PATH_JS']; ?>stupidtable.js" type="text/javascript"></script>
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
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
            $(document).ready(function() {
                $(function() {
                    var table = $("table").stupidtable({
                        "date": function(a, b) {
                            // Get these into date objects for comparison.
                            aDate = date_from_string(a);
                            bDate = date_from_string(b);
                            return aDate - bDate;
                        }
                    });
                    table.on("beforetablesort", function(event, data) {
                        // Apply a "disabled" look to the table while sorting.
                        // Using addClass for "testing" as it takes slightly longer to render.
                        $("#msg").text("Sorting...");
                        $("table").addClass("disabled");
                    });
                    table.on("aftertablesort", function(event, data) {
                        // Reset loading message.
                        $("#msg").html("&nbsp;");
                        $("table").removeClass("disabled");
                        var th = $(this).find("th");
                        th.find(".arrow").remove();
                        var dir = $.fn.stupidtable.dir;
                        var arrow = data.direction === dir.ASC ? " &and;" : " &or;";
                        th.eq(data.column).append('<span class="arrow" style="font-size: 1.15em;">' + arrow + '</span>');
                    });
                });
            });
        </script>
    </body>
</html>
