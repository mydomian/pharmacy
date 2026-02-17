@extends('backend.layouts.master')
@push('title')
    Sales Print
@endpush
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <div class="card p-4" id="invoice">
            {{-- HEADER --}}
            <div class="text-center mb-3">
                @if(auth()->user()->company_logo)
                    <img src="{{ asset('storage/' . auth()->user()->company_logo) }}"
                        alt="Company Logo"
                        style="max-height: 100px; margin-bottom: 10px;">
                @endif
                <h3 class="fw-bold text-success">{{ auth()->user()->company_name ?? 'Company Name Here' }}</h3>
                <p class="mb-0">{{ auth()->user()->company_phone ?? 'Company Phone Here' }}</p>
                <p class="mb-0">{{ auth()->user()->company_address ?? 'Company Address Here' }}</p>
                <h5 class="mt-2 text-uppercase">Invoice</h5>
            </div>

            {{-- CUSTOMER INFO --}}
            <table class="table table-borderless mb-3">
                <tr>
                    <td colspan="2">
                        <div class="d-flex justify-content-between">
                            <!-- Start point (left) -->
                            <div>
                                <strong>Customer Name & ID :</strong> {{ $sale->customer?->name }} <br>
                                <strong>Customer Address :</strong> {{ $sale->customer?->address }} <br>
                                <strong>Sales Center Name :</strong> {{ $sale->customer?->sale_center }} <br>
                                <strong>District Name :</strong> {{ $sale->customer?->district }} <br>
                                <strong>Thana Name :</strong> {{ $sale->customer?->thana }} <br>
                                <strong>Area Name :</strong> {{ $sale->customer?->area }} <br>
                                <strong>Mobile :</strong> {{ $sale->customer?->phone }}
                            </div>

                            <!-- End point (right) -->
                            <div class="text-end">
                                <strong>Name & ID :</strong> {{ auth()->user()->company_name ?? 'Company Name Here' }} <br>
                                <strong>Payment Type :</strong> {{ ucfirst($sale->payment_type) }} <br>
                                <strong>Order No :</strong> #{{ $sale->id }} <br>
                                <strong>Order Date :</strong> {{ $sale->order_date }} <br>
                                <strong>Delivery Date :</strong> {{ $sale->delivery_date }}
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
                        <th>Doses Form</th>
                        <th>Qty</th>
                        <th>Bonus</th>
                        <th>Rate</th>
                        <th>Dis %</th>
                        <th>Amount</th>
                        <th>Bonus Facility</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->product->name }} {{ $item->product?->unit?->name }}</td>
                        <td>{{ $item->does_form }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->bonus ?? 0 }}</td>
                        <td>{{ number_format($item->price,2) }}</td>
                        <td>{{ $item->discount ?? 0 }}</td>
                        <td>{{ number_format($item->sub_total,2) }}</td>
                        <td>{{ $item->bonus_facility ?? 0 }}</td>
                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="7" class="text-end">Total</th>
                        <th>{{ number_format($sale->total,2) }}</th>
                        <th></th>
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
                    Customer's Signature
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
