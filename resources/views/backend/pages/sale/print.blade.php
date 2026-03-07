@extends('backend.layouts.master')
@push('title')
    Sales Print
@endpush
@push('css')
    <style>
        .table-borderless,
        .table-borderless tr,
        .table-borderless td,
        .table-borderless th {
            border: none !important;
            padding:0px;
        }
    </style>
@endpush

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <div class="card p-4" id="invoice">
            {{-- HEADER --}}
            <div class="text-center mb-3">
                @if(auth()->user()->company_logo)
                    <img src="{{ asset(auth()->user()->company_logo) }}"
                        alt="Company Logo"
                        style="max-height: 100px; margin-bottom: 10px;">
                @endif
                <h3 class="fw-bold text-success">{{ auth()->user()->company_name ?? 'Company Name Here' }}</h3>
                <p class="mb-0">{{ auth()->user()->company_phone ?? 'Company Phone Here' }}</p>
                <p class="mb-0">{{ auth()->user()->company_address ?? 'Company Address Here' }}</p>
                <h5 class="mt-2 text-uppercase">Invoice</h5>
            </div>

            {{-- CUSTOMER INFO --}}
            <table class="table table-bordered mb-3" style="border:1px solid #ADADAD">
                <tr>
                    <td class="w-50">
                        <div class="d-flex justify-content-between">

                            <!-- LEFT SIDE -->
                            <table class="table table-borderless table-sm w-auto">
                                <tr>
                                    <td class="fw-bold pe-2">Customer Name & ID</td>
                                    <td class="pe-2">:</td>
                                    <td>{{ $sale->customer?->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold pe-2">Customer Address</td>
                                    <td>:</td>
                                    <td>{{ $sale->customer?->address }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold pe-2">Sales Center Name</td>
                                    <td>:</td>
                                    <td>{{ $sale->customer?->sale_center }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold pe-2">District Name</td>
                                    <td>:</td>
                                    <td>{{ $sale->customer?->district }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold pe-2">Thana Name</td>
                                    <td>:</td>
                                    <td>{{ $sale->customer?->thana }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold pe-2">Area Name</td>
                                    <td>:</td>
                                    <td>{{ $sale->customer?->area }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold pe-2">Mobile</td>
                                    <td>:</td>
                                    <td>{{ $sale->customer?->phone }}</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td class="w-50">
                        <!-- RIGHT SIDE -->
                        <div class="d-flex justify-content-start">
                            <table class="table table-borderless table-sm w-auto">
                                <tr>
                                    <td class="fw-bold pe-2">Name & ID</td>
                                    <td class="pe-2">:</td>
                                    <td>{{ $sale->customer?->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold pe-2">Payment Type</td>
                                    <td class="pe-2">:</td>
                                    <td>{{ ucfirst($sale->payment_type) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold pe-2">Order No</td>
                                    <td class="pe-2">:</td>
                                    <td>#{{ $sale->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold pe-2">Order Date</td>
                                    <td class="pe-2">:</td>
                                    <td>{{ Carbon\Carbon::parse($sale->order_date)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold pe-2">Delivery Date</td>
                                    <td class="pe-2">:</td>
                                    <td>{{ Carbon\Carbon::parse($sale->delivery_date)->format('d M Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

            {{-- ITEMS TABLE --}}
            <table class="table table-bordered" style="border:1px solid #ADADAD">
                <thead class="table-secondary p-0" style="">
                    <tr class="p-0">
                        <th class="px-1">SL</th>
                        <th class="px-1">Description of Goods</th>
                        <th class="px-1">Doses Form</th>
                        <th class="px-1">Qty</th>
                        <th class="px-1">Bonus</th>
                        <th class="px-1">TP</th>
                        <th class="px-1">Dis%</th>
                        <th class="px-1">Amount</th>
                        <th class="px-1">Bonus Facility</th>
                    </tr>
                </thead>
                <tbody class="p-0">
                    @foreach($sale->items as $key => $item)
                    <tr class="p-0">
                        <td class="p-1">{{ $key + 1 }}</td>
                        <td class="p-1">{{ $item->product->name }} {{ $item->product?->unit?->name }}</td>
                        <td class="p-1">{{ $item->does_form }}</td>
                        <td class="p-1">{{ $item->quantity }}</td>
                        <td class="p-1">{{ $item->bonus ?? 0 }}</td>
                        <td class="p-1">{{ number_format($item->price,2) }}</td>
                        <td class="p-1">{{ $item->discount ?? 0 }}</td>
                        <td class="p-1">{{ number_format($item->sub_total,2) }}</td>
                        <td class="p-1">{{ $item->bonus_facility ?? 0 }}</td>
                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="7" class="text-end">Total Amount<br> Paid Amount<br> Due Amount</th>
                        <th>{{ number_format($sale->total,2) }} <br> {{ number_format($paymentTransaction->paid,2) }} <br> {{ number_format($paymentTransaction->due,2) }}</th>
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