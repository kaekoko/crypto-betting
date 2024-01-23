$(function () {
    
// moment($('#date').val()).format('MM-DD-YYYY')
    luckynumber(moment().format('YYYY-MM-DD'));


    $('#date-search').on('click', function(){
        var date = moment($('.date').val()).format('YYYY-MM-DD');
        luckynumber(date);
    })

    function luckynumber(date){
        $('#lucky').DataTable().clear().destroy();
        $('#lucky').DataTable({
            processing: true,
            serverSide: true,
            responsive:true,
            ajax: "get_lucky_numbers?date="+ date,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'number', name: 'number'},
                {data: 'section', name: 'section'},
                {data: 'created_at', name: 'created_at'},
            ],
            columnDefs: [
                {
                    "targets": [ 3 ],
                        render: function(data, type, row) {
                        return moment(data).format('MM-DD-YYYY')
                    },
                }
            ], 
        });
    }
  });