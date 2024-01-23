@extends('layouts.main')

@section('content')

<div class="col-md-10">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <input type="date" class="form-control from" value="{{ date('Y-m-d') }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <input type="date" class="form-control to" value="{{ date('Y-m-d') }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <select class="form-control" id="section-hist">
                    @foreach($sections as $section)
                        <option value="{{ $section->section }}">{{ date('h:i A', strtotime($section->section)) }}</option>
                    @endforeach
                    <option value="all">All Sections</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <button class="btn btn-success lucky-btn search-arrange">Search</button>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 mt-3 mb-3">
    <div class="total-statics">
        <button class="btn btn-light agent-com-a" disabled>Agennt Commission - 0</button>
        <button class="btn btn-light total-amt-a" disabled>Total Amount - 0</button>
        <button class="btn btn-light total-reward-a" disabled>Total Reward - 0</button>
        <button class="btn btn-light total-users-a" disabled>Total Users - 0</button>
        <button class="btn btn-light profit-a" disabled>Profit - 0</button>
    </div>
</div>
<table class="table align-items-center mb-0 member-table yajra-datatable mt-5 w-100 tablee" id="bet-histories">
    <thead>
        <tr>
            {{-- <th class="text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">ID</th> --}}
            <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Name</th>
            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Total Numbers</th>
            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Total Amounts</th>
            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Section</th>
            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Active</th>
            <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Lucky Number</th>
            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">View</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<div class="modal fade" id="arrnagedetailtable" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="total-amt">SLIPS DETAIL</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="col-md-12 mb-2">
            <h3 class="sample-text lucktext"></h3>
          </div>
          <div class="card table-card mt-2" id="arrangedetail">
            <div class="card-body">
              <table class="table align-items-center mb-0 member-table yajra-datatable w-100 tablee mt-5" id="arrange-detail-table">
                <thead>
                    <tr>
                        <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Name</th>
                        <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Number</th>
                        <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Amount</th>
                        <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Section</th>
                        <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                        <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Active</th>
                        <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Slip Created</th>
                    </tr>
                </thead>
                <tbody>
            
                </tbody>
            </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

@section('script')
<script src="../js_admin/bet.js"></script>
@endsection
@endsection