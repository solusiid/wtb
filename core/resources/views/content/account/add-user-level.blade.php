	<link rel="stylesheet" href="{{ asset('assets/examples/css/pages/profile.css') }}">
	<div class="page">
	    <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Account</li>
                <li class="breadcrumb-item active">Add User Level</li>
            </ol>
        </div>
      	<div class="page-content container-fluid">
        	<div class="row">
	          	<div class="col-lg-12">
	            	<div class="panel">
	              		<div class="panel-body">
	              			<form autocomplete="off" id="form1">
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          	<label class="form-control-label" for="grade_code">Code User Level</label>
			                          	<input type="text" class="form-control" id="grade_code" />
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="grade_desc">User Level</label>
			                          <input type="text" class="form-control" id="grade_desc"/>
			                        </div>
		                      	</div>
		                      	<div class="form-group form-material">
		                        	<label class="form-control-label" for="alamat">Access Menu Master</label><br>
		                      	    @foreach($user_level as $value)
		                      	    <input type="checkbox" name="scripts" id="scripts" value="{{ $value->id }}"> {{ $value->menu_param }}<br>
		                      	    @endforeach
		                      	</div>
		                      	<div class="form-group form-material">
		                        	<label class="form-control-label" for="alamat">Access Menu Account</label><br>
		                      	    @foreach($user_level1 as $value)
		                      	    <input type="checkbox" name="scripts1" id="scripts1" value="{{ $value->id }}"> {{ $value->menu_param }}<br>
		                      	    @endforeach
		                      	</div>
		                      	<div class="form-group form-material">
		                        	<label class="form-control-label" for="alamat">Access Menu Request</label><br>
		                      	    @foreach($user_level2 as $value)
		                      	    <input type="checkbox" name="scripts2" id="scripts2" value="{{ $value->id }}"> {{ $value->menu_param }}<br>
		                      	    @endforeach
		                      	</div>
		                      	<div class="form-group form-material">
		                        	<label class="form-control-label" for="alamat">Access Menu System</label><br>
		                      	    @foreach($user_level3 as $value)
		                      	    <input type="checkbox" name="scripts3" id="scripts3" value="{{ $value->id }}"> {{ $value->menu_param }}<br>
		                      	    @endforeach
		                      	</div>
		                      	<div class="form-group form-material">
		                      	    <a href="{{ route('user-grade') }}" class="btn btn-icon btn-danger">Cancel</a>
		                        	<button type="button" id="edit_data" class="btn btn-primary">Add User Level</button>
		                      	</div>
		                    </form>
	              		</div>
	            	</div>
	          	</div>
        	</div>
      	</div>
    </div>
	<script src="{{ asset('global/js/Plugin/responsive-tabs.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/tabs.js') }}"></script>
    <script>
        function get_selected_checkboxes_array(){ 
            var ch_list=Array(); 
            $("input:checkbox[name=scripts]:checked").each(function(){
                ch_list.push($(this).val());
            }); 
            return ch_list; 
        }
        function get_selected_checkboxes_array1(){ 
            var ch_list=Array(); 
            $("input:checkbox[name=scripts1]:checked").each(function(){
                ch_list.push($(this).val());
            }); 
            return ch_list; 
        }
        function get_selected_checkboxes_array2(){ 
            var ch_list=Array(); 
            $("input:checkbox[name=scripts2]:checked").each(function(){
                ch_list.push($(this).val());
            }); 
            return ch_list; 
        }
        function get_selected_checkboxes_array3(){ 
            var ch_list=Array(); 
            $("input:checkbox[name=scripts3]:checked").each(function(){
                ch_list.push($(this).val());
            }); 
            return ch_list; 
        }
        $('#edit_data').click(function(){
            var menu = get_selected_checkboxes_array();
            var menu1 = get_selected_checkboxes_array1();
            var menu2 = get_selected_checkboxes_array2();
            var menu3 = get_selected_checkboxes_array3();
            document.getElementById("edit_data").disabled = true;
            $.post("{{ route('add-list-grade') }}", {
                grade_code  : $('#grade_code').val(),
                grade_desc  : $('#grade_desc').val(),
                access_menu : menu,
                access_menu1 : menu1,
                access_menu2 : menu2,
                access_menu3 : menu3,
                _token      : '{{ Session::token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){        
                        swal("Success!", datanotif.rcdesc, "success");
                        window.location.replace("{{ route('user-grade') }}");
                    } else {
                        swal("Error!", datanotif.rcdesc, "error");
                    }
                }
            });
        });
    </script>