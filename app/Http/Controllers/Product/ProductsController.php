<?php

namespace App\Http\Controllers\Product;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Product;
use App\LogWorkFlow;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $products = Product::where('name', 'LIKE', "%$keyword%")
                ->orWhere('is_active', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $products = Product::latest()->paginate($perPage);
        }

        return view('product.products.index', compact('products'));
    }

    public function productinfo(Request $request){
        $count = 0;

        foreach ($request['products'] as $key => $item){
            $product = Product::find((int)$item);
            $count += ((int)$product->price_retail * (int)$request['quantities'][$key]);
        };

        //$data = Product::all(); // This will get all the request data.
        return response()->json($count);
        //dd($request); // This will dump and die
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('product.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'name' => 'required',
			'is_active' => 'required',
            'price_business' => 'required',
            'price_wholesale' => 'required',
            'price_retail' => 'required',
            'code_bar' => 'unique:products|nullable'
		]);
        $requestData = $request->all();
        
        $producto = Product::create($requestData);

        $lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'CREAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $producto->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $producto->toJson(JSON_PRETTY_PRINT);
        $lwf->save();

        return redirect('product/products')->with('flash_message', 'Producto agregado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('product.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('product.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'is_active' => 'required',
            'price_business' => 'required',
            'price_wholesale' => 'required',
            'price_retail' => 'required',
            'code_bar' => 'unique:products|nullable'
        ]);
        $requestData = $request->all();
        
        $product = Product::findOrFail($id);
        $record_temp = Product::find($id);
        $product->update($requestData);


$lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'ACTUALIZAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $product->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $product->toJson(JSON_PRETTY_PRINT);
        $lwf->info2 = $record_temp->toJson(JSON_PRETTY_PRINT);
        $lwf->save();

        return redirect('product/products')->with('flash_message', 'Producto actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $record_temp = Product::find($id);
        Product::destroy($id);

        
$lwf = new LogWorkFlow;
        $lwf->controller_name = Route::current()->action['controller'];
        $lwf->action = 'ELIMINAR';
        $lwf->page = Route::current()->uri;
        $lwf->register_id = $record_temp->id;
        $lwf->user_id = auth()->user()->id;
        $lwf->info1 = $record_temp->toJson(JSON_PRETTY_PRINT);        
        $lwf->save();

        return redirect('product/products')->with('flash_message', 'Producto eliminado!');
    }
}
