    <div class="page">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Master</li>
                <li class="breadcrumb-item active">Tenor</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <header class="panel-heading">
                    <div class="panel-actions"></div>
                    <h3 class="panel-title">Add Tenor</h3>
                </header>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <input type="text" id="payment" class="form-control" placeholder="Contoh : 24 (Bulan)" />
                        </div>
                        <div class="col-sm-3">
                            <button class="btn btn-icon btn-primary" id="upload">Add Tenor</button> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel">
                <header class="panel-heading">
                    <div class="panel-actions"></div>
                    <h3 class="panel-title">Payment Method Item WTB</h3>
                </header>
                <div class="panel-body">
                    <table class="table table-hover dataTable table-striped w-full" id="datalist">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tenor</th>
                                <th>Status</th>
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
                    "url": "{{ route('api-list-tenor') }}",
                    "dataSrc": ""
                },
                "columns": [
                    { "data" : "id"},
                    { "data" : "tenor_name"},
                    { 
                        mRender: function (data, type, row) {
                            if(row.stat_tenor == '0') {
                                return '<button class="btn btn-icon btn-success btn-xs" onclick="editIt(' +row.id+ ', 1)">Active</button>';
                            } else {
                                return '<button class="btn btn-icon btn-danger btn-xs" onclick="editIt(' +row.id+ ', 0)">Deactive</button>';
                            }
                        }
                    },
                    {
                        mRender: function (data, type, row) {
                            if(row.stat_tenor == '1') {
                                return '<button class="btn btn-icon btn-info btn-xs" onclick="viewIt(' +row.id+ ')">View</button>'; 
                            } else {
                                return '<button class="btn btn-icon btn-info btn-xs" onclick="viewIt(' +row.id+ ')">View</button>'; 
                            }
                        }
                    }
                ]
            });
        });
        
        function viewIt(id) {
            var link = "{{ route('detail', [':param', ':id']) }}";
	        link = link.replace(':id', id);
	        link = link.replace(':param', 'tenor');
            window.location.replace(link);
        }

        $('#upload').click(function(){
            document.getElementById("upload").disabled = true;
            $.post("{{ route('add-list-tenor') }}", {
                payment   : $('#payment').val(),
                _token    : '{{ Session::token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){        
                        swal("Success!", datanotif.rcdesc, "success");
                        objTable.data.ajax.reload();
                        $("#payment").val("");
                        document.getElementById("upload").disabled = false;
                    } else {
                        swal("Error!", datanotif.rcdesc, "error");
                        $("#payment").val("");
                        document.getElementById("upload").disabled = false;
                    }
                }
            });
        });
        
        function editIt(id, stat) {
            $.post("{{ route('update-data') }}", {
                id   : id,
                data   : 'tenor',
                stat    : stat,
                _token    : '{{ Session::token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){        
                        swal("Success!", datanotif.rcdesc, "success");
                        objTable.data.ajax.reload();
                        $("#payment").val("");
                    } else {
                        swal("Error!", datanotif.rcdesc, "error");
                    }
                }
            });
        }
    </script>