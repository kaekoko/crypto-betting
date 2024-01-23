@extends('layouts.main')

@section('content')

<form id="setting-form">
   <h3 class="title-head">Youtube Link</h3>
   <div class="container mt-4">
      <div class="row">
         <div class="col-md-6">
            <label for="" class="label">Cash In Link</label>
            <input type="text" class="form-control mt-2" value="{{ $setting->in_link }}" name="in_link" placeholder="Enter url">
         </div>
         <div class="col-md-6">
            <label for="" class="label">Cash Out Link</label>
            <input type="text" class="form-control mt-2" value="{{ $setting->out_link }}" name="out_link" placeholder="Enter url">
         </div>
      </div>
      <div class="dropdown-divider mt-4 divide"></div>
      <div class="row mt-2">
         @foreach($sections as $key => $section)
         <div class="col-md-6 text-center mt-4">
            <div class="form-group">
               <h3 class="title-head">{{ date('h:i A', strtotime($section->section)) }}</h3>
               <input type="text" name="section_{{ $section->id }}" value="{{ $section->id }}" hidden>
            </div>
            <div class="row mt-5">
               <div class="col-md-6">
                  <label for="" class="label">Close Start Time</label>
                  <input type="time" name="{{ $section->id }}_close_start" class="form-control mt-2" value="{{ date('H:i', strtotime($section->close_start_time)) }}">
               </div>
               <div class="col-md-6">
                  <label for="" class="label">Close End Time</label>
                  <input type="time" name="{{ $section->id }}_close_end" class="form-control mt-2" value="{{ date('H:i', strtotime($section->close_end_time)) }}">
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </div>
   <div class="dropdown-divider mt-4 divide"></div>
   <h3 class="title-head">2D</h3>
   <div class="container mt-4">
      <div class="row">
         <div class="col-md-3">
            <label for="" class="label">Min Amount</label>
            <input type="text" class="form-control mt-2" value="{{ $setting->min_amount }}" name="min_amount" placeholder="Enter min amount">
         </div>
         <div class="col-md-3">
            <label for="" class="label">Max Amount</label>
            <input type="text" class="form-control mt-2" value="{{ $setting->max_amount }}"  name="max_amount" placeholder="Enter max amount">
         </div>
         <div class="col-md-3">
            <label for="" class="label">Multiply</label>
            <input type="text" class="form-control mt-2" value="{{ $setting->odd }}" name="odd" placeholder="Enter multiply odd">
         </div>
         <div class="col-md-3">
            <label for="" class="label">Over All Amount</label>
            <input type="text" class="form-control mt-2" value="{{ $setting->overall_amount }}" name="overall_amount" placeholder="Enter overall amount">
         </div>
      </div>
      <div class="dropdown-divider mt-4 divide"></div>
      <div class="row mt-2">
         @foreach($sections as $key => $section)
         <div class="col-md-6 text-center mt-4">
            <div class="form-group">
               <h3 class="title-head">{{ date('h:i A', strtotime($section->section)) }}</h3>
               <input type="text" name="section_{{ $section->id }}" value="{{ $section->id }}" hidden>
            </div>
            <div class="row mt-5">
               <div class="col-md-6">
                  <label for="" class="label">Close Start Time</label>
                  <input type="time" name="{{ $section->id }}_close_start" class="form-control mt-2" value="{{ date('H:i', strtotime($section->close_start_time)) }}">
               </div>
               <div class="col-md-6">
                  <label for="" class="label">Close End Time</label>
                  <input type="time" name="{{ $section->id }}_close_end" class="form-control mt-2" value="{{ date('H:i', strtotime($section->close_end_time)) }}">
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </div>
   <div class="dropdown-divider mt-4 divide"></div>
   <h3 class="title-head">Version Setting</h3>
   <div class="container mt-5">
      <div class="row">
         <div class="col-md-4">
            <label for="" class="label">Title</label>
            <textarea name="title" value="{{ $setting->title }}" class="form-control mt-2" id="" cols="30" rows="2">{{ $setting->title }}</textarea>
         </div>
         <div class="col-md-4">
            <label for="" class="label">Description</label>
            <textarea name="description" value="{{ $setting->description }}" class="form-control mt-2" id="" cols="30" rows="2">{{ $setting->description }}</textarea>
         </div>
         <div class="col-md-4">
            <label for="" class="label">Version Code</label>
            <input name="version_code" value="{{ $setting->version_code }}" class="form-control mt-2">
         </div>
         <div class="col-md-4 mt-4">
            <label for="" class="label">Version Name</label>
            <input name="version_name" value="{{ $setting->version_name }}" class="form-control mt-2">
         </div>
         <div class="col-md-4 mt-4">
            <div class="switch text-center">
               <p class="label">Foce Update</p>
               <input name="force_update" type="checkbox" class="togg" id="forceupdate" @if($setting->force_update == 1) checked @endif>
               <label for="forceupdate"><i></i></label>
         </div>
         </div>
      </div>
   </div>
   <div class="dropdown-divider mt-4 divide"></div>
   <h3 class="title-head">Version Setting Crypto</h3>
   <div class="container mt-5">
      <div class="row">
         <div class="col-md-4">
            <label for="" class="label">Title</label>
            <textarea name="title_crypto" value="{{ $setting->title_crypto }}" class="form-control mt-2" id="" cols="30" rows="2">{{ $setting->title_crypto }}</textarea>
         </div>
         <div class="col-md-4">
            <label for="" class="label">Description</label>
            <textarea name="description_crypto" value="{{ $setting->description_crypto }}" class="form-control mt-2" id="" cols="30" rows="2">{{ $setting->description_crypto }}</textarea>
         </div>
         <div class="col-md-4">
            <label for="" class="label">Version Code</label>
            <input name="version_code_crypto" value="{{ $setting->version_code_crypto }}" class="form-control mt-2">
         </div>
         <div class="col-md-4 mt-4">
            <label for="" class="label">Version Name</label>
            <input name="version_name_crypto" value="{{ $setting->version_name_crypto }}" class="form-control mt-2">
         </div>
         <div class="col-md-4 mt-4">
            <div class="switch text-center">
               <p class="label">Foce Update</p>
               <input name="force_update_crypto" type="checkbox" class="togg" id="forceupdate_crypto" @if($setting->force_update_crypto == 1) checked @endif>
               <label for="forceupdate_crypto"><i></i></label>
         </div>
         </div>
      </div>
   </div>
   <div class="col-md-12 mt-4">
      <div class="form-group">
         <button class="btn btn-success text-right update-btn lucky-btn">
            <i class="fa-solid fa-wrench"></i> Update Setting
         </button>
      </div>
   </div>
</form>
@section('script')
<script src="../js_admin/setting.js"></script>
@endsection
@endsection