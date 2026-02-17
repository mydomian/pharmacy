@extends('backend.layouts.master')

@push('title')
    Customer Payment
@endpush

@push('css')
    <link href="{{ asset('storage/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid mt-5">
            <div class="page-content-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                    Payment History — {{ $customer?->name }} ({{ $customer?->phone }})
                                </h4>
                            </div>

                            <div class="card-body">
                                <div style="width: 100%; overflow-x: auto;">

                                    <table id="datatable" class="table table-sm table-striped table-bordered"
                                        style="border-collapse: collapse; border-spacing: 0; ">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Sale ID</th>
                                                <th>Total</th>
                                                <th>Paid</th>
                                                <th>Due</th>
                                                <th>Last Payment Date</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php $sl = 1; $grandTotal = 0; $grandPaid = 0; $grandDue = 0; @endphp

                                            @forelse($payments as $saleId => $salePayments)
                                                @php
                                                    $total = $salePayments->first()->total;
                                                    $paid = $salePayments->sum('paid');
                                                    $due = $total - $paid;
                                                    $last = $salePayments->last();


                                                    $grandTotal += $total;
                                                    $grandPaid += $paid;
                                                    $grandDue += $due;
                                                @endphp

                                                <tr>
                                                    <td>{{ $sl++ }}</td>
                                                    <td><a href="{{ route('sales.show', $saleId) }}">#{{ $saleId }}</a>
                                                    </td>
                                                    <td>{{ number_format($total) }}</td>
                                                    <td>{{ number_format($paid) }}</td>
                                                    <td>{{ number_format($due) }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($last->payment_date)->format('d M Y') }}
                                                    </td>
                                                    <td class="d-flex justify-content-center align-items-center gap-2">
                                                        <a href="javascript:;" data-bs-toggle="modal"
                                                            data-bs-target="#paymentModal{{ $saleId }}"
                                                            class="btn btn-sm btn-primary waves-effect waves-light d-flex justify-content-center align-items-center gap-1"
                                                            title="Due Release Payment"><i class="fas fa-money-check"></i>
                                                            Due</a>
                                                        <a href="{{ route('sales.show', $saleId) }}"
                                                            class="btn btn-sm btn-info waves-effect waves-light d-flex justify-content-center align-items-center gap-1"
                                                            title="Sale View"><i class="fas fa-eye"></i> Sale</a>

                                                    </td>
                                                </tr>

                                                <!-- Modal -->
                                                <div class="modal fade" id="paymentModal{{ $saleId }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalScrollableTitle"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable">
                                                        <form action="{{ route('customers.releasePayment') }}" method="POST">
                                                            @csrf
                                                            <div class="modal-content">

                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">
                                                                        Payment History — Sale <a
                                                                            href="{{ route('sales.show', $saleId) }}">#{{ $saleId }}</a>
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"></button>
                                                                </div>

                                                                <!-- Modal Body -->
                                                                <div class="modal-body">

                                                                    <!-- Summary -->
                                                                    <div
                                                                        class="d-flex justify-content-between mb-3 p-3 bg-light  border rounded shadow">
                                                                        <div><strong>Total:</strong>
                                                                            {{ number_format($total) }}</div>
                                                                        <div><strong>Paid:</strong>
                                                                            {{ number_format($paid) }}</div>
                                                                        <div><strong>Due:</strong> <span
                                                                                class="text-danger">{{ number_format($due) }}</span>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Due Payment Form -->
                                                                    <div class="mb-4 p-3 bg-light border rounded shadow-sm">
                                                                        <h6 class="mb-3"><strong>Pay Due Amount</strong>
                                                                        </h6>


                                                                        <input type="hidden" name="sale_id"
                                                                            value="{{ $saleId }}">
                                                                        <input type="hidden" name="customer_id"
                                                                            value="{{ $customer->id }}">

                                                                        <div class="row g-3">
                                                                            <!-- Amount Input -->
                                                                            <div class="col-md-6">
                                                                                <label
                                                                                    for="paid_amount_{{ $saleId }}"
                                                                                    class="form-label">Amount to Pay</label>
                                                                                <input type="number" name="paid"
                                                                                    id="paid_amount_{{ $saleId }}"
                                                                                    class="form-control"
                                                                                    max="{{ $due }}"
                                                                                    min="1" required
                                                                                    placeholder="Enter paid amount" required>
                                                                            </div>

                                                                            <!-- Payment Date -->
                                                                            <div class="col-md-6">
                                                                                <label
                                                                                    for="payment_date_{{ $saleId }}"
                                                                                    class="form-label">Payment Date</label>
                                                                                <input type="date" name="payment_date"
                                                                                    id="payment_date_{{ $saleId }}"
                                                                                    class="form-control"
                                                                                    value="{{ date('Y-m-d') }}" required>
                                                                            </div>

                                                                            <!-- Payment Note -->
                                                                            <div class="col-12">
                                                                                <label for="note_{{ $saleId }}"
                                                                                    class="form-label">Note
                                                                                    (optional)</label>
                                                                                <textarea name="note" id="note_{{ $saleId }}" class="form-control" rows="2" placeholder="Add a note"></textarea>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <!-- Payment History -->
                                                                    <div class="payment-history">
                                                                        @foreach ($salePayments as $index => $payment)
                                                                            <div
                                                                                class="card mb-3 shadow-sm bg-light border-left-4 {{ $payment->payment_status == 'Due Payment' ? 'border-danger' : 'border-success' }}">
                                                                                <div class="card-body p-3">

                                                                                    <div
                                                                                        class="d-flex justify-content-between align-items-center mb-2">
                                                                                        <div>
                                                                                            <strong>Payment
                                                                                                #{{ $index + 1 }}</strong>
                                                                                        </div>
                                                                                        <div>
                                                                                            <span
                                                                                                class="badge {{ $payment->payment_status == 'Due Payment' ? 'bg-danger' : 'bg-success' }}">
                                                                                                {{ $payment->payment_status }}
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="row">
                                                                                        <div class="col-md-6 mb-2">
                                                                                            <strong>Paid:</strong>
                                                                                            {{ number_format($payment->paid) }}
                                                                                        </div>
                                                                                        <div class="col-md-6 mb-2">
                                                                                            <strong>Due After
                                                                                                Payment:</strong>
                                                                                            {{ number_format($payment->due) }}
                                                                                        </div>
                                                                                        <div class="col-md-6 mb-2">
                                                                                            <strong>Date:</strong>
                                                                                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                                                                                        </div>
                                                                                        <div class="col-md-6 mb-2">
                                                                                            <strong>Note:</strong>
                                                                                            {{ $payment->note ?? '-' }}
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>

                                                                </div>

                                                                <!-- Modal Footer -->
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-success">Submit
                                                                        Payment</button>
                                                                </div>

                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted">
                                                        No payment found
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2" class="text-end">Grand Total:</th>
                                                    <th>{{ number_format($grandTotal) }}</th>
                                                    <th>{{ number_format($grandPaid) }}</th>
                                                    <th>{{ number_format($grandDue) }}</th>
                                                    <th colspan="2"></th>
                                                </tr>
                                            </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('storage/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('storage/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                pageLength: 25,
                order: [
                    [1, 'desc']
                ]
            });
        });
    </script>
@endpush
