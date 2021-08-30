let scriptTable = $('#script-table')
let dataTable = null

//datatable user
if (scriptTable.length) {
    dataTable  = scriptTable.DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        deferLoading: totalFirstLoad,
        responsive   : true,
        ajax: getUrlScript(),
        columns: [
            { data: 'name' },
            { data: 'description' },
            { data: 'fileName' },
            { data: 'isActive' },
            {
                data: 'action',
                orderable: false,
                className: 'text-center',
            },
        ],
        fnRowCallback: function( nRow, aData, iDisplayIndex ) {
            var pageInfo = $('#script-table').DataTable().page.info();
            var index = pageInfo.start + iDisplayIndex + 1;
            $('td.stt',nRow).html(index);
            return nRow;
        }
    })
}

//delete script
var script_id;
$(document).on('click', '.delete', function(){
    script_id = $(this).attr('data-id');
    var url = "script/delete/"+ script_id;
    Swal.fire({
        title: getMessage('Delete confirm script')  ,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d93535',
        confirmButtonText: getMessage('Delete button'),
        cancelButtonText: getMessage('Close')
    }).then(function (e) {
        if (e.value) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'delete',
                contentType:'application/json',
                data: {
                    "id": script_id,
                    '_token': '{{csrf_token()}}'
                },
                success:function(data)
                {
                    dataTable.ajax.reload();
                    var add_script = $( '.script_'+script_id ).attr("data-delete");
                    $('div[data-delete= '+add_script+']').remove();
                    if ( parseInt(add_script) === 0) {
                        $('.delete-sort[data-delete = 1]').remove();
                    }
                    $('#sortable div').each(function(i) {
                        $(this).attr('data-delete', Math.ceil(i/2));
                    });
                    toastr.success(data.message);
                },
                error:function (data) {
                    toastr.error(data.responseJSON.message);
                }
            })
        } else {
            return false;
        }
    })
});

// active script
$(document).on('click', '.active-script', function() {
    var messageTitle;
    var messageButtonOk;
    var messageText;
    var active_id = $(this).attr('data-id');
    var is_active = $(this).attr('data-active');
    if (parseInt(is_active) === 1) {
        messageTitle = getMessage('Title confirm inactive')
        messageButtonOk = getMessage('Ok button inactive')
    }
    else {
        messageTitle = getMessage('Title confirm active')
        messageButtonOk = getMessage('Ok button active')
        messageText = getMessage('Active message')
    }
    var url = "script/active/"+ active_id;
    Swal.fire({
        title: messageTitle,
        text: messageText,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: messageButtonOk,
        cancelButtonText: getMessage('Close'),
    }).then(function (e) {
        if (e.value) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'post',
                contentType:'application/json',
                data: {
                    "id": active_id,
                    '_token': '{{csrf_token()}}'
                },
                success:function(data)
                {
                    dataTable.ajax.reload();
                    if (data.script.isActive) {
                        var add_script = data.countScript - 1;
                        $('#sortable').append('<div class="script_'+data.script.id+'" data-delete="' +add_script+ '">\n' +
                            '<a data-id="' +data.script.id+ '" type="button" class="btn form-control"><i class="fas fa-bars"></i>'+data.script.name+'</a>\n' +
                            '</div>');
                    }
                    else {
                        var data_delete = $( '.script_'+data.script.id ).attr("data-delete");
                        $('div[data-delete= '+data_delete+']').remove();
                        if ( parseInt(data_delete) === 0) {
                            $('.delete-sort[data-delete = 1 ]').remove();
                        }
                        $('#sortable div').each(function(i) {
                            $(this).attr('data-delete', Math.ceil(i/2));
                        });
                    }
                    toastr.success(data.message);
                },
                error:function (data) {
                    toastr.error(data.responseJSON.message);
                }
            })
        } else {
            return false;
        }
    })
});

//sort script
$( "#sortable" ).sortable({
    cancel: '.static',
    items: 'div',
    start: function () {
        $('.static', this).each(function () {
            var $this = $(this);
            $this.data('pos', $this.index());
        });
    },
    change: function () {
        var $sortable = $(this);
        var $statics = $('.static', this).detach();
        var tagName = $statics.prop('tagName');
        var $helper = $('<' + tagName + '/>').prependTo(this);
        $statics.each(function () {
            var $this = $(this);
            var target = $this.data('pos');
            $this.insertAfter($('div', $sortable).eq(target));
        });
        $helper.remove();
    },
    update: function () {
        var data_id =[];
        $( "#sortable a" ).each(function() {
            data_id.push($( this ).attr("data-id"));
        });
        $('#sortable div').each(function(i) {
            $( this ).attr('data-delete', Math.ceil(i/2));
        });
        var url = "script/sort";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'post',
            data: {
                'data_id' : data_id
            },
            success:function(data)
            {
                toastr.success(data.message);
            },
            error:function (data) {
                toastr.error(data.responseJSON.message);
            }
        })
    }
})

$( "#sortable" ).disableSelection();

//create, edit  message success
$(function () {
    if (message) {
        toastr.success(message);
    }
});
