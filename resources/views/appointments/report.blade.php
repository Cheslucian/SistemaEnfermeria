<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de citas médicas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <header>
        <h3 style="text-align: center;">Reporte de citas médicas</h3>
    </header>
    <table class="table table-stripped text-center" style="font-size: x-small;">
        <thead>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Motivo</th>
            <th>Enfermera</th>
            <th>Paciente</th>
            <th>Descripción</th>
        </thead>
        <tbody>
            <?php
                $cantidadTotal=0;
                $cantidadReservadas=0;
                $cantidadConfirmadas=0;
                $cantidadCanceladas=0;
                $cantidadAtendidas=0;
            ?>
            @foreach ($citas as $cita)
            <?php
                $cantidadTotal++;
                if ($cita->status=="Reservada")
                    $cantidadReservadas++;
                elseif($cita->status=="Atendida")
                    $cantidadAtendidas++;
                elseif($cita->status=="Cancelada")
                    $cantidadCanceladas++;
                elseif($cita->status== "Confirmada")
                    $cantidadConfirmadas++;
            ?>
            <tr>
                <td>
                    {{$cita->scheduled_date}}
                </td>
                <td>
                    {{$cita->scheduled_time}}
                </td>
                <td>
                    {{$cita->type}}
                </td>
                <td>
                    {{$cita->nomEnfermera . " " . $cita->ap1Enfermera . " " . $cita->ap2Enfermera}}
                </td>
                <td>
                    {{$cita->nomPaciente . " " . $cita->ap1Paciente . " " . $cita->ap2Paciente}}
                </td>
                <td>
                    {{$cita->description}}
                </td>
            @endforeach
            <tr>
                <td colspan="6"><div class="page-break"></div></td>
            </tr>
        </tbody>
        
        <tfoot>
            
            <tr>
                <td colspan="5" style="text-align:left">
                    Cantidad total de citas reservadas pero no confirmadas: 
                </td>
                <td style="text-align:right">
                    {{$cantidadReservadas}}
                </td>
            </tr>
            <tr>
            <td colspan="5" style="text-align:left">
                    Cantidad total de citas reservadas y confirmadas: 
                </td>
                <td style="text-align:right">
                    {{$cantidadConfirmadas}}
                </td>
            </tr>
            <tr>
            <td colspan="5" style="text-align:left">
                    Cantidad total de citas atendidas: 
                </td>
                <td style="text-align:right">
                    {{$cantidadAtendidas}}
                </td>
            </tr>
            <tr>
            <td colspan="5" style="text-align:left">
                    Cantidad total de citas candeladas: 
                </td>
                <td style="text-align:right">
                    {{$cantidadCanceladas}}
                </td>
            </tr>
            <tr>
            <td colspan="5" style="text-align:left">
                    Cantidad total de citas: 
                </td>
                <td style="text-align:right">
                    {{$cantidadTotal}}
                </td>
            </tr>

        </tfoot>

    </table>

    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(270, 780, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
	</script>

</body>
</html>
