@extends('backend.layouts.master')
@push('title')
    Purchases Print
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

            {{-- Supplier INFO --}}
            <table class="table table-bordered mb-3">
                <tr>
                    <td class="w-50">
                        <div class="d-flex justify-content-between">

                            <!-- LEFT SIDE -->
                            <table class="table table-borderless table-sm w-auto">
                                <tr>
                                    <td class="fw-bold pe-2">Supplier Name & ID</td>
                                    <td class="pe-2">:</td>
                                    <td>{{ $purchase->supplier?->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold pe-2">Supplier Address</td>
                                    <td class="pe-2">:</td>
                                    <td>{{ $purchase->supplier?->address }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold pe-2">Mobile</td>
                                    <td class="pe-2">:</td>
                                    <td>{{ $purchase->supplier?->phone }}</td>
                                </tr>
                            </table>

                           

                        </div>
                    </td>
                    <td class="w-50">
                        <div class="d-flex justify-content-end">
                             <!-- RIGHT SIDE -->
                            <table class="table table-borderless table-sm w-auto text-end">
                                <tr>
                                    <td class="fw-bold pe-2">Name & ID</td>
                                    <td class="pe-2">:</td>
                                    <td>{{ $purchase->supplier?->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold pe-2">Payment Type</td>
                                    <td class="pe-2">:</td>
                                    <td>Bank</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold pe-2">Purchase No</td>
                                    <td class="pe-2">:</td>
                                    <td>#{{ $purchase->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold pe-2">Purchase Date</td>
                                    <td class="pe-2">:</td>
                                    <td>{{ Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}</td>
                                </tr>
                            </table>
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
                        <th colspan="4" class="text-end">Total Amount<br> Paid Amount<br> Due Amount</th>
                        <th>{{ number_format($purchase->total_amount,2) }} <br> {{ number_format($purchase->total_amount,2) }} <br> {{ number_format(0,2) }}</th>
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
