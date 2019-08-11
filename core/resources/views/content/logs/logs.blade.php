    <div class="page">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">System</li>
                <li class="breadcrumb-item active">Log</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-body">
                    <table class="table table-hover dataTable table-striped w-full" id="datalist">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>User</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        var objTable = {};
        $(document).ready(function () {
            objTable.data = $('#datalist').DataTable({
                "dom": 'frtip',
                "pageLength" : 10,
                "scrollX" : true,
                "ajax": {
                    "url": "{{ route('api-logs') }}",
                    "dataSrc": ""
                },
                "columns": [
                    { "data" : "id"},
                    { "data" : "time_log"},
                    { "data" : "user_log"},
                    { "data" : "detail_log"}
                ]
            });
        });
    </script>