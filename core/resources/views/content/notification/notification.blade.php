    <div class="page">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">System</li>
                <li class="breadcrumb-item active">Notification</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <header class="panel-heading">
                    <div class="panel-actions"></div>
                    <h3 class="panel-title">New Customer WTB</h3>
                </header>
                <div class="panel-body">
                    <table class="table table-hover dataTable table-striped w-full" id="datalist">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Detail</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="panel">
                <header class="panel-heading">
                    <div class="panel-actions"></div>
                    <h3 class="panel-title">Confirmation Payment WTB</h3>
                </header>
                <div class="panel-body">
                    <table class="table table-hover dataTable table-striped w-full" id="datalist1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice No</th>
                                <th>Member</th>
                                <th>Seller</th>
                                <th>Nominal</th>
                                <th>Img</th>
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
            objTable.data = $('#datalist').DataTable({
                "dom": 'frtip',
                "pageLength" : 10,
                "scrollX" : true,
                "ajax": {
                    "url": "{{ route('api-list-notif') }}",
                    "dataSrc": ""
                },
                "columns": [
                    { "data" : "id"},
                    { "data" : "create_at"},
                    {
                        mRender: function(data, type, row) {
                            return 'Customer baru terdaftar dengan email : ' + row.email;
                        }
                    },
                    {
                        mRender: function (data, type, row) {
                            return '<button class="btn btn-icon btn-light btn-xs" onclick="editIt(' +row.id+ ')">View</button> '; 
                        }
                    }
                ]
            });
            objTable.data = $('#datalist1').DataTable({
                "dom": 'frtip',
                "pageLength" : 10,
                "scrollX" : true,
                "ajax": {
                    "url": "{{ route('api-list-payment-user') }}",
                    "dataSrc": ""
                },
                "columns": [
                    { "data" : "id"},
                    { "data" : "invoice_no"},
                    { "data" : "user"},
                    { "data" : "seller"},
                    { "data" : "nominal"},
                    { "data" : "img_payment"},
                    {
                        mRender: function (data, type, row) {
                            return '<button class="btn btn-icon btn-light btn-xs" onclick="editIt(' +row.id+ ')">View</button> '; 
                        }
                    }
                ]
            });
        });
    </script>