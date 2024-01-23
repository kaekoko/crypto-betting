@extends('layouts.main')

@section('content')
<button class="btn btn-success mb-4 n-agent lucky-btn block-create ml-2" style="margin-right: 10px !important;"><i class="fa-solid fa-file-circle-plus"></i>New Block Number</button>
<button class="btn btn-success mb-4 n-agent lucky-btn block-multiple mr-2" style="margin-right: 10px !important;"><i class="fa-solid fa-file-circle-plus"></i>Multiple Block Number</button>
<table class="table align-items-center mb-0 member-table yajra-datatable mt-5 w-100 tablee" id="blocknumber">
    <thead>
        <tr>
            <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Block Number</th>
            <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Section</th>
            <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
            <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Tools</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<div class="modal fade" id="blockcreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title-card-modal" id="exampleModalLabel">New Block Number</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="block-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="label-black">Number</label>
                        <input type="number" class="form-control mt-1" name="number" placeholder="Enter number">
                        <span class="badge bg-danger number-span mt-2"></span>
                    </div>
                    <div class="form-group mt-4">
                        <label class="label-black">Date</label>
                        <input type="date" class="form-control mt-1" name="date" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group mt-4">
                        <label class="label-black">Section</label>
                        <select name="section" class="form-control mt-1" id="section">
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}">{{ date('h:i A', strtotime($section->section)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning lucky-btn" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary lucky-btn" id="add-block"><i class="fa-solid fa-user-plus"></i>Add Block Number</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="multiplemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title-card-modal" id="exampleModalLabel">Multiple Block Number</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="multiple-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="label-black">Number</label>
                        <input type="text" class="form-control mt-1" name="numbers" placeholder="Enter number">
                        <span class="badge bg-danger number-span mt-2"></span>
                    </div>
                    <div class="form-group mt-4">
                        <label class="label-black">Date</label>
                        <input type="date" class="form-control mt-1" name="date" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group mt-4">
                        <label class="label-black">Section</label>
                        <select name="section" class="form-control mt-1" id="section">
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}">{{ date('h:i A', strtotime($section->section)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning lucky-btn" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary lucky-btn" id="add-multiple"><i class="fa-solid fa-user-plus"></i>Add Block Number</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title-card-modal" id="exampleModalLabel">Edit Block Number</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="block-update-form">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="label-black">Number</label>
                        <input type="number" class="form-control mt-1" id="b-number" name="number" placeholder="Enter number">
                        <input type="text" class="form-control mt-1 blockid" hidden>
                        <span class="badge bg-danger username-update-span mt-2"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning lucky-btn" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary lucky-btn" id="add-block"><i class="fa-solid fa-user-plus"></i>Yes, I will update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@section('script')
<script src="../js_admin/blocknumber.js"></script>
@endsection
@endsection