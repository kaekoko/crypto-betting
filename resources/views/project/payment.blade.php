@extends('layouts.main')

@section('content')
    <button class="btn btn-success mb-4 n-agent lucky-btn payment-create" style="margin-right: 10px;"><i class="fa-solid fa-money-check-dollar"></i>New Payment</button>
    <table class="table align-items-center mb-0 member-table yajra-datatable mt-5 w-100 tablee" id="payment">
        <thead>
            <tr>
                <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Name</th>
                <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Holder</th>
                <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Account No.</th>
                <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Logo</th>
                <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">C/In Status</th>
                <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">C/Out Status</th>
                <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Type</th>
                <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Tools</th>
            </tr>
    </thead>
        <tbody>

        </tbody>
    </table>

    <div class="modal fade" id="paymentcreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title title-card-modal" id="exampleModalLabel">New Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="payment-form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="label-black">Name</label>
                            <input type="text" class="form-control mt-1" name="name" placeholder="Enter name">
                            <span class="badge bg-danger name-span mt-2"></span>
                        </div>
                        <div class="form-group mt-4">
                            <label class="label-black">Holder</label>
                            <input type="text" class="form-control mt-1" name="holder" placeholder="Enter holder name">
                            <span class="badge bg-danger holder-span mt-2"></span>
                        </div>
                        <div class="form-group mt-4">
                            <label class="label-black">Account No.</label>
                            <input type="text" class="form-control mt-1" name="account_number" placeholder="Enter account number">
                            <span class="badge bg-danger account_number-span mt-2"></span>
                        </div>
                        <div class="form-group mt-4">
                            <label class="label-black">Type</label>
                            <select name="type" class="form-control mt-1 type-select">
                                <option value="mobile-pay">Mobile Pay</option>
                                <option value="banking">Banking</option>
                                <option value="billing">Phone Billing</option>
                        </select>
                        </div>
                        <div class="form-group mt-4 percent-input" hidden>
                            <label class="label-black">Bill Percent</label>
                           <input type="number" class="form-control mt-1" name="percent" value="0">
                        </div>
                        <div class="form-group mt-4">
                            <label class="label-black" for="">Logo</label>
                            <input type="file" name="logo" class="form-control mt-1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning lucky-btn" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary lucky-btn" id="add-payment"><i class="fa-solid fa-user-plus"></i>Add Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title title-card-modal" id="exampleModalLabel">Edit Agent Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="payment-update-form">
                    <div class="modal-body">
                            <div class="form-group">
                                <label class="label-black">Payment Name</label>
                                <input type="text" class="form-control mt-1" id="name" name="name" placeholder="Enter username">
                                <span class="badge bg-danger name-update-span mt-2"></span>
                            </div>
                            <div class="form-group mt-4">
                            <label class="label-black">Holder</label>
                            <input type="text" class="form-control mt-1" id="holder" name="holder" placeholder="eg.09xxxx">
                            <input type="text" class="paymentid" hidden>
                            <span class="badge bg-danger holder-update-span mt-2"></span>
                        </div>
                        <div class="form-group mt-4">
                            <label class="label-black">Account No.</label>
                            <input type="text" name="account_number" id="accountnumber" class="form-control mt-1">
                            <span class="badge bg-danger account-update-span mt-2"></span>
                        </div>
                        <div class="form-group mt-4">
                            <label class="label-black">Logo</label>
                            <input type="file" name="img" id="logo" class="form-control mt-1">
                            <input type="text" name="type" id="type" class="form-control mt-1" hidden>
                        </div>
                        <div class="form-group mt-4 bill-update" hidden>
                            <label class="label-black">Bill Percent</label>
                            <input type="number" name="percent" id="billpercent" class="form-control mt-1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning lucky-btn" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary lucky-btn" id="add-payment"><i class="fa-solid fa-user-plus"></i>Yes,I will update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@section('script')
<script src="../js_admin/payment.js"></script>
@endsection
@endsection