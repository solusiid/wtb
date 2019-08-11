    <div class="page">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Offer</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <header class="panel-heading">
                    <div class="panel-actions"></div>
                    <h3 class="panel-title">Offer WTB</h3>
                </header>
                <div class="panel-body">
                    <a href="{{ route('req-off', ['type' => 'seller-off']) }}" class="btn btn-icon btn-primary btn-xs">Add Offers</a>
                    <table class="table table-hover dataTable table-striped w-full" id="datalist1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
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
                    "url": "{{ route('api-offers-seller') }}",
                    "dataSrc": ""
                },
                "columns": [
                    { "data" : "id"},
                    { "data" : "date_send"},
                    { "data" : "id_sender"},
                    { "data" : "detail_sender"},
                    {
                        mRender: function (data, type, row) {
                            return '<button class="btn btn-icon btn-light btn-xs" onclick="editIt(' +row.id+ ')">View</button> '; 
                        }
                    }
                ]
            });
        });
        
        function editIt(id) {
            var link = "{{ route('seller-detail', [':param', ':id']) }}";
	        link = link.replace(':id', id);
	        link = link.replace(':param', 'seller-off');
            window.location.replace(link);
        }
    </script>