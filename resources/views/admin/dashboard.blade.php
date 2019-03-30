 @extends('layouts.backend')

@section('content')

    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><img src="{{ asset('img/redgold.png') }}" class="img d-block" style="width: 15%; height: auto;"></div>

                    <div class="card-body">                       
                        <a  href="{{ url('admin') }}"> <span class="badge btn btn-danger"> Cobranza </span> </a>  
                        <a  href="{{ url('admin/pendientes_entregas') }}"> <span class="badge btn btn-warning"> Pendientes de Entrega </span> </a>
                        @if (Auth::user()->hasRole('Todo') || Auth::user()->hasRole('Admin'))  
                        <a  href="{{ url('admin/ventas') }}"> <span class="badge btn btn-primary"> Ventas </span> </a>  
                         <a  href="{{ url('admin/inventario') }}"> <span class="badge badge-success"> Inventario </span> </a>
                         @endif

                        <h2 align="center">Cobranza</h2>
                        <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>  

                        
                        <table id="table" class="table table-striped">
                            
                                <tr style="background-color: black; color:white;">
                                    <th># Orden</th>
                                    <th>Nombre</th>
                                    <th>Fecha de Entrega</th>
                                    <th>Ultimo Movimiento</th>
                                    <th>Artículos</th>
                                    <th>Adeudo</th>
                                    <th>Vendedor</th>
                                    <th></th>
                                </tr>
                            
                            <tbody>
                                @foreach($details_orders as $detail)
                                    <tr>
                                        <td><a href="/order/orders/{{ $detail->id }}">{{ $detail->id }}</a></td>
                                        <td>{{ $detail->name }}</td>
                                        <td>{{ $detail->date_delivery }}</td>
                                        <td>{{ $detail->actualizacion }}</td>
                                        <td>{{ $detail->articles }}</td>
                                        <td  style="color:  <?php if((int)$detail->due > 0):?>  red <?php else: ?> green  <?php endif ?>; font-weight: bold;">$ {{ $detail->due }}</td>
                                        <td>{{ $detail->seller }}</td>
                                        <td><a href="/admin/abono/{{ $detail->id }}"><span class="badge btn btn-success" style="cursor: pointer;"> Abono </span></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>                      

                    </div>
                </div>
            </div>
        </div>
    </div>

  
@endsection

@section('scripts')
<script type="text/javascript">
    Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Pendientes de Pago'
    },
    tooltip: {
        pointFormat: '<b>{series.name}{point.y}   </b> ({point.percentage:.1f}%)',
        valueDecimals: 2,
        valuePrefix: '$',
                valueSuffix: ' MXN',
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {                
                enabled: true,                
                format: '<b>{point.name}</b> <br>{point.percentage:.1f}%',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: '',
        colorByPoint: true,
        data: {!! $orders->toJson() !!}
    }],
    lang: {
        noData: "No se encontraron ordenes entregadas con Adeudos Pendientes."
    },
    noData: {
        style: {
            fontWeight: 'bold',
            fontSize: '15px',
            color: '#303030'
        }
    }
});

$("#table").tableExport({
    headings: true,                    // (Boolean), display table headings (th/td elements) in the <thead>
    footers: false,                     // (Boolean), display table footers (th/td elements) in the <tfoot>
    formats: ["csv"],    // (String[]), filetypes for the export
    fileName: "Cobranza",                    // (id, String), filename for the downloaded file
   
});

</script>
@endsection