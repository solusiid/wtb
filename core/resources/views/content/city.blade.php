    <div class="page">
        <div class="page-content">
            <div class="panel">
                <header class="panel-heading">
                    <div class="panel-actions"></div>
                    <h3 class="panel-title">Upload City</h3>
                </header>
                <div class="panel-body">
                    <input type="file" id="file" class="dropify-event" accept=".csv, .xlsx" />
                    <button class="btn btn-icon btn-primary" id="upload">Upload City</button> 
                </div>
            </div>
            <div class="panel">
                <header class="panel-heading">
                    <div class="panel-actions"></div>
                    <h3 class="panel-title">City WTB</h3>
                </header>
                <div class="panel-body">
                    <table class="table table-hover dataTable table-striped w-full" id="datalist">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
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
                    "url": "{{ route('api-list-city') }}",
                    "dataSrc": ""
                },
                "columns": [
                    { "data" : "id"},
                    { "data" : "name_kota"},
                    { "data" : "stat_kota"},
                    {
                        mRender: function (data, type, row) {
                            return '<button class="btn btn-icon btn-light btn-xs" onclick="editIt(' +row.id+ ')">View</button> ' +
                                    '<button class="btn btn-icon btn-light btn-xs" onclick="addIt(' +row.id+ ')">Edit</button> '; 
                        }
                    }
                ]
            });
        });

        $('#upload').click(function(){
            var filePath = $("#file").val(); 
            var file_ext = filePath.substr(filePath.lastIndexOf('.')+1, filePath.length);
            if(file_ext != 'csv' && file_ext != 'xlsx') {
                swal("Sorry!", "You can upload file only csv!", "error");
            } else {
                var uploadFile = document.getElementById("file");
                var fd = new FormData();
                fd.append( "fileInput", $("#file")[0].files[0]);
                fd.append( "_token", "{{ Session::token() }}");
                $.ajax({
                    url: "{{ route('upload-list-city') }}",
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
    </script>