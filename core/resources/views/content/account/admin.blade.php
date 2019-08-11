    <div class="page">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Account</li>
                <li class="breadcrumb-item active">User Account</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <header class="panel-heading">
                    <div class="panel-actions"></div>
                    <h3 class="panel-title">User Account WTB</h3>
                </header>
                <div class="panel-body">
                    <a href="{{ route('add-member', ['type' => 'user-account']) }}" class="btn btn-icon btn-primary btn-xs">Tambah User Account</a>
                    <table class="table table-hover dataTable table-striped w-full" id="datalist">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Level</th>
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
                    "url": "{{ route('api-list-admin') }}",
                    "dataSrc": ""
                },
                "columns": [
                    { "data" : "id"},
                    { "data" : "name"},
                    { "data" : "email"},
                    { "data" : "grade_desc"},
                    { 
                        mRender: function (data, type, row) {
                            if(row.user_status == '0') {
                                return '<button class="btn btn-icon btn-success btn-xs" onclick="activeIt(' +row.id+ ', 1)">Active</button>';
                            } else {
                                return '<button class="btn btn-icon btn-danger btn-xs" onclick="activeIt(' +row.id+ ', 0)">Deactive</button>';
                            }
                        }
                    },
                    {
                        mRender: function (data, type, row) {
                            return '<button class="btn btn-icon btn-light btn-xs" onclick="editIt(' +row.id+ ')">View</button> | ' +
                            '<button class="btn btn-icon btn-light btn-xs" onclick="deleteIt(' +row.id+ ')">Delete</button>';  
                        }
                    }
                ]
            });
        });
        
        function activeIt(id, status) {
            $.post("{{ route('update-account') }}", {
                id      : id,
                param   : 'admin',
                stat    : status,
                _token  : '{{ Session::token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){        
                        swal("Success!", datanotif.rcdesc, "success");
                        objTable.data.ajax.reload();
                    } else {
                        swal("Error!", datanotif.rcdesc, "error");
                    }
                }
            });
        }
        
        function editIt(id) {
            var link = "{{ route('account-detail', [':param', ':id']) }}";
	        link = link.replace(':id', id);
	        link = link.replace(':param', 'user-account');
            window.location.replace(link);
        }

        function deleteIt(id) {
            $.post("{{ route('api-delete-user') }}", {
                id      : id,
                _token  : '{{ Session::token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){        
                        swal("Success!", datanotif.rcdesc, "success");
                        objTable.data.ajax.reload();
                    } else {
                        swal("Error!", datanotif.rcdesc, "error");
                    }
                }
            });
        }
    </script>