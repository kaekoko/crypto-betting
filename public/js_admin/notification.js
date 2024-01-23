$(function () {
    var token = $('#token').val();
    $('#notification').DataTable({
        processing: true,
        serverSide: true,
        responsive:true,
        ajax: "get_notifications",
        columns: [
            {data: 'title', name: 'title'},
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
                "targets": [ 2 ],
                    render: function(data, type, row) {
                    return moment(data).format('MM-DD-YYYY')
                },
            },
            {
                "targets": [ 3 ],
                    render: function(data, type, row) {
                    if(row['status'] == 1){
                        return '<span class="badge bg-success">Sent</span>';
                    } else {
                        return data;
                    }
                },
            },
        ], 
    });

    $('.notification-create').on('click', function(){
        $('#notificationcreate').modal('show');
    })

    $('#notification-form').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this); // Currently empty
        $.ajax({
            url: "create-notification",
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
                        title: 'Notification created successfully'
                      })
                    
                      $('#notificationcreate').modal('hide');
                    const table = $("#notification").DataTable();
                    table.row.add( {
                        "id": data.data['id'],
                        "title":       data.data['title'],
                        "body":   data.data['body'],
                        "created_at": moment(data.data['created_at']).format('MM-DD-YYYY'),
                        "action": '<button id="'+ data.data['id'] +'" class="btn btn-secondary user-btn-edit ml" data-bs-toggle="tooltip" data-bs-placement="top" title="Resend"><i class="fa-solid fa-recycle"></i></button>',
                    } ).draw();

                    $('#notification-form')[0].reset();
                } 
            },
            error: function(xhr, status, error) {
                var err = JSON.parse(xhr.responseText);

                if(err.errors.title){
                    $('.title-span').text(err.errors.title)
                }
                if(err.errors.body){
                    $('.body-span').text(err.errors.body)
                }
               
                setTimeout(function() { 
                   $('.title-span').text('');
                   $('.body-span').text('');
                }, 3000);
            }
          })
    })

    $(document).on('click', '.blast', function(){
        var id = $(this).attr('id');
        Swal.fire({
            title: 'Are you sure?',
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#ecca6e',
            cancelButtonColor: '#d33',
            confirmButtonTextColor: '#000',
            confirmButtonText: 'Yes, Blast to all users !'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "blast/" + id,
                    method: "GET",
                    success:function(data){
                        if(data.message){
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
                                title: 'Notification Blasted successfully'
                              })
                            const table = $("#notification").DataTable();
                            table.ajax.reload(null, false);
                        }
                    }
                })
            }
          })
    })
  });