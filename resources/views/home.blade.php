@extends('layouts.main')

@section('content')
<div class="container">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        @foreach($sections as $key => $section)
          @if($key == 0)
            <li class="nav-item" role="presentation">
              <button class="nav-link section-link starter active" data-id="{{ $section->id }}" data-section="{{ date('h:i A', strtotime($section->section)) }}" id="pills-{{ $section->id }}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{ $section->id }}" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{ date('h:i A', strtotime($section->section)) }}</button>
            </li>
          @else
          <li class="nav-item" role="presentation">
            <button class="nav-link section-link" id="pills-{{ $section->id }}-tab" data-id="{{ $section->id }}" data-section="{{ date('h:i A', strtotime($section->section)) }}" data-bs-toggle="pill" data-bs-target="#pills-{{ $section->id }}" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{ date('h:i A', strtotime($section->section)) }}</button>
          </li>
          @endif
        @endforeach
      </ul>
      <div class="tab-content" id="pills-tabContent">
        @foreach($sections as $key => $section)
          @if($key == 0)
          <div class="tab-pane fade show active" id="pills-{{ $section->id }}" role="tabpanel" aria-labelledby="pills-home-tab">
              <div class="col-md-12">
                <button class="btn btn-light agent-com" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}" disabled>Agent Commission - 0</button>
                <button class="btn btn-light total-amt" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}" disabled>Total Amount - 0</button>
                <button class="btn btn-light total-reward" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}" disabled>Total Reward - 0</button>
                <button class="btn btn-light total-users" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}" disabled>Total Users - 0</button>
                <button class="btn btn-light profit" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}" disabled>Profit - 0</button>
                <button class="btn btn-danger lknumber mt-2">--</button>
              </div>
              <div class="col-md-12 mt-4">
                <button class="btn btn-success lucky-btn clear-section" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}">Clearance</button>
                <button class="btn btn-success lucky-btn refund-section" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}">Refund</button>
                <button class="btn btn-success lucky-btn slips" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}">Slips</button>
                <button class="btn btn-success lucky-btn multiple" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}">Multiple Define Amount</button>
                <button class="btn btn-success lucky-btn hotamounts" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}">Hot Amounts</button>
                <button class="btn btn-success lucky-btn blocknumbers" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}">Block Numbers</button>
                {{-- <button class="btn btn-success lucky-btn winners" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}">Winners</button> --}}
              </div>
              <div class="row numbers-{{ $section->id }} text-center mt-2">
              </div>
          </div>
          @else 
          <div class="tab-pane fade" id="pills-{{ $section->id }}" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="col-md-12">
              <button class="btn btn-light agent-com" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}" disabled>Agent Commission - 0</button>
              <button class="btn btn-light total-amt" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}" disabled>Total Amount - 0</button>
              <button class="btn btn-light total-reward" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}" disabled>Total Reward - 0</button>
              <button class="btn btn-light total-users" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}" disabled>Total Users - 0</button>
              <button class="btn btn-light profit" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}" disabled>Profit - 0</button>
              <button class="btn btn-danger lknumber mt-2">-</button>
            </div>
            <div class="col-md-12 mt-4">
              <button class="btn btn-success lucky-btn clear-section" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}">Clearance</button>
              <button class="btn btn-success lucky-btn refund-section" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}">Refund</button>
              <button class="btn btn-success lucky-btn slips" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}">Slips</button>
              <button class="btn btn-success lucky-btn multiple" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}">Multiple Define Amount</button>
              <button class="btn btn-success lucky-btn hotamounts" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}">Hot Amounts</button>
              <button class="btn btn-success lucky-btn blocknumbers" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}">Block Numbers</button>
              {{-- <button class="btn btn-success lucky-btn winners" data-section="{{ $section->section }}" date-sectionid="{{ $section->id }}">Winners</button> --}}
            </div>
            <div class="row numbers-{{ $section->id }} text-center mt-2">
            </div>
          </div>
          @endif
        @endforeach
      </div>
