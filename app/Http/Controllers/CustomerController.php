<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::with('payment_transactions')->latest()->get();
        return view('backend.pages.customer.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Customer::create($request->all());
        return redirect()->route('customers.index')->with('message','Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('backend.pages.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Customer::findOrFail($id)->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('customers.index')->with('error','Customer updated successfully');
    }

    public function customer_payment($id){
        $customer = Customer::find($id);
        $payments = PaymentTransaction::where('customer_id', $id)->orderBy('sale_id')->get()->groupBy('sale_id');
        return view('backend.pages.customer.payment',compact('customer','payments'));
    }

    public function release_payment(Request $request){
        $customer_id = $request->customer_id;
        $sale_id = $request->sale_id;
        $paid_amount = $request->paid;
        $payment_date = $request->payment_date;
        $note = $request->note;

        // Get the sale payment record
        $lastPayment = PaymentTransaction::where('customer_id', $customer_id)
            ->where('sale_id', $sale_id)
            ->orderBy('id', 'desc')
            ->first();

        $total_sale = $lastPayment ? $lastPayment->total : 0;
        $paid_so_far = PaymentTransaction::where('customer_id', $customer_id)
            ->where('sale_id', $sale_id)
            ->sum('paid');

        $due = $total_sale - $paid_so_far;

        if ($paid_amount > $due) {
            return back()->with('error', 'Paid amount cannot be greater than due.');
        }

        // Create new payment transaction
        PaymentTransaction::create([
            'customer_id' => $customer_id,
            'sale_id'     => $sale_id,
            'total'       => $total_sale,
            'paid'        => $paid_amount,
            'due'         => $due - $paid_amount,
            'payment_date'=> $payment_date,
            'payment_status' => ($due - $paid_amount) == 0 ? 'Paid' : 'Due Payment',
            'note'        => $note,
        ]);

        return back()->with('message', 'Payment released successfully.');
    }
}
