@extends('backend.layouts.master')
@push('title')
    Sale Create
@endpush
@push('css')
    <link href="{{ asset('storage/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<div class="page-content">
    <div class="container-fluid mt-5">
        <div class="page-content-wrapper">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title m-0">Create Sale</h4>
                            <a href="{{ route('sales.index') }}" class="btn btn-sm btn-success waves-effect waves-light">
                                <i class="fas fa-file"></i> Sales
                            </a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('sales.store') }}" method="POST">
                                @csrf
                                <div class="row mb-2 ">
                                    <div class="col-12 col-md-4">
                                        <label for="customer_id" class="form-label">Customer Select <span class="text-danger">*</span></label>
                                        <select name="customer_id" id="customer_id" class="form-control form-control-sm" required>
                                            <option value="">Select Customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    data-name="{{ $customer->name }}"
                                                    data-phone="{{ $customer->phone }}">
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                     <div class="col-12 col-md-4">
                                        <label class="form-label">Customer Name</label>
                                        <input type="text"
                                            class="form-control form-control-sm"
                                            id="customer_name"
                                            readonly>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label class="form-label">Customer Phone</label>
                                        <input type="text"
                                            class="form-control form-control-sm"
                                            id="customer_phone"
                                            readonly>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 col-sm-6">
                                        <label for="order_date" class="form-label">Order Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control form-control-sm" id="order_date"
                                               name="order_date" required>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label for="delivery_date" class="form-label">Delivery Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control form-control-sm" id="delivery_date"
                                               name="delivery_date" required>
                                    </div>
                                </div>

                                <hr>

                                <div class="sale_wrapper my-4">
                                    <div class="row mb-2 align-items-end">
                                        <div class="col-6 col-md-4 col-lg-3 p-1">
                                            <label>Product <span class="text-danger">*</span></label>
                                            <select name="product_id[]" class="product_id form-control form-control-sm" required>
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                        {{ $product->name }}  {{ $product->unit?->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-6 col-md-2 col-lg-1 p-1">
                                            <label>Does</label>
                                            <input type="number" class="form-control form-control-sm" name="does_form[]" placeholder="Does">
                                        </div>

                                        <div class="col-6 col-md-2 col-lg-1 p-1">
                                            <label>Qty <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control form-control-sm" name="quantity[]" placeholder="Qty" required>
                                        </div>

                                        <div class="col-6 col-md-2 col-lg-1 p-1">
                                            <label>Bonus</label>
                                            <input type="number" class="form-control form-control-sm" name="bonus[]" placeholder="Bonus">
                                        </div>

                                        <div class="col-6 col-md-2 col-lg-1 p-1">
                                            <label>Price</label>
                                            <input type="number" class="form-control form-control-sm" name="price[]" placeholder="Price" required readonly>
                                        </div>

                                        <div class="col-6 col-md-2 col-lg-1 p-1">
                                            <label>Disc (%)</label>
                                            <input type="number" class="form-control form-control-sm" name="discount[]" placeholder="Discount">
                                        </div>

                                        <div class="col-6 col-md-3 col-lg-2 p-1">
                                            <label>Subtotal</label>
                                            <input type="number" class="form-control form-control-sm item_subtotal" name="subtotal[]" placeholder="Subtotal" readonly>
                                        </div>

                                        <div class="col-6 col-md-3 col-lg-1 p-1">
                                            <label>Facility</label>
                                            <input type="number" class="form-control form-control-sm" name="bonus_facility[]" placeholder="Facility">
                                        </div>

                                        <div class="col-12 col-md-3 col-lg-1 p-1">
                                            <button type="button" class="btn btn-sm btn-success w-100 add-item">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="sale_list"></div>
                                </div>

                                <div class="row my-2 d-flex justify-content-end">
                                    <div class="col-12 col-sm-3 d-flex justify-content-between align-items-center">
                                        <h6>Total Amount:</h6><h6 class="total_amount">0.00</h6>
                                    </div>
                                </div>
                                <div class="row my-2 d-flex justify-content-end">
                                    <div class="col-12 col-sm-3 d-flex justify-content-between align-items-center">
                                        <h6>Paid Amount:</h6><h6><input type="number" name="paid_amount" class="paid_amount form-control form-control-sm" required></h6>
                                    </div>
                                </div>
                                <div class="row my-2 d-flex justify-content-end">
                                    <div class="col-12 col-sm-3 d-flex justify-content-between align-items-center">
                                        <h6>Due Amount:</h6><h6 class="due_amount">0.00</h6>
                                    </div>
                                </div>


                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <button type="reset" class="btn btn-sm btn-secondary waves-effect waves-light"><i class="fas fa-sync-alt"></i> Reset</button>
                                    <button type="submit" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fas fa-save"></i> Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('storage/assets/libs/select2/js/select2.min.js') }}"></script>
<script>
$(document).ready(function() {

    // Initialize select2
    $('#customer_id').select2({ placeholder: "Select a customer", allowClear: true });
    $('.product_id').select2({ placeholder: "Select a product", allowClear: true });

    // Calculate subtotal per row and total
    function calculateTotal() {
        let total = 0;

        $('.sale_wrapper .row, .sale_list .row').each(function () {

            let qty      = parseFloat($(this).find('input[name="quantity[]"]').val()) || 0;
            let price    = parseFloat($(this).find('input[name="price[]"]').val()) || 0;
            let discount = parseFloat($(this).find('input[name="discount[]"]').val()) || 0;

            let subtotal = qty * price;

            if (discount > 0) {
                subtotal -= (subtotal * discount) / 100;
            }

            $(this).find('.item_subtotal').val(subtotal.toFixed(2));
            total += subtotal;
        });

        $('.total_amount').text(total.toFixed(2));

        // Calculate due amount
        let paid = parseFloat($('input[name="paid_amount"]').val()) || 0;
        let due  = total - paid;
        $('.due_amount').text(due.toFixed(2));
    }

    // Customer change
    $('#customer_id').on('change', function () {
        let opt = $(this).find(':selected');

        $('#customer_name').val(opt.data('name') || '');
        $('#customer_phone').val(opt.data('phone') || '');
    });

    // Calculate total on quantity/price change
    $(document).on(
        'input',
        'input[name="quantity[]"], input[name="price[]"], input[name="discount[]"]',
        function () {
            calculateTotal();
        }
    );

    $(document).on('input', 'input[name="paid_amount"]', function () {
        calculateTotal();
    });

    $(document).on('change', '.product_id', function () {
        let row   = $(this).closest('.row');
        let price = $(this).find(':selected').data('price') || 0;
        row.find('input[name="price[]"]').val(price);
        calculateTotal();
    });

    // Add new sale item
    $('.add-item').on('click', function () {
        let html = `
            <div class="row mb-2 align-items-end">
                <div class="col-6 col-md-4 col-lg-3 p-1">
                    <select name="product_id[]" class="product_id form-control form-control-sm" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->name }} {{ $product->unit?->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-2 col-lg-1 p-1">
                    <input type="number" class="form-control form-control-sm" name="does_form[]" placeholder="Does">
                </div>

                <div class="col-6 col-md-2 col-lg-1 p-1">
                    <input type="number" class="form-control form-control-sm" name="quantity[]" placeholder="Qty" required>
                </div>

                <div class="col-6 col-md-2 col-lg-1 p-1">
                    <input type="number" class="form-control form-control-sm" name="bonus[]" placeholder="Bonus">
                </div>

                <div class="col-6 col-md-2 col-lg-1 p-1">
                    <input type="number" class="form-control form-control-sm" name="price[]" placeholder="Price" required readonly>
                </div>

                <div class="col-6 col-md-2 col-lg-1 p-1">
                    <input type="number" class="form-control form-control-sm" name="discount[]" placeholder="Discount">
                </div>

                <div class="col-6 col-md-3 col-lg-2 p-1">
                    <input type="number" class="form-control form-control-sm item_subtotal" name="subtotal[]" placeholder="Subtotal" readonly>
                </div>

                <div class="col-6 col-md-3 col-lg-1 p-1">
                    <input type="number" class="form-control form-control-sm" name="bonus_facility[]" placeholder="Facility">
                </div>

                <div class="col-12 col-md-3 col-lg-1 p-1">
                    <button type="button" class="btn btn-sm btn-danger w-100 remove-item">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        $('.sale_list').append(html);
        $('.product_id').select2();
    });

    // Remove item
    $(document).on('click', '.remove-item', function () {
        $(this).closest('.row').remove();
        calculateTotal();
    });

    // Initial calculation
    calculateTotal();

});
</script>
@endpush
