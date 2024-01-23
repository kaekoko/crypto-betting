$(function(){
  var token = $('#token').val();

  $('.add-banner').on('click', function(){
    $('#bannermodal').modal('show');
  })

  $('.add-support').on('click', function(){
    $('#supportmodal').modal('show');
  })

  $('.add-marque').on('click', function(){
    $('#marquemodal').modal('show');
  })

  $('.bs-bs').on('click', function(){
    if($(this).attr('data-type') == 'banner'){
        tablebs('banner');
    } else if($(this).attr('data-type') == 'marque') {
        tablebs('marque')
    } else {
      tablebs('support')
    }
  })

  tablebs('banner');

  function tablebs(type){
    if(type == 'banner'){
        $('#banner').dataTable().fnDestroy();
        $('#banner').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "get_banners",
            columns: [
                // {data: 'id', name: 'id'},
                {data: 'img', name: 'img'},
                {data: 'created_at', name: 'created_at'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: true, 
                    searchable: true
                },
            ],
            columnDefs: [
                {
                    "targets": [ 0 ],
                        render: function(data, type, row) {
                        return '<img src="../storage/banners/'+ data +'" width="150" height="150">'
                    },
                },
                {
                    "targets": [ 1 ],
                        render: function(data, type, row) {
                            return moment(data).format('MM-DD-YYYY')
                    },
                },
            ], 
        });
    }  else if(type == 'marque'){
      $('#marque').dataTable().fnDestroy();
      $('#marque').DataTable({
          processing: true,
          serverSide: true,
          responsive: true,
          ajax: "get_marques",
          columns: [
              // {data: 'id', name: 'id'},
              {data: 'body', name: 'body'},
              {data: 'created_at', name: 'created_at'},
              {
                  data: 'action', 
                  name: 'action', 
                  orderable: true, 
                  searchable: true
              },
          ],
          columnDefs: [
              {
                  "targets": [ 1 ],
                      render: function(data, type, row) {
                          return moment(data).format('MM-DD-YYYY')
                  },
              },
          ], 
      });
    } else {
        $('#support').dataTable().fnDestroy();
        $('#support').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "get_supports",
            columns: [
                // {data: 'id', name: 'id'},
                {data: 'img', name: 'img'},
                {data: 'name', name: 'name'},
                {data: 'body', name: 'body'},
                {data: 'created_at', name: 'created_at'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: true, 
                    searchable: true
                },
            ],
            columnDefs: [
                {
                    "targets": [ 0 ],
                        render: function(data, type, row) {
                        return '<img src="../storage/supports/'+ data +'" width="150" height="150">'
                    },
                },
                {
                    "targets": [ 3 ],
                        render: function(data, type, row) {
                            return moment(data).format('MM-DD-YYYY')
                    },
                },
            ], 
        });
    }
  }

  $('#banner-form').on('submit', function(e){
    e.preventDefault();
    console.log('s');
    var formData = new FormData(this); // Currently empty
    $.ajax({
        url: "create-banner",
        method: "POST",
        headers:{
            'X-CSRF-TOKEN' : token
        },
        data:formData,
        processData: false,
        contentType: false,
        success:function(data){
            $('#bannermodal').modal('hide');
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2500,
                background: '#ecca6e',
                iconColor: '#000',
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              })
              
              Toast.fire({
                icon: 'success',
                title: 'Banner created successfully'
              })
            const table = $("#banner").DataTable();
            table.ajax.reload();
        }
    })
  })

  $(document).on('click','.edit-banner', function(){
    $('#editbanner').modal('show');
    $('.bannerid').val($(this).attr('id'));
    $('.banner-img').attr('src', '../storage/banners/' + $(this).attr('data-img'))
  })

  $(document).on('click','.edit-support', function(){
    $('#editsupport').modal('show');
    $('.supportid').val($(this).attr('id'));
    $('.support-img').attr('src', '../storage/supports/' + $(this).attr('data-img'))
    $('.supportname').val($(this).attr('data-name'))
    $('.supportbody').val($(this).attr('data-body'))
  })

  $(document).on('click','.edit-marque', function(){
    $('#editmarque').modal('show');
    $('.marqueid').val($(this).attr('id'));
    $('.marquebody').val($(this).attr('data-body'))
  })

  $('#edit-banner-form').on('submit', function(e){
    e.preventDefault();
    console.log('sd');
    var formData = new FormData(this); // Currently empty
    var id = $('.bannerid').val();
    $.ajax({
        url: "edit-banner/" + id,
        method: "POST",
        headers:{
            'X-CSRF-TOKEN' : token
        },
        data:formData,
        processData: false,
        contentType: false,
        success:function(data){
            $('#editbanner').modal('hide');
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2500,
                background: '#ecca6e',
                iconColor: '#000',
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              })
              
              Toast.fire({
                icon: 'success',
                title: 'Banner updated successfully'
              })
            const table = $("#banner").DataTable();
            table.ajax.reload();
        }
    })
  })

  $('#edit-marque-form').on('submit', function(e){
    e.preventDefault();
    console.log('sd');
    var formData = new FormData(this); // Currently empty
    var id = $('.marqueid').val();
    $.ajax({
        url: "edit-marque/" + id,
        method: "POST",
        headers:{
            'X-CSRF-TOKEN' : token
        },
        data:formData,
        processData: false,
        contentType: false,
        success:function(data){
            $('#editmarque').modal('hide');
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2500,
                background: '#ecca6e',
                iconColor: '#000',
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              })
              
              Toast.fire({
                icon: 'success',
                title: 'Marque updated successfully'
              })
            const table = $("#marque").DataTable();
            table.ajax.reload();
        }
    })
  })


  $('#support-form').on('submit', function(e){
    e.preventDefault();
    var formData = new FormData(this); // Currently empty
    $.ajax({
        url: "create-support/",
        method: "POST",
        headers:{
            'X-CSRF-TOKEN' : token
        },
        data:formData,
        processData: false,
        contentType: false,
        success:function(data){
            $('#supportmodal').modal('hide');
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2500,
                background: '#ecca6e',
                iconColor: '#000',
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              })
              
              Toast.fire({
                icon: 'success',
                title: 'Support created successfully'
              })
            const table = $("#support").DataTable();
            table.ajax.reload();
        }
    })
  })

  $('#marque-form').on('submit', function(e){
    e.preventDefault();
    var formData = new FormData(this); // Currently empty
    $.ajax({
        url: "create-marque/",
        method: "POST",
        headers:{
            'X-CSRF-TOKEN' : token
        },
        data:formData,
        processData: false,
        contentType: false,
        success:function(data){
            $('#marquemodal').modal('hide');
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2500,
                background: '#ecca6e',
                iconColor: '#000',
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              })
              
              Toast.fire({
                icon: 'success',
                title: 'Marque created successfully'
              })
            const table = $("#marque").DataTable();
            table.ajax.reload();
        }
    })
  })

  $('#edit-support-form').on('submit', function(e){
    e.preventDefault();
    var formData = new FormData(this); // Currently empty
    var id = $('.supportid').val();
    $.ajax({
        url: "edit-support/" + id,
        method: "POST",
        headers:{
            'X-CSRF-TOKEN' : token
        },
        data:formData,
        processData: false,
        contentType: false,
        success:function(data){
            $('#editsupport').modal('hide');
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2500,
                background: '#ecca6e',
                iconColor: '#000',
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              })
              
              Toast.fire({
                icon: 'success',
                title: 'Support updated successfully'
              })
            const table = $("#support").DataTable();
            table.ajax.reload();
        }
    })
  })

  $(document).on('click','.delete_banner', function(){
    var id = $(this).attr('id');
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ecca6e',
            cancelButtonColor: '#d33',
            confirmButtonTextColor: '#000',
            confirmButtonText: 'Yes, Delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "delete-banner/" + id,
                    method: "POST",
                    headers:{
                        'X-CSRF-TOKEN' : token
                    },
                    success:function(data){
                        if(data.message == 'success'){
                            const table = $("#banner").DataTable();
                            table.ajax.reload();
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2500,
                                background: '#ecca6e',
                                iconColor: '#000',
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                  toast.addEventListener('mouseenter', Swal.stopTimer)
                                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                              })
                              
                              Toast.fire({
                                icon: 'success',
                                title: 'Banner deleted successfully'
                              })
                        }
                    }
                })
            }
          })
  })

  $(document).on('click','.delete_support', function(){
    var id = $(this).attr('id');
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ecca6e',
            cancelButtonColor: '#d33',
            confirmButtonTextColor: '#000',
            confirmButtonText: 'Yes, Delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "delete-support/" + id,
                    method: "POST",
                    headers:{
                        'X-CSRF-TOKEN' : token
                    },
                    success:function(data){
                        if(data.message == 'success'){
                            const table = $("#support").DataTable();
                            table.ajax.reload();
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2500,
                                background: '#ecca6e',
                                iconColor: '#000',
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                  toast.addEventListener('mouseenter', Swal.stopTimer)
                                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                              })
                              
                              Toast.fire({
                                icon: 'success',
                                title: 'Support deleted successfully'
                              })
                        }
                    }
                })
            }
          })
  })

  $(document).on('click','.delete_marque', function(){
    var id = $(this).attr('id');
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ecca6e',
            cancelButtonColor: '#d33',
            confirmButtonTextColor: '#000',
            confirmButtonText: 'Yes, Delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "delete-marque/" + id,
                    method: "POST",
                    headers:{
                        'X-CSRF-TOKEN' : token
                    },
                    success:function(data){
                        if(data.message == 'success'){
                            const table = $("#marque").DataTable();
                            table.ajax.reload();
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2500,
                                background: '#ecca6e',
                                iconColor: '#000',
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                  toast.addEventListener('mouseenter', Swal.stopTimer)
                                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                              })
                              
                              Toast.fire({
                                icon: 'success',
                                title: 'Marque deleted successfully'
                              })
                        }
                    }
                })
            }
          })
  })
})