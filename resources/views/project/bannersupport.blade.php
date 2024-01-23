@extends('layouts.main')

@section('content')

<div class="container">
    <ul class="nav nav-pills mb-3 mt-5" id="pills-tab" role="tablist">
        <li class="nav-item" id="cashin-nav" role="presentation">
           <button class="nav-link bs-bs active" id="pills-home-tab" data-type="banner" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Banner</button>
         </li>
         <li class="nav-item" id="cashout-nav" role="presentation">
           <button class="nav-link bs-bs" id="pills-profile-tab" data-type="support" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Supports</button>
         </li>
         <li class="nav-item" id="cashout-nav" role="presentation">
          <button class="nav-link bs-bs" id="pills-get-tab" data-type="marque" data-bs-toggle="pill" data-bs-target="#pills-get" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Marquees</button>
        </li>
     </ul>
     <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
           <div class="col-md-12 mt-5">
            <div class="col-md-12">
                <button class="btn btn-success lucky-btn add-banner mb-2" style="float:right !important;">New Banner</button>
            </div>
            <table class="table table-striped display align-items-center mb-0 member-table yajra-datatable mt-5 w-100 tablee" cellspacing="0" style="width: 100%;" id="banner">
                <thead>
                    <tr>
                        <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Banner</th>
                        <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Created</th>
                        <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Tools</th>
                    </tr>
                </thead>
                <tbody>
        
                </tbody>
            </table>
           </div>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
           <div class="col-md-12 mt-5">
                <div class="col-md-12">
                    <button class="btn btn-success lucky-btn add-support mb-2" style="float:right !important;">New Support</button>
                </div>
                <table class="table table-striped display align-items-center mb-0 member-table mt-5 w-100 tablee" cellspacing="0" style="width: 100%; margin-top: 15px !important;" id="support">
                    <thead>
                        <tr>
                            <th class="text-secondary text-capitalizetext-xxs font-weight-bolder opacity-7">Name</th>
                            <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Image</th>
                            <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Body</th>
                            <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Created</th>
                            <th class="text-center text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Tools</th>
                        </tr>
                    </thead>
                    <tbody>
            
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-get" role="tabpanel" aria-labelledby="pills-get-tab">
          <div class="col-md-12 mt-5">
               <div class="col-md-12">
                   <button class="btn btn-success lucky-btn add-marque mb-2" style="float:right !important;">New Marquee</button>
               </div>
               <table class="table table-striped display align-items-center mb-0 member-table mt-5 w-100 tablee" cellspacing="0" style="width: 100%; margin-top: 15px !important;" id="marque">
                   <thead>
                       <tr>
                           <th class="text-secondary text-capitalize text-xxs font-weight-bolder opacity-7 ps-2">Body</th>
                           <th class="text-capitalize text-secondary text-xxs font-weight-bolder opacity-7">Created</th>
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

  <div class="modal fade" id="bannermodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="total-amt">Banner</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="banner-form">
            <div class="modal-body">
                <div class="form-group">
                    <input type="file" id="file" name="file" class="form-control" placeholder="Enter password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary float-right" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success lucky-btn float-right" id="bannerbtn">Yes,I will create.</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editbanner" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="total-amt">Banner</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="edit-banner-form">
            <div class="modal-body">
                <div class="form-group mb-2">
                    <input type="file" id="file" name="file" class="form-control">
                    <input type="text" class="bannerid" hidden>
                </div>
                <div class="form-group mt-5 text-center" style="text-align: center !important;">
                    <img src="" class="banner-img"  width="150" height="150" class="img-fluid mt-3">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary float-right" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success lucky-btn float-right" id="edit-bannerbtn">Yes,I will create.</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editsupport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="total-amt">Support</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="edit-support-form">
            <div class="modal-body">
                <div class="form-group">
                    <input type="file" id="file" name="file" class="form-control">
                    <input type="text" class="supportid" hidden>
                </div>
                <div class="form-group mt-3 text-center" style="text-align: center !important;">
                    <img src="" class="support-img" width="150" height="150">
                </div>
                <div class="form-group mt-3">
                    <input type="text" name="name" class="form-control supportname" placeholder="Enter name">
                </div>
                <div class="form-group mt-3">
                    <input type="text" name="body" class="form-control supportbody" placeholder="Enter body">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary float-right" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success lucky-btn float-right" id="edit-supportbtn">Yes,I will create.</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editmarque" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="total-amt">Marque</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="edit-marque-form">
            <div class="modal-body">
                <input type="text" class="marqueid" hidden>
                <div class="form-group mt-3">
                    <textarea name="body" rows="5" class="form-control marquebody" placeholder="Enter body"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary float-right" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success lucky-btn float-right" id="edit-supportbtn">Yes,I will create.</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="supportmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="total-amt">Support</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="support-form">
            <div class="modal-body">
                    <div class="form-group">
                        <input type="file" name="file" class="form-control">
                    </div>
                    <div class="form-group mt-3">
                        <input type="text" name="name" class="form-control" placeholder="Enter name">
                    </div>
                    <div class="form-group mt-3">
                        <input type="text" name="body" class="form-control" placeholder="Enter body">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary float-right" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success lucky-btn float-right" id="supportbtn">Yes,I will create.</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="marquemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="total-amt">Marquee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="marque-form">
            <div class="modal-body">
                <div class="form-group mt-3">
                    <textarea name="body" rows="5" class="form-control" placeholder="Enter body"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary float-right" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success lucky-btn float-right" id="marquebtn">Yes,I will create.</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@section('script')
<script src="../js_admin/bannersupport.js"></script>
@endsection
@endsection