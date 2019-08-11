    <div class="page">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Master</li>
                <li class="breadcrumb-item active">Model Item</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <header class="panel-heading">
                    <div class="panel-actions"></div>
                    <h3 class="panel-title">Upload Model Item</h3>
                </header>
                <div class="panel-body">
                    <input type="file" id="file" class="dropify-event" accept=".csv, .xlsx" onChange="readURL(this);" />
                    <button class="btn btn-icon btn-primary" id="upload" disabled>Upload File</button> 
                </div>
            </div>
            <div class="panel">
                <header class="panel-heading">
                    <div class="panel-actions"></div>
                    <h3 class="panel-title">Model Item WTB</h3>
                </header>
                <div class="panel-body">
                    <a href="{{ route('tambah-data', ['id'=>'model']) }}" class="btn btn-icon btn-primary btn-xs">Tambah Model Item</a>
                    <table class="table table-hover dataTable table-striped w-full" id="datalist">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Model</th>
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
                    "url": "{{ route('api-list-model') }}",
                    "dataSrc": ""
                },
                "columns": [
                    { "data" : "id"},
                    { "data" : "name_model"},
                    { 
                        mRender: function (data, type, row) {
                            if(row.stat_model == '0') {
                                return '<button class="btn btn-icon btn-success btn-xs" onclick="editIt(' +row.id+ ', 1)">Active</button>';
                            } else {
                                return '<button class="btn btn-icon btn-danger btn-xs" onclick="editIt(' +row.id+ ', 0)">Deactive</button>';
                            }
                        }
                    },
                    {
                        mRender: function (data, type, row) {
                            if(row.stat_model == '1') {
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
	        link = link.replace(':param', 'model');
            window.location.replace(link);
        }

        $('#upload').click(function(){
            var filePath = $("#file").val(); 
            var file_ext = filePath.substr(filePath.lastIndexOf('.')+1, filePath.length);
            if(file_ext != 'csv' && file_ext != 'xlsx') {
                swal("Sorry!", "You can upload file only csv!", "error");
            } else {
                document.getElementById("upload").disabled = true;
                var uploadFile = document.getElementById("file");
                var fd = new FormData();
                fd.append( "fileInput", $("#file")[0].files[0]);
                fd.append( "_token", "{{ Session::token() }}");
                $.ajax({
                    url: "{{ route('upload-list-model') }}",
                    data: fd,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function(data, status){
                        var datanotif = JSON.parse(data);
                        if(datanotif.rc == '00') {
                            swal("Success!", datanotif.rcdesc, "success");
                            objTable.data.ajax.reload();
                            $("#file").val("");
                            document.getElementById("upload").disabled = false;
                        } else {
                            swal("Failed!", datanotif.rcdesc, "danger");
                        }
                    },
                    error: function(err){
                        //alert(err);
                    }
                });
            }
        });
        
        function editIt(id, stat) {
            $.post("{{ route('update-data') }}", {
                id   : id,
                data   : 'model',
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
        
        function readURL(input) {
            document.getElementById("upload").disabled = false;
        }
    </script>