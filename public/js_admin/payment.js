$(function () {
    var token = $('#token').val();

    $('#payment').DataTable({
        processing: true,
        serverSide: true,
        responsive:true,
        ajax: "get_payments",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'holder', name: 'holder'},
            {data: 'account_number', name: 'account_number'},
            {data: 'logo', name: 'logo'},
            {data: 'cashin_status', name: 'cashin_status'},
            {data: 'cashout_status', name: 'cashout_status'},
            {data: 'type', name: 'type'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ],
        columnDefs: [
            {
                "targets": [ 3 ],
                    render: function(data, type, row) {
                        if(data == null){
                            return '<img src="../storage/payments/No-Image-Placeholder.png" width="80" height="100">'
                        } else {
                            return '<img src="../storage/payments/'+ data +'" class="img-fluid">'
                        }
                },
            },{
                "targets": [ 4 ],
                    render: function(data, type, row) {
                        if(data == 1){
                            return `<div class="switch">
                            <input type="checkbox" data-id="`+ row['id'] +`" class="togg togg-in" value="0" id="in-`+ row['id'] +`" checked>
                            <label for="in-`+ row['id'] +`"><i></i></label>
                        </div>`;
                        } else {
                            return `<div class="switch">
                            <input type="checkbox" data-id="`+ row['id'] +`" class="togg togg-in" value="0" id="in-`+ row['id'] +`">
                            <label for="in-`+ row['id'] +`"><i></i></label>
                        </div>`;
                        }
                },
            },{
                "targets": [ 5 ],
                    render: function(data, type, row) {
                        if(data == 1){
                            return `<div class="switch swtch-cashout">
                            <input type="checkbox" data-id="`+ row['id'] +`" class="togg togg-out" value="0" id="out-`+ row['id'] +`" checked>
                            <label for="out-`+ row['id'] +`"><i></i></label>
                        </div>`;
                        } else {
                            return `<div class="switch">
                            <input type="checkbox" data-id="`+ row['id'] +`" class="togg togg-out" value="0" id="out-`+ row['id'] +`">
                            <label for="out-`+ row['id'] +`"><i></i></label>
                        </div>`;
                        }
                },
            }
        ]
    });

    $('.payment-create').on('click', function(){
        $('#paymentcreate').modal('show');
    })

    $(document).on('click','.togg-in', function(){
        var id = $(this).attr('data-id');
        if ($(this).is(':checked')) {
            var status = 1;
        } else {
            var status = 0;
        }
        $.ajax({
            url: 'in-status/' + id + '?status=' + status,
            method: "GET",
            success:function(data){
                
            }
        })
    })

    $(document).on('click','.togg-out', function(){
        var id = $(this).attr('data-id');
        if ($(this).is(':checked')) {
            var status = 1;
        } else {
            var status = 0;
        }
        $.ajax({
            url: 'out-status/' + id + '?status=' + status,
            method: "GET",
            success:function(data){
                
            }
        })
    })

    $('#payment-form').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this); // Currently empty
        $.ajax({
            url: "create-payment",
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
                        title: 'Payment account created successfully'
                      })
                    
                      $('#paymentcreate').modal('hide');
                    const table = $("#payment").DataTable();
                    table.row.add( {
                        "name":       data.data['name'],
                        "holder":   data.data['holder'],
                        "account_number":   data.data['account_number'],
                        "logo":   data.data['logo'],
                        "cashin_status":     data.data['cashin_status'],
                        "cashout_status": data.data['cashout_status'],
                        "type": data.data['type'],
                        "action": '<button id="'+ data.data['id'] +'" class="btn btn-danger user-btn-edit ml" data-bs-toggle="tooltip" data-bs-placement="top" title="Reject"><i class="fa-solid fa-circle-xmark"></i></button><button id="'+ data.data['id'] +'" class="btn btn-danger user-btn-danger ml"><i class="fa-solid fa-user-slash"></i></button><button id="'+ data.data['id'] +'" class="btn btn-info user-btn-edit ml" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve"><i class="fa-solid fa-envelope-circle-check"></i></button>',
                    } ).draw();

                    $('#payment-form')[0].reset();
                } 
            },
            error: function(xhr, status, error) {
                var err = JSON.parse(xhr.responseText);
                if(err.errors.name){
                    $('.name-span').text(err.errors.name)
                }
                if(err.errors.holder){
                    $('.holder-span').text(err.errors.holder)
                }
                if(err.errors.account_number){
                    $('.account_number-span').text(err.errors.account_number)
                }
               
                setTimeout(function() { 
                   $('.name-span').text('');
                   $('.holder-span').text('');
                   $('.account_number-span').text('');
                }, 3000);
            }
          })
    })

    $(document).on('click','.delete_payment', function(){
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
                    url: "delete-payment/" + id,
                    method: "POST",
                    headers:{
                        'X-CSRF-TOKEN' : token
                    },
                    success:function(data){
                        if(data.message == 'success'){
                            const table = $("#payment").DataTable();
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
                                title: 'Payment deleted successfully'
                              })
                        }
                    }
                })
            }
          })
    });

    $('.type-select').on('change', function() {
        if($(this).val() == 'billing'){
            $('.percent-input').prop('hidden', false);
        } else {
            $('.percent-input').prop('hidden', true);
        }
    });

    $(document).on('click', '.edit-payment', function(){
        $('#editmodal').modal('show');
        $('#name').val($(this).attr('data-name'));
        $('#holder').val($(this).attr('data-holder'));
        console.log($(this).attr('data-percent'));
        $('#accountnumber').val($(this).attr('data-account'));
        $('#type').val($(this).attr('data-type'));
        if($(this).attr('data-type') == 'billing'){
            $('.bill-update').prop('hidden', false);
            $('#billpercent').val($(this).attr('data-percent'));
        } else {
            $('.bill-update').prop('hidden', true);
        }
        console.log($(this).attr('id'));
        $('.paymentid').val($(this).attr('id'))
    })


    $('#payment-update-form').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this); // Currently empty
        var id = $('.paymentid').val();
        console.log(id)
        $.ajax({
            url: "edit-payment/" + id,
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
                        title: 'Payment updated successfully'
                      })
                    
                      $('#editmodal').modal('hide');
                    const table = $("#payment").DataTable();
                    table.ajax.reload(null, false);
                    $('#payment-update-form')[0].reset();
                }
            },
            error: function(xhr, status, error) {
                var err = JSON.parse(xhr.responseText);

                if(err.errors.name){
                    $('.name-update-span').text(err.errors.name)
                }
                if(err.errors.holder){
                    $('.msisdn-update-span').text(err.errors.holder)
                }
                if(err.errors.account_number){
                    $('.account_number-update-span').text(err.errors.account_number)
                }
               
                setTimeout(function() { 
                   $('.name-update-span').text('');
                   $('.holder-update-span').text('');
                   $('.account_number-update-span').text('');
                }, 3000);
            }
          })
    })

  });