$(function () {
    $('.sidebar-toggle')[0].click();

    cash('in');
    total('in')

    $('#cashin-nav').on('click', function(){
        cash('in');
        total('in');
        $('.sidebar-toggle')[0].click();
    })

    $('#cashout-nav').on('click', function(){
        cash('out');
        total('out');
        $('.sidebar-toggle')[0].click();
    })

    function cash(req){
        if(req == 'in'){
            $('#cashin').DataTable().clear().destroy();
            $('#cashin').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: "get_cash?cash=in",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'credential', name: 'credential'},
                    {data: 'transaction_id', name: 'transaction_id'},
                    {data: 'payment', name: 'payment'},
                    {data: 'amount', name: 'amount'},
                    {data: 'old_amount', name: 'old_amount'},
                    {data: 'new_amount', name: 'new_amount'},
                    {data: 'type', name: 'type'},
                    {data: 'date', name: 'date'},
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: true, 
                        searchable: true
                    },
                ],columnDefs: [
                    {
                        "targets": [ 9 ],
                            render: function(data, type, row) {
                            if(data == null){
                                return '-';
                            } else {
                                return data;
                            }
                        },
                    },{
                        "targets": [ 10 ],
                            render: function(data, type, row) {
                            if(row['approve'] == 0){
                                return '<span class="badge bg-danger">Rejected</span>';
                            } else if(row['approve'] == 1) {
                                return '<span class="badge bg-success">Approved</span>';
                            } else {
                                return data;
                            }
                        },
                    }
                ], 
            });
        } else {
            $('#cashout').DataTable().clear().destroy();
            $('#cashout').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: "get_cash?cash=out",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'credential', name: 'credential'},
                    {data: 'payment', name: 'payment'},
                    {data: 'amount', name: 'amount'},
                    {data: 'old_amount', name: 'old_amount'},
                    {data: 'new_amount', name: 'new_amount'},
                    {data: 'type', name: 'type'},
                    {data: 'date', name: 'date'},
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: true, 
                        searchable: true
                    },
                ],columnDefs: [
                    {
                        "targets": [ 8 ],
                            render: function(data, type, row) {
                            if(data == null){
                                return '-';
                            } else {
                                return data;
                            }
                        },
                    },{
                        "targets": [ 9 ],
                            render: function(data, type, row) {
                            if(row['approve'] == 0){
                                return '<span class="badge bg-danger">Rejected</span>';
                            } else if(row['approve'] == 1) {
                                return '<span class="badge bg-success">Approved</span>';
                            } else {
                                return data;
                            }
                        },
                    }
                ], 
            });
        }
    }

    $(document).on('click', '.approve-in', function(){
        var id = $(this).attr('id');
        buttontoggle(id, 'in', 'approve', 'approve');
        total('in')
    })

    $(document).on('click', '.reject-in', function(){
        var id = $(this).attr('id');
        buttontoggle(id, 'in', 'reject', 'reject');
    })

    $(document).on('click', '.approve-out', function(){
        var id = $(this).attr('id');
        buttontoggle(id, 'out', 'approve', 'approve');
        total('out');
    })

    $(document).on('click', '.reject-out', function(){
        var id = $(this).attr('id');
        buttontoggle(id, 'out', 'reject', 'reject');
    })

    function buttontoggle(id, type, option, text){
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ecca6e',
            cancelButtonColor: '#d33',
            confirmButtonTextColor: '#000',
            confirmButtonText: 'Yes,'+ text +' him!'
          }).then((result) => {
            if (result.isConfirmed) {
                if(type == 'in'){
                    var url = 'cashin-'+ option +'/' + id;
                } else {
                    var url = 'cashout-'+ option +'/' + id;
                }

                $.ajax({
                    url: url,
                    method: "GET",
                    success:function(data){
                        if(data.message == "success"){
                            const table = $('#cash'+ type).DataTable();
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
                                title: 'His Cash' + type + ' is successfully '+ text +'ed.'
                              })
                        }
                    }
                })
            }
          })
    }

    function total(type){
        if(type == 'in'){
            $.ajax({
                url: 'total-cashin',
                method: "GET",
                success:function(data){
                    if(data.message == 'success'){
                        $('.total_cashin').text('Total Cashin - ' + data.data)
                    }
                }
            })
        } else {
            $.ajax({
                url: 'total-cashout',
                method: "GET",
                success:function(data){
                    if(data.message == 'success'){
                        $('.total_cashout').text('Total Cashout - ' + data.data)
                    }
                }
            })
        }
    }
  });