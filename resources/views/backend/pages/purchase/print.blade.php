@extends('backend.layouts.master')
@push('title')
    Purchases Print
@endpush
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <div class="card p-4" id="invoice">
            {{-- HEADER --}}
            <div class="text-center mb-3">
                <h3 class="fw-bold text-success">Guardian Healthcare Ltd.</h3>
                <p class="mb-0">34, Lake Circus, Kalabagan, Dhaka-1205</p>
                <h5 class="mt-2 text-uppercase">Invoice</h5>
            </div>

            {{-- Supplier INFO --}}
            <table class="table table-borderless mb-3">
                <tr>
                    <td colspan="2">
                        <div class="d-flex justify-content-between">
                            <!-- Start point (left) -->
                            <div>
                                <strong>Supplier Name & ID :</strong> {{ $purchase->supplier?->name }} <br>
                                <strong>Supplier Address :</strong> {{ $purchase->supplier?->address }} <br>
                                <strong>Mobile :</strong> {{ $purchase->supplier?->phone }}
                            </div>

                            <!-- End point (right) -->
                            <div class="text-end">
                                <strong>Payment Type :</strong> Bank <br>
                                <strong>Purchase No :</strong> #{{ $purchase->id }} <br>
                                <strong>Purchase Date :</strong> {{ $purchase->purchase_date }} <br>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            {{-- ITEMS TABLE --}}
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>SL</th>
                        <th>Description of Goods</th>
                        <th>Qty</th>
                        <th>Buying Price</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchase->items as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->product->name }} {{ $item->product?->unit?->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->buying_price,2) }}</td>
                        <td>{{ number_format($item->subtotal,2) }}</td>
                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total</th>
                        <th>{{ number_format($purchase->total_amount,2) }}</th>
                    </tr>
                </tfoot>
            </table>

            {{-- AMOUNT IN WORDS --}}
            <p><strong>Taka (In Words):</strong>
                {{ Str::ucfirst($words) }} taka only
            </p>

            {{-- SIGNATURE --}}
            <div class="row mt-5 text-center">
                <div class="col-4">
                    _____________________ <br>
                    Supplier's Signature
                </div>
                <div class="col-4">
                    _____________________ <br>
                    Prepared By
                </div>
                <div class="col-4">
                    _____________________ <br>
                    Authorized Signature
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@push('scripts')
<script>
    window.addEventListener('load', function() {
        window.print();
    });
</script>
@endpush
