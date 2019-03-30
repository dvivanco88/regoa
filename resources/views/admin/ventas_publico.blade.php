 @extends('layouts.backend')

 @section('content')
 <div class="container">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><img src="{{ asset('img/redgold.png') }}" class="img d-block" style="width: 15%; height: auto;"></div>

                <div class="card-body">                       
                    <a  href="{{ url('admin') }}"> <span class="badge badge-danger"> Cobranza </span> </a>  
                    <a  href="{{ url('admin/pendientes_entregas') }}"> <span class="badge badge-warning"> Pendientes de Entrega </span> </a>  
                    <a  href="{{ url('admin/ventas') }}"> <span class="badge badge-primary"> Ventas </span> </a>  
                     <a  href="{{ url('admin/inventario') }}"> <span class="badge badge-success"> Inventario </span> </a>
                     
                    <h2 align="center">Ventas Público</h2> <a  href="{{ url('admin/ventas') }}"><span class="badge badge-secondary"> Ventas Global</span></a>
                    <a  href="{{ url('admin/ventas_vendedor') }}"><span class="badge badge-secondary"> Ventas por Vendedor</span>
                    </a> 
                    <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>  

                    {!! Form::open(['method' => 'GET', 'url' => '/admin/ventas_publico', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        

                        <table id="table" class="table table-striped">
                        
                            <tr style="background-color: black; color:white;">
                                
                                <th>Nombre</th>
                                <th># Orden</th>
                                <th>Fecha de Entrega</th>
                                <th>Tipo de Pago</th>
                                <th>Artículos</th>
                                <th>Costo de Orden</th>
                                <th>Cantidad Pagada</th>
                                <th>Vendedor</th>
                                <th>Estado</th>
                            </tr>
                        
                        <tbody>
                            @foreach($orders_list as $detail)
                            <tr>
                                
                                <td>{{ $detail->name }}</td>
                                <td><a href="/order/orders/{{ $detail->id }}">{{ $detail->id }}</a></td>
                                <td>{{ $detail->date_delivery }}</td>
                                <td>{{ $detail->type_pay }}</td>
                                <td>{{ $detail->articles }}</td>
                                <td>$ {{ $detail->cost }}</td>                               
                                <td>$ {{ $detail->advance }}</td>  
                                <td> {{ $detail->seller }}</td>                               
                                <td>{{ $detail->state_name }}</td>
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
            type: 'column'
        },
        title: {
            text: 'Productos/Tickets Vendidos'
        },
        xAxis: {
            categories: ['']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Ingresos'
            }
        },
        tooltip: {
            headerFormat: '',
            pointFormat: '<b>{series.name}: {point.y} </b><br/>' ,
            valueDecimals: 2,
            valuePrefix: '$',
            valueSuffix: ' MXN'           
        },
        plotOptions: {
            column: {
                stacking: false,
                dataLabels: {
                    enabled: false,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                }
            }
        },
        series: [
        @foreach($orders as $o)
        {
            name: "{{ $o->name }}",
            data: [{{ $o->data }}]
        },
        @endforeach
        ],
        lang: {
            noData: "No se encontraron ventas en los últimos 12 meses."
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
    fileName: "Ventas",                    // (id, String), filename for the downloaded file
   
});


</script>
@endsection