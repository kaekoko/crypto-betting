@extends('layouts.main')

@section('content')
<div class="container">
    <ul class="nav nav-pills mb-3 mt-5" id="pills-tab" role="tablist">
        <li class="nav-item" id="cashin-nav" role="presentation">
           <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Cash In</button>
         </li>
         <li class="nav-item" id="cashout-nav" role="presentation">
           <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Cash Out</button>
         </li>
     </ul>
     <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="col-md-12">
                <h5 class="total_cashin title-head"></h5>
            </div>
           <div class="col-md-12 mt-5">
            <table class="table table-striped display align-items-center mb-0 member-table yajra-datatable mt-5 w-100 tablee" cellspacing="0" style="width: 100%;" id="cashin">
                <thead>
                    <tr>
                        <th class="text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                        <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Name</th>
                        <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Credential</th>
                        <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Transaction</th>
                        <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Payment</th>
                        <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Amt</th>
                        <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">O/Amt</th>
                        <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">N/Amt</th>
                        <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                        <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                        <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Tools</th>
                    </tr>
                </thead>
                <tbody>
        
                </tbody>
            </table>
           </div>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="col-md-12">
                <h4 class="total_cashout title-head"></h4>
            </div>
           <div class="col-md-12 mt-5">
                <table class="table table-striped display align-items-center mb-0 member-table mt-5 w-100 tablee" cellspacing="0" style="width: 100%;" id="cashout">
                    <thead>
                        <tr>
                            <th class="text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                            <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Name</th>
                            <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Credential</th>
                            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Payment</th>
                            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Amt</th>
                            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">O/Amt</th>
                            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">N/Amt</th>
                            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Tools</th>
                        </tr>
                    </thead>
                    <tbody>
            
                    </tbody>
                </table>
            </div>
        </div>
        
     </div>
</div>

@section('script')
<script src="../js_admin/cash.js"></script>
@endsection
@endsection