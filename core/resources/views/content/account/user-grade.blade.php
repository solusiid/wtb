    <div class="page">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Account</li>
                <li class="breadcrumb-item active">User Level</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <header class="panel-heading">
                    <div class="panel-actions"></div>
                    <h3 class="panel-title">User Grade WTB</h3>
                </header>
                <div class="panel-body">
                    <a href="{{ route('add-member', ['type' => 'user-grade']) }}" class="btn btn-icon btn-primary btn-xs">Tambah User Level</a>
                    <table class="table table-hover dataTable table-striped w-full" id="datalist">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Grade Code</th>
                                <th>Grade Desc</th>
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
                    "url": "{{ route('api-list-grade') }}",
                    "dataSrc": ""
                },
                "columns": [
                    { "data" : "id"},
                    { "data" : "grade_code"},
                    { "data" : "grade_desc"},
                    {
                        mRender: function (data, type, row) {
                            return '<button class="btn btn-icon btn-light btn-xs" onclick="editIt(' +row.id+ ')">View</button>' +
                            '<button class="btn btn-icon btn-light btn-xs" onclick="deleteIt(' +row.id+ ')">Delete</button>';
                        }
                    }
                ]
            });
        });
        
        function editIt(id) {
            var link = "{{ route('account-detail', [':param', ':id']) }}";
	        link = link.replace(':id', id);
	        link = link.replace(':param', 'user-grade');
            window.location.replace(link);
        }

        function deleteIt(id) {
            $.post("{{ route('api-delete-grade') }}", {
                id      : id,
                _token  : '{{ Session::token() }}'
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