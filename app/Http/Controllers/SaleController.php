<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PaymentTransaction;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\StockLog;
use Illuminate\Http\Request;
use NumberToWords\NumberToWords;


class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer','items')->latest()->get();
        return view('backend.pages.sale.index',compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::get();
        $products = Product::get();
        return view('backend.pages.sale.create', compact('customers','products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sale = Sale::create([
            'customer_id' => $request->customer_id,
            'payment_type' => "cash",
            'order_date' => $request->order_date,
            'delivery_date' => $request->delivery_date,
            'total' => array_sum($request->subtotal),
            'date' => date('Y-m-d'),
        ]);
        foreach ($request->product_id as $index => $productId) {

            $totalDeduct = ($request->quantity[$index] ?? 0) + ($request->bonus[$index] ?? 0) + ($request->bonus_facility[$index] ?? 0);

            $sale->items()->create([
                'product_id'   => $productId,
                'does_form'   => $request->does_form[$index],
                'quantity'     => $request->quantity[$index],
                'bonus'     => $request->bonus[$index],
                'price'     => $request->price[$index],
                'discount'     => $request->discount[$index],
                'sub_total' => $request->subtotal[$index],
                'bonus_facility' => $request->bonus_facility[$index],
            ]);
            $stock = Stock::firstOrCreate(
                ['product_id' => $productId],
                ['quantity' => 0]
            );
            $stock->quantity = $stock->quantity - $totalDeduct;
            $stock->save();
            $stockLog = StockLog::create([
                'customer_id' => $request->customer_id,
                'sale_id' => $sale->id,
                'product_id' => $productId,
                'quantity' => $request->quantity[$index],
                'bonus' => $request->bonus[$index],
                'bonus_facility' => $request->bonus_facility[$index],
                'date' => date('Y-m-d'),
                'type' => 'out',
            ]);
        }
        $paymentTransaction = PaymentTransaction::create([
            'customer_id' => $request->customer_id,
            'sale_id' => $sale->id,
            'total' => $sale->total,
            'paid' => $request->paid_amount,
            'due' => $sale->total - $request->paid_amount,
            'payment_date' => $sale->date,
            'payment_status' => "Inital Payment",
            'note' => $request->note,
        ]);

        return redirect()->route('sales.print', $sale->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sale = Sale::with('customer','items.product')->findOrFail($id);
        return view('backend.pages.sale.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customers = Customer::get();
        $products = Product::get();
        $sale = Sale::with('customer','items.product','payment_transactions')->findOrFail($id);
        return view('backend.pages.sale.edit', compact('customers','products','sale'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);

        // Restore stock for existing items first
        foreach ($sale->items as $oldItem) {
            $totalOld = ($oldItem->quantity ?? 0) + ($oldItem->bonus ?? 0) + ($oldItem->bonus_facility ?? 0);
            $stock = Stock::firstOrCreate(
                ['product_id' => $oldItem->product_id],
                ['quantity' => 0]
            );
            $stock->quantity += $totalOld; // restore stock
            $stock->save();

            // Delete old stock logs
            StockLog::where('sale_id', $sale->id)
                    ->where('product_id', $oldItem->product_id)
                    ->delete();
        }

        // Update sale info
        $sale->update([
            'customer_id' => $request->customer_id,
            'payment_type' => "cash",
            'order_date' => $request->order_date,
            'delivery_date' => $request->delivery_date,
            'total' => array_sum($request->subtotal),
            'date' => date('Y-m-d'),
        ]);

        // Remove old items
        $sale->items()->delete();

        // Create new items & update stock
        foreach ($request->product_id as $index => $productId) {

            $totalDeduct = ($request->quantity[$index] ?? 0) + ($request->bonus[$index] ?? 0) + ($request->bonus_facility[$index] ?? 0);

            $sale->items()->create([
                'product_id' => $productId,
                'does_form' => $request->does_form[$index],
                'quantity' => $request->quantity[$index],
                'bonus' => $request->bonus[$index],
                'price' => $request->price[$index],
                'discount' => $request->discount[$index],
                'sub_total' => $request->subtotal[$index],
                'bonus_facility' => $request->bonus_facility[$index],
            ]);

            // Update stock
            $stock = Stock::firstOrCreate(
                ['product_id' => $productId],
                ['quantity' => 0]
            );
            $stock->quantity -= $totalDeduct;
            $stock->save();

            // Create stock log
            StockLog::create([
                'customer_id' => $request->customer_id,
                'sale_id' => $sale->id,
                'product_id' => $productId,
                'quantity' => $request->quantity[$index],
                'bonus' => $request->bonus[$index],
                'bonus_facility' => $request->bonus_facility[$index],
                'date' => date('Y-m-d'),
                'type' => 'out',
            ]);
        }
        $payment = PaymentTransaction::where(['sale_id'=>$sale->id,'customer_id'=>$sale->customer_id])->first();
        $payment->update([
            'customer_id' => $request->customer_id,
            'total' => $sale->total,
            'paid' => $request->paid_amount,
            'due' => $sale->total - $request->paid_amount,
            'payment_date' => $sale->date,
            'payment_status' => "Due Payment",
            'note' => $request->note,
        ]);
        return redirect()->route('sales.print', $sale->id);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();
        return redirect()->route('sales.index')->with('error','Sale deleted successfully');
    }

    public function print($id){
        $sale = Sale::with('customer','items.product')->findOrFail($id);
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');
        $words = $numberTransformer->toWords($sale->total);
        return view('backend.pages.sale.print', compact('sale','words'));
    }

    public function reports(Request $request){
        $fromDate = $request->query('from_date') ?? date('Y-m-d');
        $toDate = $request->query('to_date') ?? date('Y-m-d');
        $sales = Sale::with('customer', 'items')->whereBetween('date', [$fromDate, $toDate])->latest()->get();
        return view('backend.pages.sale.report', compact('sales', 'fromDate', 'toDate'));
    }
}
