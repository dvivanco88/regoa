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

                    <h2 align="center">20+ Pedidos</h2>
                    <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>  


                    {!! Form::open(['method' => 'GET', 'url' => '/admin/inventario', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                        <span class="input-group-append">
                            <button class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                    {!! Form::close() !!}


                    
                    <div class="col-12" style="margin-top: 5%;">
                        <details><summary>Global</summary> 
                            <div style="border: 1px solid #C4C6C8; padding: 3px; border-radius: 5px;">
                                <h3 align="center">Global</h3>
                                <table id="table_global" class="table table-striped">

                                    <tr style="background-color: black; color:white;">                                
                                        <th>Producto</th>
                                        <th>Cantidad</th>                                
                                    </tr>

                                    <tbody>
                                        @foreach($inventory as $detail)
                                        <tr>

                                            <td>{{ $detail->name }}</td>
                                            <td style="color:  <?php if((int)$detail->quantity <= 0):?>  red <?php elseif ((int)$detail->quantity <= 10):?> orange <?php else: ?> black  <?php endif ?>; font-weight: bold;">{{ $detail->quantity }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>                           
                        </details>
                    </div>

                    @foreach($warehouses as $w)
                    <div class="col-12" style="margin-top: 5%;">
                        <details><summary>{{ $w->name }} , Prioridad: {{$w->priority }}</summary> 
                            <div style="border: 1px solid #C4C6C8; padding: 3px; border-radius: 5px;">
                                <h3 align="center">{{ $w->name }} ({{$w->priority }})</h3>
                                <table id="table_{{ $w->name }}" class="table table-striped">

                                    <tr style="background-color: black; color:white;">                                
                                        <th>Producto</th>
                                        <th>Cantidad</th>                                
                                    </tr>

                                    <tbody>
                                        @foreach($products as $p)
                                        <tr>
                                            <?php 
                                            $cantidad = $inventories->where('product_id', '=', $p->id)
                                            ->where('warehouse_id', '=', $w->id)->first();
                                            ?>
                                            <td>{{ $p->name }}</td>
                                            <td style="color:  <?php if($cantidad && (int)$cantidad->quantity <= 0):?>  red <?php elseif ($cantidad && (int)$cantidad->quantity <= 10):?> orange <?php else: ?> black  <?php endif ?>; font-weight: bold;">
                                                @if($cantidad) 
                                                {{ $cantidad->quantity }} 
                                                @else
                                                0
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>                           
                        </details>
                    </div>
                    @section('scripts2')
                    @parent
                    <script type="text/javascript">
                     $("#table_{{ $w->name }}").tableExport({
                        headings: true,                    
                        footers: false,                    
                        formats: ["csv"],    
                        fileName: "Inventario_{{ $w->name }}"

                    });
                </script>
                @endsection
                @endforeach





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
        text: 'Productos más Vendidos'
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
        pointFormat: '<b>{series.name}: {point.y} </b><br/>'                    
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
    @foreach($chart_request as $o)
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



  $("#table_global").tableExport({
    headings: true,                    // (Boolean), display table headings (th/td elements) in the <thead>
    footers: false,                     // (Boolean), display table footers (th/td elements) in the <tfoot>
    formats: ["csv"],    // (String[]), filetypes for the export
    fileName: "Inventario_Global",                    // (id, String), filename for the downloaded file

});



</script>
@endsection