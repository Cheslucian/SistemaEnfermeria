<!-- charts/appointments-pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Citas Mensuales</title>
</head>
<body>
    <h1>Informe de Citas Mensuales</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Mes</th>
                <th>Cantidad de Citas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($counts as $index => $count)
                <tr>
                    <td>{{ date('F', mktime(0, 0, 0, $index + 1, 1)) }}</td>
                    <td>{{ $count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
