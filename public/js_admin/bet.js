$(function(){
    
    betting_hist($('.from').val(), $('.to').val(), $('#section-hist').val())

    $('.search-arrange').on('click', function(){
        betting_hist($('.from').val(), $('.to').val(),$('#section-hist').val())
    })

    function betting_hist(from,to, section){
        $('#bet-histories').dataTable().fnDestroy();
        $('#bet-histories').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "get-histories?from=" + from +"&to=" + to + "&section=" + section,
            columns: [
                // {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'total_numbers', name: 'total_numbers'},
                {data: 'total_amounts', name: 'total_amounts'},
                {data: 'section', name: 'section'},
                {data: 'status', name: 'status'},
                {data: 'active', name: 'active'},
                {data: 'lucky_number', name: 'lucky_number'},
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
                    "targets": [ 7 ],
                        render: function(data, type, row) {
                        return moment(data).format('MM-DD-YYYY')
                    },
                },
                {
                    "targets": [ 4 ],
                        render: function(data, type, row) {
                        if(data == 1){
                            return '<span class="badge bg-success">Win</span>'
                        } else if(data == 0){
                            return '<span class="badge bg-danger">Lose</span>'
                        } else {
                            return '<span class="badge bg-secondary">Pending</span>'
                        }
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

        $.ajax({
            url: "get-arrange-statics?from=" + from +"&to=" + to + "&section=" + section,
            method: "GET",
            success:function(data){
                $('.agent-com-a').text("Agennt Commission - " + data.agentcom);
                $('.total-amt-a').text("Total Amounts - " + data.total_amounts);
                $('.total-reward-a').text("Total Reward - " + data.total_reward);
                $('.total-users-a').text("Total Users - " + data.total_users);
                var profit = data.profit.toString();
                if(profit.indexOf('-') != -1){
                    $('.profit-a').text("Profit - " + data.profit).addClass('text-red');
                } else {
                    $('.profit-a').text("Profit - " + data.profit).addClass('text-green');
                }
            } 
        })
    }

    $(document).on('click','.view-detail', function(){
        $('#arrnagedetailtable').modal('show');
        $('.lucktext').text('Lucky Number - ' + $(this).attr('data-lucky'));
        detail($(this).attr('id'));
    })

    function detail(id){
        $('#arrange-detail-table').dataTable().fnDestroy();
        $('#arrange-detail-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "get-detail-histories?id=" + id,
            columns: [
                // {data: 'id', name: 'id'},
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
                    "targets": [ 6 ],
                        render: function(data, type, row) {
                        return moment(data).format('MM-DD-YYYY')
                    },
                },
                {
                    "targets": [ 4 ],
                        render: function(data, type, row) {
                        if(data == 1){
                            return '<span class="badge bg-success">Win</span>'
                        } else if(data == 0){
                            return '<span class="badge bg-danger">Lose</span>'
                        } else {
                            return '<span class="badge bg-secondary">Pending</span>'
                        }
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
})
