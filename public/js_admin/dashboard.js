$(function(){
    var token = $('#token').val();
    var date = moment().format('YYYY-MM-DD');

    numbers($('.starter').attr('data-section'),$('.starter').attr('data-id'));
    statics($('.starter').attr('data-section'),date);

    $('.section-link').on('click', function(){
        numbers($(this).attr('data-section'), $(this).attr('data-id'));
        statics($(this).attr('data-section'), date);
    })

    function numbers (section,id){
        console.log(id);
        $.ajax({
            url: "get-numbers?section=" + section + "&date=" + date,
            method: "GET",
            success:function(data){
                $.each(data, function(i,v){
                    if(v['block'] == 1){
                        var block = 'span-red-num';
                    }  else {
                        if(v['hot'] == 0){
                            var block = 'num-color';
                        } else {
                            if(v['total_amount'] >= v['hot']){
                                var block = 'span-red-num';
                            } else {
                                var block = 'num-color';
                            }
                        }
                    }

                    
                    $('.numbers-'+ id).append(`
                    <div class="col-md-2">
                        <div class="badge bg-danger num-span mt-2 `+ block + `" data-total="`+ v['total_amount'] +`" data-section="`+ section +`" style="width: 100%;" data-number="`+ v['number'] +`">
                            <div class="numdiv">
                                <p class="num-txt">`+ v['number'] +`</p>
                                <p class="amt-txt">Total Amount</p>
                                <p class="amt-txt">`+ v['total_amount'] +`</p>
                            </div>
                        </div>
                    </div>
                    `)
                })
            }
        })
    }

    $(document).on('click','.num-span', function(){
        section = $(this).attr('data-section');
        var totalamt = $(this).attr('data-total');
        var number = $(this).attr('data-number');
        $.ajax({
            url: "get-defineamounts?section=" + section + "&date=" + date + "&number=" + number,
            method: "GET",
            success:function(data){
                $('#total-amt').text('Current Total Amount - ' + totalamt)
                $('#hotamt').text('Hot Amount - ' + data.data['hot_amount'])
                if(data.users.length > 0){
                    var users = data.users;
                    var html = "";
                    $.each(users, function(i,v){
                        html += `
                            <li class="list-group-item">`+ v['name'] +` - `+ v['amounts'] +`</li>
                        `;
                    })
    
                    $('#currentuserslips').html(html);
                    $('.nodata').prop('hidden', true);
                } else {
                    $('.nodata').prop('hidden', false);
                    $('.nodata').text('No Data...');
                }
               
                
                $('#definemodal').modal('show');
            }
        })
    })

    function statics(section, date){
        $.ajax({
            url: "get-statics?section=" + section + "&date=" + date,
            method: "GET",
            success:function(data){
                $('.agent-com').text("Agennt Commission - " + data.agentcom);
                $('.total-amt').text("Total Amounts - " + data.total_amounts);
                $('.total-reward').text("Total Reward - " + data.total_reward);
                $('.total-users').text("Total Users - " + data.total_users);
                var profit = data.profit.toString();
                if(profit.indexOf('-') != -1){
                    $('.profit').text("Profit - " + data.profit).addClass('text-red');
                } else {
                    $('.profit').text("Profit - " + data.profit).addClass('text-green');
                }
                $('.lknumber').text(data.luckynumber);
            } 
        })
    }

    $('.clear-section').on('click', function(){
        $('#clearancemodal').modal('show');
        $('#clearsection').attr('data-section', $(this).attr('data-section'));
    })

    $('.refund-section').on('click', function(){
        $('#refundmodal').modal('show');
        $('#refundsection').attr('data-section', $(this).attr('data-section'));
    })

    $('.slips').on('click', function(){
        $('#slipmodal').modal('show');
        var section = $(this).attr('data-section');
        slips(section,date);
    })

    $('#clearsection').on('click', function(){
        var section = $(this).attr('data-section');
        var password = $('#password').val();
        $.ajax({
            url: "section-clear?date=" + date + '&section=' + section,
            method: "POST",
            headers:{
                'X-CSRF-TOKEN' : token
            },
            data: {
                "password": password
            },
            success:function(data){
                if(data.message == 'success'){
                    $('#clearancemodal').modal('hide');
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
                        title: 'Section cleared successfully.'
                      })
                } else {
                    $('.clear-span').text(data.message)

                    setTimeout(function() { 
                        $('.clear-span').text('');
                     }, 3000);
                }
            }
        })
    })

    $('#refundsection').on('click', function(){
        var section = $(this).attr('data-section');
        var password = $('#refund-password').val();
        $.ajax({
            url: "section-refund?date=" + date + '&section=' + section,
            method: "POST",
            headers:{
                'X-CSRF-TOKEN' : token
            },
            data: {
                "password": password
            },
            success:function(data){
                if(data.message == 'success'){
                    $('#refundmodal').modal('hide');
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
                        title: 'Section refunded successfully.'
                      })
                } else {
                    $('.refund-span').text(data.message)

                    setTimeout(function() { 
                        $('.refund-span').text('');
                     }, 3000);
                }
            }
        })
    })

    function slips (section,date){
        $('#slip-table').dataTable().fnDestroy();
        $('#slip-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "get-slips?date=" + date + '&section=' + section,
            columns: [
                {data: 'name', name: 'name'},
                {data: 'total_numbers', name: 'total_numbers'},
                {data: 'total_amounts', name: 'total_amounts'},
                {data: 'section', name: 'section'},
                {data: 'status', name: 'status'},
                {data: 'active', name: 'active'},
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
                    "targets": [ 4 ],
                        render: function(data, type, row) {
                        if(data == null || data == ""){
                            return ' <span class="badge bg-secondary">Pending</span>'
                        } else if(data == 0){
                            return ' <span class="badge bg-danger">Lose</span>'
                        } else if(data == 1){
                            return ' <span class="badge bg-success">Win</span>'
                        }
                    },
                },
                {
                    "targets": [ 6 ],
                        render: function(data, type, row) {
                        return moment(data).format('YYYY-MM-DD')
                    },
                },
                {
                    "targets": [ 5 ],
                        render: function(data, type, row) {
                        if(data == 'active'){
                            return '<span class="badge bg-success">Active</span>'
                        } else {
                            return '<span class="badge bg-danger">Reject</span>'
                        }
                    },
                }
            ], 
        });    
    }

    $(document).on('click','.check-detail', function(){
        $('#sliptablecard').prop('hidden',true);
        $('#slipdetail').prop('hidden',false);
        slipdetail($(this).attr('id'))
    })

    $('#backsliptable').on('click', function(){
        $('#sliptablecard').prop('hidden',false);
        $('#slipdetail').prop('hidden',true);
    })

    function slipdetail(id){
            $('#slip-detail-table').dataTable().fnDestroy();
            $('#slip-detail-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "get-slip-details?id=" + id,
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'number', name: 'number'},
                    {data: 'amount', name: 'amount'},
                    {data: 'section', name: 'section'},
                    {data: 'status', name: 'status'},
                    {data: 'active', name: 'active'},
                    {data: 'created_at', name: 'created_at'},
                ],
                columnDefs: [
                    {
                        "targets": [ 4 ],
                            render: function(data, type, row) {
                            if(data == null || data == ""){
                                return ' <span class="badge bg-secondary">Pending</span>'
                            } else if(data == 0){
                                return ' <span class="badge bg-danger">Lose</span>'
                            } else if(data == 1){
                                return ' <span class="badge bg-success">Win</span>'
                            }
                        },
                    },
                    {
                        "targets": [ 6 ],
                            render: function(data, type, row) {
                            return moment(data).format('YYYY-MM-DD')
                        },
                    },
                    {
                        "targets": [ 5 ],
                            render: function(data, type, row) {
                            if(data == 'active'){
                                return '<span class="badge bg-success">Active</span>'
                            } else {
                                return '<span class="badge bg-danger">Reject</span>'
                            }
                        },
                    }
                ], 
            });  
    }

    $('.multiple').on('click', function(){
        $('#multiplemodal').modal('show');
        $('#sectionname').val($(this).attr('data-section'));
    })

    $('#multiple-hot-form').on('submit', function(e){
        e.preventDefault();
        console.log('s');
        var formData = new FormData(this); // Currently empty
        $.ajax({
            url: "multiple-amounts?section=" + $('#sectionname').val() + "&date=" + date,
            method: "POST",
            headers:{
                'X-CSRF-TOKEN' : token
            },
            data:formData,
            processData: false,
            contentType: false,
            success:function(data){
                $('#multiplemodal').modal('hide');
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
                    title: 'Multiple amounts created successfully'
                  }).then(function(){
                    location.reload();
                  })
            }
        })
    })

    $('.hotamounts').on('click', function(){
        $('#hotmodal').modal('show');
        var section = $(this).attr('data-section');
        $('#hot-table').dataTable().fnDestroy();
        $('#hot-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "get_hots?section=" + section,
            columns: [
                {data: 'numbers', name: 'numbers'},
                {data: 'hot_amount', name: 'hot_amount'},
                {data: 'section', name: 'section'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: true, 
                    searchable: true
                },
            ],
        });  
    })

    $(document).on('click','.delete_hot', function(){
        var section = $(this).attr('data-section');
        var numbers = $(this).attr('data-number');
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
                    url: 'delete-hot?section=' + section ,
                    method: "POST",
                    headers:{
                        'X-CSRF-TOKEN' : token
                    },
                    data: {
                        "numbers": numbers
                    },
                    success:function(data){
                        if(data.message == 'success'){
                            const table = $("#hot-table").DataTable();
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
                                title: 'Hot Numbers deleted successfully'
                              })
                        }
                    }
                })
            }
        })
    })

    $('.blocknumbers').on('click', function(){
        $('#blockmodal').modal('show');
        var section = $(this).attr('data-section');
        $('#block-table').dataTable().fnDestroy();
        $('#block-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "get_block_dash?section=" + section,
            columns: [
                {data: 'numbers', name: 'numbers'},
                {data: 'section', name: 'section'},
            ],
        });  
    })

    function winners(section){
        $('#winner-table').dataTable().fnDestroy();
        $('#winner-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: 'get-winners?section=' + section,
            columns: [
                {data: 'name', name: 'name'},
                {data: 'winner_number', name: 'winner_number'},
                {data: 'amount', name: 'amount'},
                {data: 'reward_amount', name: 'reward_amount'},
                {data: 'created_at', name: 'created_at'},
            ],
        });    
    }

    $('.winners').on('click', function(){
        $('#winnermodal').modal('show');
        winners($(this).attr('data-section'));
    })
})
