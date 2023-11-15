$(document).ready(function () {
    function realizarBusqueda() {
        var query = $('#search').val();
        var fechaInicio = $('#fecha_inicio').val();
        var fechaFin = $('#fecha_fin').val();

        $.ajax({
            url: '/reports',  // Ruta del controlador
            method: 'GET',
            data: {
                query: query,
                fecha_inicio: fechaInicio,
                fecha_fin: fechaFin
            },
            success: function (data) {
                // Limpiar el contenido actual de #search-results
                $('#search-results').empty();

                // Agregar nuevos resultados basados en los datos recibidos
                if (data.length > 0) {
                    var $ul = $('<ul>'); // Crear una nueva lista

                    // Iterar sobre los resultados y agregar elementos a la lista
                    data.forEach(function (resultado) {
                        var $li = $('<li>').text(resultado); // Crear un elemento de lista
                        $ul.append($li); // Agregar el elemento a la lista
                    });

                    // Agregar la lista completa a #search-results
                    $('#search-results').append($ul);
                } else {
                    // Mostrar un mensaje si no hay resultados
                    $('#search-results').text('No se encontraron resultados.');
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    $('#fecha_inicio, #fecha_fin, #search').on('input', function () {
        realizarBusqueda();
    });

    // Ejecutar la búsqueda al cargar la página
    realizarBusqueda();

    $('#reporte-form').submit(function (e) {
        e.preventDefault();

        // Obtén los resultados y asígnalos al campo oculto
        var resultados = obtenerResultados(); // Ajusta esto según cómo obtienes tus resultados
        $('#pdf-resultados').val(resultados);

        // Envía el formulario para descargar el PDF
        $('#pdf-form').submit();
    });
});
