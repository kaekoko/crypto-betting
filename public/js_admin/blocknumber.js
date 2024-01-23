$(function () {
    var token = $('#token').val();
    $('#blocknumber').DataTable({
        processing: true,
        serverSide: true,
        responsive:true,
        ajax: "get_blocknumbers",
        columns: [
            {data: 'number', name: 'number'},
            {data: 'section', name: 'section'},
            {data: 'date', name: 'date'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });

    $('.block-create').on('click', function(){
        $('#blockcreate').modal('show');
    })

    $('.block-multiple').on('click', function(){
        $('#multiplemodal').modal('show');
    })

    $('#block-form').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this); // Currently empty
        $.ajax({
            url: "create-block",
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
                        title: 'Block Number created successfully'
                      })
                    
                      $('#blockcreate').modal('hide');
                    const table = $("#blocknumber").DataTable();
                    table.row.add( {
                        "number":  data.data['number'],
                        "section":   data.data['section'],
                        "date":   data.data['date'],
                        "action": '<button id="'+ data.data['id'] +'" class="btn btn-danger user-btn-delete ml" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fa-solid fa-delete-left"></i></button><button id="'+ data.data['id'] +'" class="btn btn-info user-btn-edit ml" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa-solid fa-brush"></i></button>',
                    } ).draw();

                    $('#block-form')[0].reset();
                }
            },
            error: function(xhr, status, error) {
                var err = JSON.parse(xhr.responseText);

                if(err.errors.number){
                    $('.number-span').text(err.errors.number)
                }
               
                setTimeout(function() { 
                   $('.number-span').text('');
                }, 3000);
            }
          })
    })

    $('#multiple-form').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this); // Currently empty
        $.ajax({
            url: "block-multiple",
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
                        title: 'Mulitple Block numbers created successfully'
                      })
                    
                      $('#multiplemodal').modal('hide');
                        const table = $("#blocknumber").DataTable();
                        table.ajax.reload();

                    $('#multiple-form')[0].reset();
                }
            },
          })
    })

    $(document).on('click','.delete_block', function(){
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
                    url: "delete-block/" + id,
                    method: "POST",
                    headers:{
                        'X-CSRF-TOKEN' : token
                    },
                    success:function(data){
                        if(data.message == 'success'){
                            const table = $("#blocknumber").DataTable();
                            table.rows( '.selected' ).remove().draw();
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
                                title: 'Block Number deleted successfully'
                              })
                        }
                    }
                })
            }
          })
    });

    $(document).on('click', '.edit-block', function(){
        $('#editmodal').modal('show');
        $('#b-number').val($(this).attr('data-number'));
        console.log($(this).attr('id'));
        $('.blockid').val($(this).attr('id'))
    })

    $('#block-update-form').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this); // Currently empty
        var id = $('.blockid').val();
        console.log(id)
        $.ajax({
            url: "edit-block/" + id,
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
                        title: 'Block Number updated successfully'
                      })
                    
                    $('#editmodal').modal('hide');
                    const table = $("#blocknumber").DataTable();
                    table.ajax.reload(null, false);
                    $('#block-update-form')[0].reset();
                }
            },
            error: function(xhr, status, error) {
                var err = JSON.parse(xhr.responseText);

                if(err.errors.number){
                    $('.number-update-span').text(err.errors.number)
                }
               
                setTimeout(function() { 
                   $('.number-update-span').text('');
                }, 3000);
            }
          })
    })
});