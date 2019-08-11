	
	<div class="page">
      	<div class="page-content container-fluid">
        	<div class="row">
	          	<div class="col-lg-12">
	            	<div class="panel">
	              		<div class="panel-body">
	              			<div class="form-group form-material col-md-12">
	                          	<label class="form-control-label" for="name">Choose category you want</label>
	                          	<select class="form-control" multiple data-plugin="select2" id="category">
	                          		<option value="NULL"> - Select Category - </option>
	                          		@foreach($category as $value)
	                          		<option value="{{ $value->id }}">{{ $value->name_sub_cat }}</option>
	                          		@endforeach
	                          	</select>
	                        </div>
	              			<div class="form-group form-material col-md-12">
	                          	<label class="form-control-label" for="name">Choose brand you want</label>
	                          	<select class="form-control" multiple data-plugin="select2" id="brand">
	                          		<option value="NULL"> - Select Brand - </option>
	                          	</select>
	                        </div>
	                        <div class="form-group form-material col-md-12">
	                        	<button type="button" id="save_setting" class="btn btn-primary">Save</button>
	                        </div>
	              		</div>
	            	</div>
	          	</div>
        	</div>
      	</div>
    </div>
    
    <script>
    	$(document).ready(function(){
	    	$('#category').on('select2:select', function (e) {
	            if($('#category').val() != 'NULL') {
	                var url = "{{ route('api-brand-choose') }}";
	                $.post(url, { provinsi : $('#category').val(), _token: "{{ csrf_token() }}" })
	                .done(function(data) {
	                //alert( "Data Loaded: " + data );
	                var data_arr = JSON.parse(data);
	                $('#brand').html('');
	                $('#brand')
	                    .append($('<option>', { value : 'NULL' })
	                    .text('- Select Brand -'));
	                    data_arr.forEach(function(x) {
	                        $('#brand')
	                        .append($('<option>', { value : x.id })
	                        .text(x.name_merk));
	                    });
	                });
	            } else {
	                $('#brand').html('');
	                $('#brand')
	                    .append($('<option>', { value : 'NULL' })
	                    .text('- Select Brand -'));
	            }
	        });
	   	});

	   	$('#save_setting').click(function(){
	   		$.post("{{ route('api-adm-setting') }}", {
                category  	: $('#category').val(),
                brand  		: $('#brand').val(),
                _token    	: '{{ Session::token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){        
                    	swal("Success!", datanotif.rcdesc, "success");
              		} else {
                		swal("Error!", datanotif.rcdesc, "error");
              		}
                }
            });
	   	});
    </script>