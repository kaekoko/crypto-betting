@extends('layouts.main')

@section('content')
    <div class="row mb-4">
        <div class="col-md-6">
            <h5 class="total_agents title-head"></h5>
            <h5 class="total_amount title-head"></h5>
        </div>
        <div class="col-md-6">
            <button class="btn btn-success mb-4 n-agent lucky-btn agent-create"><i class="fa-solid fa-user-plus"></i>New Agent</button>
        </div>
    </div>
    <table class="table align-items-center mb-0 member-table yajra-datatable w-100 tablee" id="agent">
        <thead>
            <tr>
                <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Name</th>
                <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Phone</th>
                <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Percentage</th>
                <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Referal_code</th>
                <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
                <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Tools</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

<div class="modal fade" id="agentcreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title-card-modal" id="exampleModalLabel">New Agent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="agent-form">
                <div class="modal-body">
                        <div class="form-group">
                            <label class="label-black">Username</label>
                            <input type="text" class="form-control mt-1" name="username" placeholder="Enter username">
                            <span class="badge bg-danger username-span mt-2"></span>
                        </div>
                        <div class="form-group mt-4">
                        <label class="label-black">Phone No.</label>
                        <input type="text" class="form-control mt-1" name="msisdn" placeholder="eg.09xxxx">
                        <span class="badge bg-danger msisdn-span mt-2"></span>
                    </div>
                    <div class="form-group mt-4">
                        <label class="label-black">Percent</label>
                        <input type="number" value="0" name="percentage" class="form-control mt-1">
                    </div>
                    <div class="form-group mt-4">
                        <label class="label-black" for="">Password</label>
                        <input type="password" name="password" class="form-control mt-1" placeholder="Enter password">
                        <span class="badge bg-danger password-span mt-2"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning lucky-btn" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary lucky-btn" id="add-agent"><i class="fa-solid fa-user-plus"></i>Add Agent</button>
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
            <form id="agent-update-form">
                <div class="modal-body">
                        <div class="form-group">
                            <label class="label-black">Username</label>
                            <input type="text" class="form-control mt-1" id="username" name="username" placeholder="Enter username">
                            <span class="badge bg-danger username-update-span mt-2"></span>
                        </div>
                        <div class="form-group mt-4">
                        <label class="label-black">Phone No.</label>
                        <input type="text" class="form-control mt-1" id="msisdn" name="msisdn" placeholder="eg.09xxxx">
                        <input type="text" class="agentid" hidden>
                        <span class="badge bg-danger msisdn-update-span mt-2"></span>
                    </div>
                    <div class="form-group mt-4">
                        <label class="label-black">Percent</label>
                        <input type="number" name="percentage" id="percentage" class="form-control mt-1">
                        <span class="badge bg-danger percentage-update-span mt-2"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning lucky-btn" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary lucky-btn" id="add-agent"><i class="fa-solid fa-user-plus"></i>Yes,I will update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="cashout-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title-card-modal" id="exampleModalLabel">Cash Out Agent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="label-black">Balance</label>
                    <p class="sample-text agent-balance"></p>
                </div>
                <hr>
                <div class="form-group">
                    <label class="label-black">Amount</label>
                    <input type="text" class="form-control mt-1" id="cashoutamount" name="amount" placeholder="Enter amount">
                    <span class="badge bg-danger cashout-span"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning lucky-btn" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary lucky-btn" id="cashout-agent"><i class="fa-solid fa-user-plus"></i>Yes,I will update</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cashout-detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="total-amt">Cash Out Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="card table-card">
            <div class="card-body">
              <table class="table align-items-center mb-0 member-table yajra-datatable mt-5 w-100 tablee" id="cashout-detail-table">
                <thead>
                    <tr>
                        <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Amount</th>
                        <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Old Amount</th>
                        <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">New Amount</th>
                        <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
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
<script src="../js_admin/agent.js"></script>
@endsection
@endsection