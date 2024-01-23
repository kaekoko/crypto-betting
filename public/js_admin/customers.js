$(function () {
    $('.sidebar-toggle')[0].click();

    var token = $('#token').val();
    total();
    $('#customer').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "get_customers",
        columns: [
            // {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'msisdn', name: 'msisdn'},
            {data: 'status', name: 'status'},
            {data: 'total_win', name: 'total_win'},
            {data: 'amount', name: 'amount'},
            {data: 'referal_code', name: 'referxal_code'},
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
                "targets": [ 6 ],
                    render: function(data, type, row) {
                    return moment(data).format('MM-DD-YYYY')
                },
            },
            {
                "targets": [ 5 ],
                    render: function(data, type, row) {
                    if(data == null || data == ''){
                        return '-';
                    } else {
                        return data;
                    }
                },
            },
            {
                "targets": [ 2 ],
                    render: function(data, type, row) {
                        if(data != 0){
                            return ' <span class="badge bg-success">Online</span>'
                        } else {
                            return ' <span class="badge bg-secondary">Offline</span>'
                        }
                },
            }
        ], 
    });


    $('.customer-create').on('click', function(){
        $('#customercreate').modal('show');
    })

    $('#customer-form').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this); // Currently empty
        $.ajax({
            url: "create-customer",
            method: "POST",
            headers:{
                'X-CSRF-TOKEN' : token
            },
            data:formData,
            processData: false,
            contentType: false,
            success:function(data){
                if(data.message == 'success'){
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
                        title: 'Customer account created successfully'
                      })
                    
                      $('#customercreate').modal('hide');
                      total();
                    const table = $("#customer").DataTable();
                    table.row.add( {
                        // "id": data.data['id'],
                        "name":       data.data['name'],
                        "msisdn":   data.data['msisdn'],
                        "status":   data.data['status'],
                        "total_win":   data.data['total_win'],
                        "amount":     data.data['amount'],
                        "referal_code": data.data['referal_code'],
                        "created_at": moment(data.data['created_at']).format('MM-DD-YYYY'),
                        "action": '<button id="'+ data.data['id'] +'" class="ban_user btn btn-danger user-btn-edit ml" data-bs-toggle="tooltip" data-bs-placement="top" title="Deactivate"><i class="fa-solid fa-ban"></i></button><button id="'+ data.data['id'] +'" class="delete_user btn btn-danger user-btn-danger ml" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fa-solid fa-user-slash"></i></button><button id="'+ data.data['id'] +'" class="btn btn-info user-btn-edit ml" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa-solid fa-brush"></i></button>',
                    } ).draw();

                    $('#customer-form')[0].reset();
                } else {
                    $('.referal-span').text(data.message);
                    setTimeout(function() { 
                        $('.referal-span').text('');
                     }, 3000);
                }
            },
            error: function(xhr, status, error) {
                var err = JSON.parse(xhr.responseText);

                if(err.errors.firstname){
                    $('.firstname-span').text(err.errors.firstname)
                }
                if(err.errors.lastname){
                    $('.lastname-span').text(err.errors.lastname)
                }
                if(err.errors.msisdn){
                    $('.msisdn-span').text(err.errors.msisdn)
                }
                if(err.errors.password){
                    $('.password-span').text(err.errors.password)
                }
               
                setTimeout(function() { 
                   $('.firstname-span').text('');
                   $('.lastname-span').text('');
                   $('.msisdn-span').text('');
                   $('.password-span').text('');
                }, 3000);
            }
          })
    })

    $(document).on('click','.ban_user', function(){
        var id = $(this).attr('id');
        var suspend = $(this).attr('data-suspend');
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ecca6e',
            cancelButtonColor: '#d33',
            confirmButtonTextColor: '#000',
            confirmButtonText: 'Yes, Suspend him!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "ban-user/" + id + "?suspend=" + suspend,
                    method: "POST",
                    headers:{
                        'X-CSRF-TOKEN' : token
                    },
                    success:function(data){
                        if(data.message == 'success'){
                            const table = $("#customer").DataTable();
                            table.rows.add( data.data ).draw();
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
                              if(suspend == 1){
                                  var title = 'Customer account activated successfully';
                              } else {
                                    var title = 'Customer account deactivated successfully';
                              }
                              
                              Toast.fire({
                                icon: 'success',
                                title: title
                              })
                        }
                    }
                })
            }
          })
    });
    
    $(document).on('click','.delete_user', function(){
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
                    url: "delete-user/" + id,
                    method: "POST",
                    headers:{
                        'X-CSRF-TOKEN' : token
                    },
                    success:function(data){
                        if(data.message == 'success'){
                            const table = $("#customer").DataTable();
                            table.rows( '.selected' ).remove().draw();
                            total();
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
                                title: 'Customer account deleted successfully'
                              })
                        }
                    }
                })
            }
          })
    });

    $(document).on('click', '.edit-customer', function(){
        $('#editmodal').modal('show');
        $('#username').val($(this).attr('data-name'));
        $('#msisdn').val($(this).attr('data-msisdn'));
        $('.customerid').val($(this).attr('id'))
    })

    $('#customer-update-form').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this); // Currently empty
        var id = $('.customerid').val();
        console.log(id)
        $.ajax({
            url: "edit-customer/" + id,
            method: "POST",
            headers:{
                'X-CSRF-TOKEN' : token
            },
            data:formData,
            processData: false,
            contentType: false,
            success:function(data){
                if(data.message == 'success'){
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
                        title: 'Customer account updated successfully'
                      })
                    
                      $('#editmodal').modal('hide');
                      total();
                    const table = $("#customer").DataTable();
                    table.ajax.reload(null, false);
                    $('#customer-update-form')[0].reset();
                }
            },
            error: function(xhr, status, error) {
                var err = JSON.parse(xhr.responseText);

                if(err.errors.username){
                    $('.username-update-span').text(err.errors.username)
                }
                if(err.errors.msisdn){
                    $('.msisdn-update-span').text(err.errors.msisdn)
                }
               
                setTimeout(function() { 
                   $('.username-update-span').text('');
                   $('.msisdn-update-span').text('');
                }, 3000);
            }
          })
    })

    function total(){
        $.ajax({
            url: 'total-users',
            method: "GET",
            success:function(data){
                if(data.message == 'success'){
                    $('.total_users').text('Total Users - ' + data.data)
                    $('.total_amount').text('Total Amounts - ' + data.amount)
                }
            }
        })

    }

    $(document).on('click','.cash-agent', function(){
        $('#cashmodal').modal('show');
        $('#cashinbtn').attr('data-id', $(this).attr('id'));
        $('#cashoutbtn').attr('data-id', $(this).attr('id'));
    })

    $('#cashinbtn').on('click', function(){
        var id = $(this).attr('data-id');
        $.ajax({
            url: "cashin-customer/" + id,
            method: "POST",
            headers:{
                'X-CSRF-TOKEN' : token
            },
            data: {
                "amount": $('#cashin-input').val()
            },
            success:function(data){
                if(data.message == "success"){
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
                    title: 'Agent Cash Out created successfully'
                    })
                    const table = $("#customer").DataTable();
                    table.ajax.reload();
                    $('#cashmodal').modal('hide');
                }
            }
        })
    })

    $('#cashoutbtn').on('click', function(){
        var id = $(this).attr('data-id');
        $.ajax({
            url: "cashout-customer/" + id,
            method: "POST",
            headers:{
                'X-CSRF-TOKEN' : token
            },
            data: {
                "amount": $('#cashout-input').val()
            },
            success:function(data){
                if(data.message == "success"){
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
                    title: 'Agent Cash Out created successfully'
                    })
                    const table = $("#customer").DataTable();
                    table.ajax.reload();
                    $('#cashmodal').modal('hide');
                } else {
                    $('.cashout-span').text(data.message)
                    setTimeout(function() { 
                        $('.cashout-span').text('');
                    }, 3000);
                }
            }
        })
    })
  });