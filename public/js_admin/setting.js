$(function(){
    var token = $('#token').val();

    $('#setting-form').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this); // Currently empty
        $.ajax({
            url: "setting",
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
                        title: 'Setting Updated successfully'
                      })
                }
            },
          })
    })
})