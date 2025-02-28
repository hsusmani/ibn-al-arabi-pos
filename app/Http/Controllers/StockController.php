<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Location;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $stocks = Stock::orderBy('created_at', 'desc')->get()->groupBy('product_id');
        $StockArray = [];
        foreach($stocks as $stock) {
            // $expected =
            $avaialble_qnty = 0;
            $expected_qnty = 0;
            $ids = array();
            foreach($stock as $s) {
                $avaialble_qnty = $avaialble_qnty + $s->available_qnty;
                $expected_qnty = $expected_qnty + $s->expected_qnty;
                array_push($ids, $s->id);
            }
            array_push($StockArray, [
                'stock_ids' => $ids,
                'name' => $stock[0]->product->name,
                'expected_qnty' => $expected_qnty,
                'available_qnty' => $avaialble_qnty,
            ]);
        }
        return view('stocks.index', compact('StockArray'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // $ids = explode(',', $request->ids);
        // $id = $request->id;
        // return view('stocks.create', compact('id', 'ids'));
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
    public function show(Request $request)
    {
        dd($request);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editQnty($stockId, $productId)
    {
        return view('stocks.edit', compact('stockId', 'productId'));
    }
    public function add($stockId, $productId)
    {
        return view('stocks.add', compact('stockId', 'productId'));
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
        Stock::where('id', $id)->delete();

        return redirect()->route('stocks.index')->with('success', 'Stock has been deleted');
    }

    public function transfers($stockId, $productId)
    {
        return view('stocks.transfers', compact('stockId', 'productId'));
    }


    public function details($productId)
    {
        if(isAdmin()) {
            $product = Product::where('id', $productId)->get();
            $stocks = Stock::whereRelation('product', 'product_id', $product->first()->id)->get();
        } else {
            $product = Product::where('id', $productId)->get();
            $stocks = Stock::whereRelation('location', 'location_id', getUserLocationId())->whereRelation('product', 'product_id', $product->first()->id)->get();
        }

        // if(auth()->user()->hasRole('Super'))

        return view('stocks.details', compact('stocks'));
    }


    public function confirmTransfer($stockId, $productId)
    {
        // $stock = Stock::where('id', $request->id)->get();
        // $product = Product::where('id', $stock->first()->product_id)->get();
        return view('stocks.confirmTransfer', compact('stockId', 'productId'));
    }
}
