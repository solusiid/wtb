    <div class="page">
        <div class="page-content">
            <div class="panel">
                <header class="panel-heading">
                    <div class="panel-actions"></div>
                    <h3 class="panel-title">Offer WTB</h3>
                </header>
                <div class="panel-body">
                    <table class="table table-hover dataTable table-striped w-full" id="datalist1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>No Offer</th>
                                <th>Seller</th>
                                <th>Price</th>
                                <th>Downpayment</th>
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
                    "url": "{{ route('api-offers-peruser') }}",
                    "dataSrc": ""
                },
                "columns": [
                    { "data" : "id"},
                    { "data" : "date_send"},
                    { "data" : "no_offers"},
                    { "data" : "id_sender"},
                    { "data" : "price"},
                    { "data" : "downpayment"},
                    { "data" : "detail_sender"},
                    {
                        mRender: function (data, type, row) {
                            return '<button class="btn btn-icon btn-light btn-xs" onclick="editIt(\'' +row.no_offers+ '\')">Accept</button> '; 
                        }
                    }
                ]
            });
        });
        
        function editIt(id) {
            $.post("{{ route('api-accept') }}", {
    		    id_user     : id,
                _token    	: '{{ Session::token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){        
                		swal("Success!", datanotif.rcdesc, "success");
                  		window.location.replace(datanotif.route);
              		} else {
                		swal("Error!", datanotif.rcdesc, "error");
              		}
                }
            });
        }
    </script>