<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte PDF</title>
    <style>
        /* Añade estilos CSS aquí */
        body {
            font-size: 10px; /* Tamaño de fuente más pequeño para todo el cuerpo */
        }
        h1 {
            font-size: 30px; /* Tamaño de fuente más grande para el título */
            text-align: center; /* Centra el título */
            margin-bottom: 10px; /* Aumenta el margen inferior para separar el título de la tabla */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }
        img {
            float: left; /* Coloca la imagen a la derecha */
            margin-left: 10px; /* Margen izquierdo para separar la imagen del contenido */
        }
        .cabecera{
            background-color: rgb(253, 0, 0);
            color: white;
        }
    </style>
</head>
<body>
    <img src="img/brand/blue.png" alt="Logo" width="100 px" height="60 px"> <!-- Cambia "ruta/de/tu/logo.png" con la ruta correcta a tu logo -->
   <h1>Reporte Citas de una Enfermera</h1>
       <table>
        <thead class="cabecera">
            <tr>
                <th># Cita</th>
                <th>Enfermera</th>
                <th>Fecha de Cita</th>
                <th>Paciente</th>
                <th>Síntomas</th>
                <th>Tipo de consulta</th>
                <th>Hora de Cita</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resultados as $cita)
                <tr>
                    <td>{{ $cita->id }}</td>
                    <td>{{ $cita->enfermera->usuario }}</td>
                    <td>{{ $cita->scheduled_date }}</td>
                    <td>{{ $cita->patient->usuario }}</td>
                    <td>{{ $cita->description }}</td>
                    <td>{{ $cita->type }}</td>
                    <td>{{ $cita->getScheduledTime12Attribute() }}</td>
                    <td>{{ $cita->status}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
