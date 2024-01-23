$(function () {
    $('.sidebar-toggle')[0].click();
    total();
    var token = $('#token').val();
    $('#agent').DataTable({
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: "get_agents",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'msisdn', name: 'msisdn'},
            {data: 'percentage', name: 'percentage'},
            {data: 'amount', name: 'amount'},
            {data: 'referal_code', name: 'referal_code'},
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
                "targets": [ 5 ],
                    render: function(data, type, row) {
                    return moment(data).format('MM-DD-YYYY')
                },
            }
        ], 
    });

    $('.agent-create').on('click', function(){
        $('#agentcreate').modal('show');
    })

    $('#agent-form').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this); // Currently empty
        $.ajax({
            url: "create-agent",
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
                        title: 'Agent account created successfully'
                      })
                    
                      $('#agentcreate').modal('hide');
                      total();
                    const table = $("#agent").DataTable();
                    table.row.add( {
                        "id": data.data['id'],
                        "name":       data.data['name'],
                        "msisdn":   data.data['msisdn'],
                        "percentage":   data.data['percentage'],
                        "amount":     data.data['amount'],
                        "referal_code": data.data['referal_code'],
                        "created_at": moment(data.data['created_at']).format('MM-DD-YYYY'),
                        "action": '<button id="'+ data.data['id'] +'" class="ban_agent btn btn-danger user-btn-danger ml" data-suspend="'+ data.data['is_suspend'] +'" data-bs-toggle="tooltip" data-bs-placement="top" title="Ban"><i class="fa-solid fa-ban"></i></button><button id="'+ data.data['id'] +'" class="delete_agent btn btn-danger user-btn-delete ml" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fa-solid fa-user-slash"></i></button><button id="'+ data.data['id'] +'" class="btn btn-info user-btn-edit ml" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa-solid fa-brush"></i></button>',
                    } ).draw();
                
                    $('#agent-form')[0].reset();
                }
            },
            error: function(xhr, status, error) {
                var err = JSON.parse(xhr.responseText);

                if(err.errors.username){
                    $('.username-span').text(err.errors.username)
                }
                if(err.errors.msisdn){
                    $('.msisdn-span').text(err.errors.msisdn)
                }
                if(err.errors.password){
                    $('.password-span').text(err.errors.password)
                }
               
                setTimeout(function() { 
                   $('.username-span').text('');
                   $('.msisdn-span').text('');
                   $('.password-span').text('');
                }, 3000);
            }
          })
    })

    $(document).on('click','.ban_agent', function(){
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
                    url: "ban-agent/" + id + "?suspend=" + suspend,
                    method: "POST",
                    headers:{
                        'X-CSRF-TOKEN' : token
                    },
                    success:function(data){
                        if(data.message == 'success'){
                            const table = $("#agent").DataTable();
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
                                  var title = 'Agent account activated successfully';
                              } else {
                                    var title = 'Agent account deactivated successfully';
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
    
    $(document).on('click','.delete_agent', function(){
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
                    url: "delete-agent/" + id,
                    method: "POST",
                    headers:{
                        'X-CSRF-TOKEN' : token
                    },
                    success:function(data){
                        if(data.message == 'success'){
                            const table = $("#agent").DataTable();
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
                                title: 'Agent account deleted successfully'
                              })
                        }
                    }
                })
            }
          })
    });

    $(document).on('click', '.edit-agent', function(){
        $('#editmodal').modal('show');
        $('#username').val($(this).attr('data-name'));
        $('#percentage').val($(this).attr('data-percent'));
        console.log($(this).attr('data-percent'));
        $('#msisdn').val($(this).attr('data-msisdn'));
        console.log($(this).attr('id'));
        $('.agentid').val($(this).attr('id'))
    })

    $(document).on('click','.cashout-agent', function(){
        console.log($(this).attr('data-amt'));
        $('.agent-balance').text($(this).attr('data-amt'));
        $('#cashout-modal').modal('show');
        $('#cashout-agent').attr('data-id', $(this).attr('id'));
    })
    
    $('#cashout-agent').on('click', function(){
        var id = $(this).attr('data-id');
        $.ajax({
            url: "cashout-agent/" + id,
            method: "POST",
            headers:{
                'X-CSRF-TOKEN' : token
            },
            data: {
                "amount": $('#cashoutamount').val()
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
                      const table = $("#agent").DataTable();
                      table.ajax.reload();
                      $('#cashout-modal').modal('hide');
                    } else {
                    $('.cashout-span').text(data.message)
                    setTimeout(function() { 
                        $('.cashout-span').text('');
                     }, 3000);
                }
            }
        })
    })

    $(document).on('click','.cashout-detail', function(){
        $('#cashout-detail').modal('show');
        cashoutdetail($(this).attr('id'));
    })

    function cashoutdetail(id){
        $('#cashout-detail-table').dataTable().fnDestroy();
        $('#cashout-detail-table').DataTable({
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: "get-cashout-detail/" + id,
            columns: [
                {data: 'amount', name: 'amount'},
                {data: 'old_amount', name: 'old_amount'},
                {data: 'new_amount', name: 'new_amount'},
                {data: 'created_at', name: 'created_at'},
            ],
            columnDefs: [
                {
                    "targets": [ 3 ],
                        render: function(data, type, row) {
                        return moment(data).format('MM-DD-YYYY hh:mm A')
                    },
                }
            ], 
        });
    }

    $('#agent-update-form').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this); // Currently empty
        var id = $('.agentid').val();
        console.log(id)
        $.ajax({
            url: "edit-agent/" + id,
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
                        title: 'Agent account updated successfully'
                      })
                    
                      $('#editmodal').modal('hide');
                      total();
                    const table = $("#agent").DataTable();
                    table.ajax.reload(null, false);
                    $('#agent-update-form')[0].reset();
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
                if(err.errors.percentage){
                    $('.percentage-update-span').text(err.errors.percentage)
                }
               
                setTimeout(function() { 
                   $('.username-update-span').text('');
                   $('.msisdn-update-span').text('');
                   $('.percentage-update-span').text('');
                }, 3000);
            }
          })
    })

    function total(){
        $.ajax({
            url: 'total-agents',
            method: "GET",
            success:function(data){
                if(data.message == 'success'){
                    $('.total_agents').text('Total Agents - ' + data.data)
                    $('.total_amount').text('Total Amounts - ' + data.amount)
                }
            }
        })

    }
    
  });