</div>

<div class="modal fade" id="definemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="total-amt"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <h5 class="modal-title mb-1" id="hotamt"></h5>
          <ul class="list-group mt-3" id="currentuserslips">
          </ul>
        <p class="text nodata" hidden></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="clearancemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="total-amt">Clearance Section</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <div class="form-group">
            <input type="password" id="password" class="form-control" placeholder="Enter password">
            <span class="badge bg-danger clear-span"></span>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success lucky-btn" id="clearsection">Yes,I will clear this section.</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="multiplemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="total-amt">Multiple Define Amounts</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <input type="text" id="sectionname" hidden>
      <form id="multiple-hot-form">
          <div class="modal-body">
            <h3>Hot Amount</h3>
            <div class="form-group">
                <input type="text" name="numbers" class="form-control" placeholder="Enter numbers eg. 22,24,56,67,65">
            </div>
            <div class="form-group mt-2">
              <input type="text" name="hot_amount" class="form-control" placeholder="Enter hot amount">
            </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-success lucky-btn" id="multiplebtn">Yes,I will create</button>
          </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="refundmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="total-amt">Refund Section</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <div class="form-group">
            <input type="password" id="refund-password" class="form-control" placeholder="Enter password">
            <span class="badge bg-danger refund-span"></span>
         </div>
         <div class="form-group mt-2">
          <span class="badge bg-danger spantxt">သတိထားရန် - ထိုးထားသော စာရင်းများ ပျက်သွားမည် ဖြစ်ပြီး ထိုးငွေများ 
            <br>
             customer တစ်ယောက် ချင်းစီပြန်ရောက်သွားမည်ဖြစ်သည်။
            </span>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success lucky-btn" id="refundsection">Yes,I will refund this section.</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="slipmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="total-amt">Current Section Slips</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card table-card" id="sliptablecard">
          <div class="card-body">
            <table class="table align-items-center mb-0 member-table yajra-datatable mt-5 w-100 tablee" id="slip-table">
              <thead>
                  <tr>
                      <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Name</th>
                      <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Total Numbers</th>
                      <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Total Amounts</th>
                      <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Section</th>
                      <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                      <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Active</th>
                      <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Slip Created</th>
                      <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">View</th>
                  </tr>
              </thead>
              <tbody>
          
              </tbody>
            </table>
          </div>
        </div>
        <div class="card table-card" id="slipdetail" hidden>
          <div class="card-body">
            <table class="table align-items-center mb-0 member-table yajra-datatable mt-5 w-100 tablee" id="slip-detail-table">
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
            <div class="form-group">
                <button class="btn btn-success lucky-btn" style="float:right !important;" id="backsliptable">Back</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="hotmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="total-amt">Hot Amounts</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card table-card">
          <div class="card-body">
            <table class="table align-items-center mb-0 member-table yajra-datatable mt-5 w-100 tablee" id="hot-table">
              <thead>
                  <tr>
                      <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Number</th>
                      <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Amount</th>
                      <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Section</th>
                      <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Tools</th>
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
<div class="modal fade" id="winnermodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="total-amt">Winners</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card table-card">
          <div class="card-body">
            <table class="table align-items-center mb-0 member-table yajra-datatable mt-5 w-100 tablee" id="winner-table">
              <thead>
                  <tr>
                      <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Name</th>
                      <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Number</th>
                      <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Amount</th>
                      <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Reward</th>
                      <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>
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
<div class="modal fade" id="blockmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="total-amt">Block Numbers</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card table-card">
          <div class="card-body">
            <table class="table align-items-center mb-0 member-table yajra-datatable mt-5 w-100 tablee" id="block-table">
              <thead>
                  <tr>
                      <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Number</th>
                      <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Section</th>
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
<script src="../js_admin/dashboard.js"></script>
@endsection
@endsection
