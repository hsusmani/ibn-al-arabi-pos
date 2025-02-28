<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Location;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        // $allProducts = Product::all();

        if(isAdmin()) {
            $products = Product::with('stocks')->get();
        } else {
            $products = Product::with(['stocks' => function($q) {
                $q->whereRelation('location', 'location_id', getUserLocationId());
            }])->get();
        }



        // if(isAdmin()) {
        // } else {
        //     $products = Product::with('stocks', 'location')->whereRelation('location', 'location_id', 1)->get();
        // }

        // $products = [];
        // foreach($stocks as $stock) {

        //     // $expected =
        //     $avaialble_qnty = 0;
        //     $expected_qnty = 0;
        //     $ids = array();
        //     foreach($stock as $s) {
        //         dd($s);
        //         $avaialble_qnty = $avaialble_qnty + $s->available_qnty;
        //         $expected_qnty = $expected_qnty + $s->expected_qnty;
        //         array_push($ids, $s->id);
        //     }
        //     array_push($products, [
        //         'stock_ids' => $ids,
        //         'id' => $stock[0]->product->id,
        //         'sku' => $stock[0]->product->sku,
        //         'image' => $stock[0]->product->image,
        //         'name' => $stock[0]->product->name,
        //         'expected_qnty' => $expected_qnty,
        //         'available_qnty' => $avaialble_qnty,
        //         'selling_price' => $stock[0]->product->selling_price,
        //     ]);
        // }



        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */


    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::where('id', $id)->get()->first();
        return view('products.view', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::where('id', $id)->get()->first();
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::where('id', $id);
        $stocks = $product->first()->stocks;
        foreach($stocks as $stock) {
            $stock->delete();
        }
        $product->delete();
        return redirect()->route('products.index')->with('message', 'Sucessfully Deleted the Product & Its Stocks');
    }

    public function import() {
        return view('products.import');
    }


}
