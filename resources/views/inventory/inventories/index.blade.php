@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.sidebar')

        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Inventarios</div>
                <div class="card-body">
                    

                    <span class="btn btn-primary btn-sm" id="btn_print" title="Print">
                        <i class="fas fa-print" aria-hidden="true"></i> Imprimir
                    </span>

                    {!! Form::open(['method' => 'GET', 'url' => '/inventory/inventories', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                        <span class="input-group-append">
                            <button class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                    {!! Form::close() !!}

                    <br/>
                    <br/>
                    <div class="table-responsive print-inventary">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    @foreach($warehouses as $w)
                                    <th>{{ $w->name }}</th>
                                    @endforeach
                                    
                                </tr>
                            </thead>
                            <tbody>


                                @foreach($products as $p) 
                                <tr style="border-bottom: 1px solid #DCDCDC">
                                    <td>{{ $p->id }}</td>
                                    <td>{{ $p->name }}</td>
                                    
                                @foreach($warehouses as $w)                                 
                                
                                <td>
                                    <?php 
                                    $cantidad = $inventories->where('product_id', '=', $p->id)
                                    ->where('warehouse_id', '=', $w->id)->first();
                                    ?>
                                    @if($cantidad) 
                                    {{ $cantidad->quantity }} <a href="{{ url('/inventory/inventories/'. $cantidad->id.'/edit') }}" title="Edit Inventory">
                                            <span class="badge badge-primary d-print-none" style="margin-left: 1%;">Editar</span>
                                        </a>
                                    @else
                                    0 <a href="{{ url('/inventory/inventories/create?product_id='.$p->id.'&warehouse_id='.$w->id ) }}" title="Edit Inventory">
                                            <span class="badge badge-primary d-print-none" style="margin-left: 1%;">Editar</span>
                                        </a>
                                    @endif
                                </td>

                                    
                                   
                                    
                                    

                                    
                                
                                @endforeach
                                </tr>


                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {!! $inventories->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


 @section('scripts')
            <script type="text/javascript">
                
                $("#btn_print").click(function() {
                  $('.print-inventary').printThis();
              });

                

          </script>
          @endsection