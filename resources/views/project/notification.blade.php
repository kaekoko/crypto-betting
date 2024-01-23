@extends('layouts.main')

@section('content')
<div class="container">
<button class="btn btn-success mb-4 n-agent lucky-btn notification-create"><i class="fa-solid fa-user-plus"></i>New Notification</button>
    <table class="table align-items-center mb-0 member-table yajra-datatable mt-5 w-100 tablee" id="notification">
        <thead>
            <tr>
                <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Title</th>
                <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Body</th>
                <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Created</th>
                <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Tools</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<div class="modal fade" id="notificationcreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title-card-modal" id="exampleModalLabel">New Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="notification-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="label-black">Title</label>
                        <input type="text" class="form-control mt-1" name="title" placeholder="Enter title">
                        <span class="badge bg-danger title-span mt-2"></span>
                    </div>
                    <div class="form-group mt-4">
                        <label class="label-black">Body</label>
                        <textarea name="body" class="form-control mt-1" id="" cols="30" rows="5"></textarea>
                        <span class="badge bg-danger body-span mt-2"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning lucky-btn" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary lucky-btn" id="add-customer"><i class="fa-solid fa-user-plus"></i>Add Notification</button>
                </div>
            </form>
        </div>
    </div>
</div>
@section('script')
<script src="../js_admin/notification.js"></script>
@endsection
@endsection