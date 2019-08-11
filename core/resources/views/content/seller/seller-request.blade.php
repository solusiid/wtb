    <div class="page">
        <div class="page-content">
            <div class="panel">
                <header class="panel-heading">
                    <div class="panel-actions"></div>
                    <h3 class="panel-title">Request WTB</h3>
                </header>
                <div class="panel-body">
                    <table class="table table-hover dataTable table-striped w-full" id="datalist1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Requestor</th>
                                <th>Seller</th>
                                <th>Detail</th>
                                <th>Action</th>
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
            objTable.data = $('#datalist1').DataTable({
                "dom": 'frtip',
                "pageLength" : 10,
                "scrollX" : true,
                "ajax": {
                    "url": "{{ route('api-request-seller') }}",
                    "dataSrc": ""
                },
                "columns": [
                    { "data" : "id"},
                    { "data" : "date_send"},
                    { "data" : "id_sender"},
                    { "data" : "id_receiver"},
                    { "data" : "detail_sender"},
                    {
                        mRender: function (data, type, row) {
                            return '<button class="btn btn-icon btn-light btn-xs" onclick="editIt(' +row.id+ ')">View</button> '; 
                        }
                    }
                ]
            });
        });
    </script>