<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordenes entregas a tiempo</title>
</head>

<body>
    <div class="container">
        <div>
            <img style="float: left;" src="{{ public_path() . '/images/logo/logo_empresa.png' }}" width="180px" height="50px" alt="casa de radiadores">
            <div style="float: right;font-size: 13px;">{{date("d/m/Y", strtotime($date_now)).' '.$hour}}</div>
        </div>
        <h1 style="margin-top:51px;font-size: 20px;" class="text-center">Reporte de ordenes entregadas a tiempo <br>del periodo de {{date("d/m/Y", strtotime($expected_date_i))}} hasta el {{date("d/m/Y", strtotime($expected_date_f))}}</h1>
        <div class="card" style="font-size: 13px;">
            <table id="" class="table table-bordered text-center" width="100%">
                <thead style="background-color: rgb(204,204,204);">
                    <tr>
                        <th class="align-middle text-sm">N°</th>
                        <th class="align-middle text-sm">Codigo de Orden</th>
                        <th class="align-middle text-sm">Cliente</th>
                        <th class="align-middle text-sm">Proyecto</th>
                        <th class="align-middle text-sm">Lugar de entrega</th>
                        <th class="align-middle text-sm">Fecha entrega solicitada</th>
                        <th class="align-middle text-sm">Fecha entrega real</th>
                        <th class="align-middle text-sm">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 1;
                    @endphp
                    @foreach($orders as $order)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$order->order_business}}</td>
                        <td>{{$order->name}}</td>
                        <td>{{$order->project}}</td>
                        <td>{{$order->delivery_place}}</td>
                        <td>{{date("d/m/Y", strtotime($order->expected_date))}}</td>

                        @if($order->end_date == '')
                        <td>Por confirmar</td>
                        @else
                        <td>{{date("d/m/Y", strtotime($order->end_date))}}</td>
                        @endif

                        @if($order->status == '1')
                        <td>Por planificar</td>
                        @endif

                        @if($order->status == '2')
                        <td>En proceso</td>
                        @endif

                        @if($order->status == '3')
                        <td>Finalizado</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(270, 820, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
    </script>
</body>

</html>
<style>
    .align-middle {
        vertical-align: middle !important;
    }

    .text-sm-start {
        text-align: left !important;
    }

    .text-sm-end {
        text-align: right !important;
    }

    .text-sm-center {
        text-align: center !important;
    }

    .table {
        --bs-table-bg: transparent;
        --bs-table-accent-bg: transparent;
        --bs-table-striped-color: #212529;
        --bs-table-striped-bg: rgba(0, 0, 0, 0.05);
        --bs-table-active-color: #212529;
        --bs-table-active-bg: rgba(0, 0, 0, 0.1);
        --bs-table-hover-color: #212529;
        --bs-table-hover-bg: rgba(0, 0, 0, 0.075);
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        vertical-align: top;
        border-color: #dee2e6;
    }

    .table> :not(caption)>*>* {
        padding: 0.5rem 0.5rem;
        background-color: var(--bs-table-bg);
        border-bottom-width: 1px;
        box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
    }

    .table>tbody {
        vertical-align: inherit;
    }

    .table>thead {
        vertical-align: bottom;
    }

    .table> :not(:last-child)> :last-child>* {
        border-bottom-color: currentColor;
    }

    .caption-top {
        caption-side: top;
    }

    .table-sm> :not(caption)>*>* {
        padding: 0.25rem 0.25rem;
    }

    .table-bordered> :not(caption)>* {
        border-width: 1px 0;
    }

    .table-bordered> :not(caption)>*>* {
        border-width: 0 1px;
    }

    .table-borderless> :not(caption)>*>* {
        border-bottom-width: 0;
    }

    .table-striped>tbody>tr:nth-of-type(odd) {
        --bs-table-accent-bg: var(--bs-table-striped-bg);
        color: var(--bs-table-striped-color);
    }

    .table-active {
        --bs-table-accent-bg: var(--bs-table-active-bg);
        color: var(--bs-table-active-color);
    }

    .table-hover>tbody>tr:hover {
        --bs-table-accent-bg: var(--bs-table-hover-bg);
        color: var(--bs-table-hover-color);
    }

    .table-primary {
        --bs-table-bg: #cfe2ff;
        --bs-table-striped-bg: #c5d7f2;
        --bs-table-striped-color: #000;
        --bs-table-active-bg: #bacbe6;
        --bs-table-active-color: #000;
        --bs-table-hover-bg: #bfd1ec;
        --bs-table-hover-color: #000;
        color: #000;
        border-color: #bacbe6;
    }

    .table-secondary {
        --bs-table-bg: #e2e3e5;
        --bs-table-striped-bg: #d7d8da;
        --bs-table-striped-color: #000;
        --bs-table-active-bg: #cbccce;
        --bs-table-active-color: #000;
        --bs-table-hover-bg: #d1d2d4;
        --bs-table-hover-color: #000;
        color: #000;
        border-color: #cbccce;
    }

    .table-success {
        --bs-table-bg: #d1e7dd;
        --bs-table-striped-bg: #c7dbd2;
        --bs-table-striped-color: #000;
        --bs-table-active-bg: #bcd0c7;
        --bs-table-active-color: #000;
        --bs-table-hover-bg: #c1d6cc;
        --bs-table-hover-color: #000;
        color: #000;
        border-color: #bcd0c7;
    }

    .table-info {
        --bs-table-bg: #cff4fc;
        --bs-table-striped-bg: #c5e8ef;
        --bs-table-striped-color: #000;
        --bs-table-active-bg: #badce3;
        --bs-table-active-color: #000;
        --bs-table-hover-bg: #bfe2e9;
        --bs-table-hover-color: #000;
        color: #000;
        border-color: #badce3;
    }

    .table-warning {
        --bs-table-bg: #fff3cd;
        --bs-table-striped-bg: #f2e7c3;
        --bs-table-striped-color: #000;
        --bs-table-active-bg: #e6dbb9;
        --bs-table-active-color: #000;
        --bs-table-hover-bg: #ece1be;
        --bs-table-hover-color: #000;
        color: #000;
        border-color: #e6dbb9;
    }

    .table-danger {
        --bs-table-bg: #f8d7da;
        --bs-table-striped-bg: #eccccf;
        --bs-table-striped-color: #000;
        --bs-table-active-bg: #dfc2c4;
        --bs-table-active-color: #000;
        --bs-table-hover-bg: #e5c7ca;
        --bs-table-hover-color: #000;
        color: #000;
        border-color: #dfc2c4;
    }

    .table-light {
        --bs-table-bg: #f8f9fa;
        --bs-table-striped-bg: #ecedee;
        --bs-table-striped-color: #000;
        --bs-table-active-bg: #dfe0e1;
        --bs-table-active-color: #000;
        --bs-table-hover-bg: #e5e6e7;
        --bs-table-hover-color: #000;
        color: #000;
        border-color: #dfe0e1;
    }

    .table-dark {
        --bs-table-bg: #212529;
        --bs-table-striped-bg: #2c3034;
        --bs-table-striped-color: #fff;
        --bs-table-active-bg: #373b3e;
        --bs-table-active-color: #fff;
        --bs-table-hover-bg: #323539;
        --bs-table-hover-color: #fff;
        color: #fff;
        border-color: #373b3e;
    }

    .text-center {
        text-align: center !important;
    }

    .table-sm> :not(caption)>*>* {
        padding: 0.25rem 0.25rem;
    }

    h6,
    .h6,
    h5,
    .h5,
    h4,
    .h4,
    h3,
    .h3,
    h2,
    .h2,
    h1,
    .h1 {
        margin-top: 0;
        margin-bottom: 0.5rem;
        font-weight: 500;
        line-height: 1.2;
    }

    h4,
    .h4 {
        font-size: calc(1.275rem + 0.3vw);
    }

    .container,
    .container-fluid,
    .container-xxl,
    .container-xl,
    .container-lg,
    .container-md,
    .container-sm {
        width: 100%;
        padding-right: var(--bs-gutter-x, 0.75rem);
        padding-left: var(--bs-gutter-x, 0.75rem);
        margin-right: auto;
        margin-left: auto;
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem;
    }
</style>