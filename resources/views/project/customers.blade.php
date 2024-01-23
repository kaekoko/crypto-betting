@extends('layouts.main')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h5 class="total_users title-head"></h5>
        <h5 class="total_amount title-head"></h5>
    </div>
    <div class="col-md-6">
        <button class="btn btn-success mb-4 n-agent lucky-btn customer-create"><i class="fa-solid fa-user-plus"></i>New Customer</button>
    </div>
</div>
<table class="table align-items-center mb-0 member-table yajra-datatable mt-5 w-100 tablee" id="customer">
    <thead>
        <tr>
            {{-- <th class="text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">ID</th> --}}
            <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Name</th>
            <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Phone</th>
            <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">T/Win</th>
            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Referal_code</th>
            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Tools</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<div class="modal fade" id="customercreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title-card-modal" id="exampleModalLabel">New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="customer-form">
                <div class="modal-body">
                        <div class="form-group">
                            <label class="label-black">First Name</label>
                            <input type="text" class="form-control mt-1" name="firstname" placeholder="Enter username">
                            <span class="badge bg-danger firstname-span mt-2"></span>
                        </div>
                        <div class="form-group mt-4">
                            <label class="label-black">Last Name</label>
                            <input type="text" class="form-control mt-1" name="lastname" placeholder="Enter username">
                            <span class="badge bg-danger lastname-span mt-2"></span>
                        </div>
                        <div class="form-group mt-4">
                        <label class="label-black">Phone No.</label>
                        <input type="text" class="form-control mt-1" name="msisdn" placeholder="eg.09xxxx">
                        <span class="badge bg-danger msisdn-span mt-2"></span>
                    </div>
                    <div class="form-group mt-4">
                        <label class="label-black">Agent's Referal Code</label>
                        <input type="number" name="referal_code" class="form-control mt-1" placeholder="Enter Agent's referal code">
                        <span class="badge bg-danger referal-span mt-2"></span>
                    </div>
                    <div class="form-group mt-4">
                        <label class="label-black" for="">Password</label>
                        <input type="password" name="password" class="form-control mt-1" placeholder="Enter password">
                        <span class="badge bg-danger password-span mt-2"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning lucky-btn" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary lucky-btn" id="add-customer"><i class="fa-solid fa-user-plus"></i>Add Agent</button>
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
            <form id="customer-update-form">
                <div class="modal-body">
                        <div class="form-group">
                            <label class="label-black">Username</label>
                            <input type="text" class="form-control mt-1" id="username" name="username" placeholder="Enter username">
                            <span class="badge bg-danger username-update-span mt-2"></span>
                        </div>
                        <div class="form-group mt-4">
                        <label class="label-black">Phone No.</label>
                        <input type="text" class="form-control mt-1" id="msisdn" name="msisdn" placeholder="eg.09xxxx">
                        <input type="text" class="customerid" hidden>
                        <span class="badge bg-danger msisdn-update-span mt-2"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning lucky-btn" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary lucky-btn" id="add-customer"><i class="fa-solid fa-user-plus"></i>Yes,I will update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="cashmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title-card-modal" id="exampleModalLabel">Cash</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills mb-3 cashin-nav" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                       <button class="nav-link bs-bs active" id="pills-home-tab" style="color: #000 !important;" data-type="banner" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Cash In</button>
                     </li>
                     <li class="nav-item" id="cashout-nav" role="presentation">
                       <button class="nav-link bs-bs" id="pills-profile-tab" style="color: #000 !important;" data-type="support" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Cash Out</button>
                     </li>
                 </ul>
                 <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                       <div class="col-md-12 mt-5">
                        <div class="form-group">
                            <input type="text" class="form-control" id="cashin-input" placeholder="Enter amount">
                        </div>
                        <div class="form-group mt-3">
                            <button class="btn btn-success lucky-btn" style="float:right !important;" id="cashinbtn">I will cash in</button>
                        </div>
                       </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="col-md-12 mt-5">
                            <div class="form-group">
                                <input type="text" class="form-control" id="cashout-input" placeholder="Enter amount">
                                <span class="badge bg-danger cashout-span"></span>
                            </div>
                            <div class="form-group mt-3">
                                <button class="btn btn-success lucky-btn" style="float:right !important;" id="cashoutbtn">I will cash out</button>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-warning lucky-btn" data-bs-dismiss="modal">Close</button>
            </div> --}}
        </div>
    </div>
</div>
@section('script')
<script src="../js_admin/customers.js"></script>
@endsection
@endsection