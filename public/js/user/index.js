let userTable = $('#user-table')
let dataTable = null

//datatable user
if (userTable.length) {
    dataTable  = userTable.DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        deferLoading: totalFirstLoad,
        responsive   : true,
        ajax: getUrl(),
        columns: [
            { data: 'id', className: 'stt', orderable: false },
            { data: 'username' },
            { data: 'full_name' },
            { data: 'phone_number' },
            { data: 'center_name' },
            { data: 'role',orderable: false },
            {
                data: 'action',
                orderable: false,
                className: 'text-center',
            },
        ],
        fnRowCallback: function( nRow, aData, iDisplayIndex ) {
            var pageInfo = $('#user-table').DataTable().page.info();
            var index = pageInfo.start + iDisplayIndex + 1;
            $('td.stt',nRow).html(index);
            return nRow;
        }
    })
}

//show swal delete
var user_id;
$(document).on('click', '.delete', function(){
    user_id = $(this).attr('data-id');
    Swal.fire({
        title: getMessage('Delete Confirm'),
        text: getMessage('Delete Message'),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d93535',
        confirmButtonText: getMessage('Delete button'),
        cancelButtonText: getMessage('Close')
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "user/delete/"+ user_id,
                type: 'delete',
                contentType:'application/json',
                data: {
                    "id": user_id,
                    '_token': '{{csrf_token()}}'
                },
                success:function(data)
                {
                    dataTable.ajax.reload();
                    toastr.success(data.message);
                },
                error:function (data) {
                    toastr.error(data.responseJSON.message);
                }
            })

        }
    })
});

//show swal trash
$(document).on('click', '.trash', function(){
    user_id = $(this).attr('data-id');
    Swal.fire({
        title: getMessage('Disable Confirm'),
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: getMessage('Disable button'),
        cancelButtonText: getMessage('Close')
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "user/trash/"+ user_id,
                type: 'post',
                contentType:'application/json',
                data: {
                    "id": user_id,
                    '_token': '{{csrf_token()}}'
                },
                success:function(data)
                {
                    dataTable.ajax.reload();
                    toastr.success(data.message);
                },
                error:function (data) {
                    toastr.error(data.responseJSON.message);
                }
            })

        }
    })
});

$(document).on('click', '.active-user', function(){
    user_id = $(this).attr('data-id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "user/restore/"+ user_id,
        type: 'post',
        contentType:'application/json',
        data: {
            "id": user_id,
            '_token': '{{csrf_token()}}'
        },
        success:function(data)
        {
            dataTable.ajax.reload();
            toastr.success(data.message);
        },
        error:function (data) {
            toastr.error(data.responseJSON.message);
        }
    })
});

//create, edit  message success
$(function () {
    if (message) {
        toastr.success(message);
    }
});
