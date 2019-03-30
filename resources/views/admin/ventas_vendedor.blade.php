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

                    <h2 align="center">Ventas por Vendedor</h2> 
                    <a  href="{{ url('admin/ventas') }}"><span class="badge badge-secondary"> Ventas Global</span>
                    </a>
                    @if($count_publicsales == 1 )
                    <a  href="{{ url('admin/ventas_publico') }}"><span class="badge badge-secondary"> Ventas Público</span>
                    </a>
                    @endif

                    <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>  
                    <div class="row">
                        
                        <span class="badge badge-info" id="btn_no_stk">Columnas Individuales</span>
                        <span class="badge badge-info" id="btn_stk" style="display: none;">Apilar Columnas</span>
                        
                    </div>

                    {!! Form::open(['method' => 'GET', 'url' => '/admin/ventas_vendedor', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
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
                                <td>{{ $detail->seller }}</td> 
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


    var chart = Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'column'
        },
        title: {
            text: 'Ordenes Vendidas por Vendedor'
        },
        xAxis: {
            categories: [
            <?php $months = array(); ?>
            @foreach($orders as $o)
            
            
            @if(!in_array(trim((string)$o->name), $months))
            <?php array_push($months, trim((string)$o->name)); ?>
            '{{ $o->name }}',   
            @endif

            
            @endforeach 
            ]

        },        
        yAxis: {
            min: 0,
            title: {
                text: 'Ingresos'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '<b style="color: {point.color}"> {series.name}: {point.y} </b> <br/>Total del mes: ${point.stackTotal} MXN',
            valueDecimals: 2,
            valuePrefix: '$',
            valueSuffix: ' MXN'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: false,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                }
            }
        },
        series: [
        @foreach($users as $u)
        {name: "{{ $u->name }}",
        data: [
        @foreach($months as $m)
        <?php $valor = 0; ?>
        @foreach($orders->where('name', '==', $m) as $o)            
        @if($u->id == $o->user_id)
        <?php $valor = $o->data; ?>
        @endif
        @endforeach 
        {{ $valor }},
        @endforeach 
        ]
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

    
    $('#btn_stk').click(function () {
        $('#btn_stk').hide();
        $('#btn_no_stk').show();
        chart.update({ plotOptions: { column: {stacking: 'normal' }}});
        chart.redraw();
    });

    $('#btn_no_stk').click(function () {
        $('#btn_no_stk').hide();
        $('#btn_stk').show();
        chart.update({ plotOptions: { column: {stacking: false }}});
        chart.redraw();
    });


    $("#table").tableExport({
    headings: true,                    // (Boolean), display table headings (th/td elements) in the <thead>
    footers: false,                     // (Boolean), display table footers (th/td elements) in the <tfoot>
    formats: ["csv"],    // (String[]), filetypes for the export
    fileName: "Ventas",                    // (id, String), filename for the downloaded file



});

    





</script>
@endsection