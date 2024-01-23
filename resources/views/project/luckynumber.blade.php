@extends('layouts.main')

@section('content')
<div class="col-md-4 mb-4">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <input type="date" class="form-control date" value="{{ date('Y-m-d') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <button class="btn btn-secondary lucky-btn btn-block" id="date-search">Search</button>
            </div>
        </div>
    </div>
</div>
<table class="table align-items-center mb-0 member-table yajra-datatable w-100 tablee" id="lucky">
    <thead>
        <tr>
            <th class="text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
            <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Lucky Number</th>
            <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Section</th>
            <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Created</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
@section('script')
<script src="../js_admin/luckynumber.js"></script>
@endsection
@endsection