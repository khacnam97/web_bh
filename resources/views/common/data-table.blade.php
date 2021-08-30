<?php
$message = [
    'Upload success' => __('common.The operation was successful.'),
    'Server error' => __('validation.An error has occurred on the server.'),
    'Not choosing file' => __('validation.You must choose at least one file.'),
    'Disable Confirm' => __('user.Disable Confirm'),
    'Disable button' => __('common.Disable'),
    'Delete Confirm' => __('user.Delete Confirm'),
    'Delete Message' => __('user.Delete Message'),
    'Delete button' => __('user.Delete button'),
    'Close' => __('user.Close'),
    'Ok button active' => __('script.Ok button active'),
    'Ok button inactive' => __('script.Ok button inactive'),
    'Active message' => __('script.Active message'),
    'Title confirm active' => __('script.Title confirm active'),
    'Title confirm inactive' => __('script.Title confirm inactive'),
    'Delete confirm script' => __('script.Delete confirm script'),
    'Delete title script' => __('script.Delete title script'),
    'Upload File success' => __('common.Upload file successfully.'),
    'Refresh' => __('trans.Refresh'),
];
?>
<script>
    function getDataTableLanguageSetting() {
        return {
            lengthMenu: '{{ __('common.dataTable.Show _MENU_ entries') }}',
            search: '{{ __('common.dataTable.Search:') }}',
            info: '{{ __('common.dataTable.Showing _START_ to _END_ of _TOTAL_ entries') }}',
            paginate: {
                first: '{{ __('common.dataTable.First') }}',
                last: '{{ __('common.dataTable.Last') }}',
                next: '{{ __('common.dataTable.Next') }}',
                previous: '{{ __('common.dataTable.Previous') }}',
            },
            zeroRecords: '{{ __('common.dataTable.No matching records found') }}',
            infoEmpty: '{{ __('common.dataTable.Showing 0 to 0 of 0 entries') }}',
            infoFiltered: '{{ __('common.dataTable.(filtered from _MAX_ total entries)') }}',
            emptyTable: '{{ __('common.dataTable.No data available in table') }}',
            processing : '{{ __('common.dataTable.Processing') }}'
        }
    }

    function getUrl(){
        return '{{ route('user.list') }}';
    }

    function getUrlScript(){
        return '{{ route('script.list') }}';
    }

    var messageData = <?= json_encode($message)?>;

    function getMessage(message) {
        if (message in messageData){
            return messageData[message];
        }
        return '{{ __('common.The operation was successful.') }}';
    }
</script>
