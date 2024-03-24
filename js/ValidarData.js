$(document).ready(function() {
    $("form").submit(function(event) {
        event.preventDefault();

        // Validar que los campos no estén vacíos
        var year = $('#year').val();
        var sampleNumber = $('#sampleNumber').val();
        if (!year || !sampleNumber) {
            $('#alertModalBody').text('Por favor, llena todos los campos.'); // Insertar el mensaje en el modal
            $('#alertModal').modal('show'); // Mostrar el modal
            return;
        }

        $.ajax({
            url: '../Controladores/Validaciones/BusquedaMuestra.php',
            type: 'post',
            data: {
                year: year,
                sampleNumber: sampleNumber
            },
            success: function(data) {
                console.log(data);
                // Parsea los datos devueltos por BusquedaMuestra.php
                var results = JSON.parse(data);

                // Verificar si hay un mensaje de error
                if (results['error-ExtraerParametros']) {
                    $('#alertModalBody').text(results['error-ExtraerParametros']); // Insertar el mensaje de error en el modal
                    $('#alertModal').modal('show'); // Mostrar el modal
                    return;
                }

                if (results['error-Busqueda']) {
                    $('#alertModalBody').text(results['error-Busqueda']); // Insertar el mensaje de error en el modal
                    $('#alertModal').modal('show'); // Mostrar el modal
                    return;
                }

                // Validar que los resultados no estén vacíos
                if (!results || results.length === 0) {
                    $('#alertModalBody').text('No hay datos con los campos ingresados.'); // Insertar el mensaje en el modal
                    $('#alertModal').modal('show'); // Mostrar el modal
                }
            }
        });
    });
});