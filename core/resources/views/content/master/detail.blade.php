	<link rel="stylesheet" href="{{ asset('assets/examples/css/pages/profile.css') }}">
	<div class="page">
	    <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Master</li>
                <li class="breadcrumb-item active">{{ $path_name }}</li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
      	<div class="page-content container-fluid">
        	<div class="row">
	          	<div class="col-lg-12">
	            	<div class="panel">
	              		<div class="panel-body">
	              			<form autocomplete="off">
	              			    @if($param_nya == 'mcategory')
	              			    <div class="row">
    	              			    <div class="form-group form-material col-md-12">
    		                            <label class="form-control-label" for="email">Main Category</label>
    		                            <input type="text" class="form-control" id="main_category" name="main_category" value="{{ $name_nya }}"  />
    		                        </div>
    		                    </div>
		                        @elseif($param_nya == 'category')
		                        <div class="row">
    	              			    <div class="form-group form-material col-md-6">
    		                            <label class="form-control-label" for="email">Main Category</label>
    			                          <select id="cat_id" class="form-control" data-plugin="select2">
    			                          @foreach($parent as $value)
    			                            @if($value->id == $parent_id)
    			                            <option value="{{ $value->id }}" selected>{{ $value->name_cat }}</option>
    			                            @else
    			                            <option value="{{ $value->id }}">{{ $value->name_cat }}</option>
    			                            @endif
    			                          @endforeach
    			                          </select>
    		                        </div>
    	              			    <div class="form-group form-material col-md-6">
    		                            <label class="form-control-label" for="email">Category</label>
    		                            <input type="text" class="form-control" id="category" name="category" value="{{ $name_nya }}"  />
    		                        </div>
    		                    </div>
		                        @elseif($param_nya == 'brand')
		                        <div class="row">
		                            <div class="form-group form-material col-md-6">
    		                            <label class="form-control-label" for="email">Category</label>
    			                          <select id="subcat_id" class="form-control" data-plugin="select2">
    			                          @foreach($parent as $value)
    			                            @if($value->id == $parent_id)
    			                            <option value="{{ $value->id }}" selected>{{ $value->name_sub_cat }}</option>
    			                            @else
    			                            <option value="{{ $value->id }}">{{ $value->name_sub_cat }}</option>
    			                            @endif
    			                          @endforeach
    			                          </select>
    		                        </div>
    	              			    <div class="form-group form-material col-md-6">
    		                            <label class="form-control-label" for="email">Brand</label>
    		                            <input type="text" class="form-control" id="brand" name="brand" value="{{ $name_nya }}"  />
    		                        </div>
		                        </div>
		                        @elseif($param_nya == 'model')
		                        <div class="row">
		                            <div class="form-group form-material col-md-6">
    		                            <label class="form-control-label" for="email">Category</label>
    			                          <select id="merk_id" class="form-control" data-plugin="select2">
    			                          @foreach($parent as $value)
    			                            @if($value->id == $parent_id)
    			                            <option value="{{ $value->id }}" selected>{{ $value->name_merk }}</option>
    			                            @else
    			                            <option value="{{ $value->id }}">{{ $value->name_merk }}</option>
    			                            @endif
    			                          @endforeach
    			                          </select>
    		                        </div>
    	              			    <div class="form-group form-material col-md-6">
    		                            <label class="form-control-label" for="email">Model</label>
    		                            <input type="text" class="form-control" id="model" name="model" value="{{ $name_nya }}"  />
    		                        </div>
    		                    </div>
		                        @elseif($param_nya == 'type')
	              			    <div class="row">
		                            <div class="form-group form-material col-md-6">
    		                            <label class="form-control-label" for="email">Category</label>
    			                          <select id="model_id" class="form-control" data-plugin="select2">
    			                          @foreach($parent as $value)
    			                            @if($value->id == $parent_id)
    			                            <option value="{{ $value->id }}" selected>{{ $value->name_model }}</option>
    			                            @else
    			                            <option value="{{ $value->id }}">{{ $value->name_model }}</option>
    			                            @endif
    			                          @endforeach
    			                          </select>
    		                        </div>
    	              			    <div class="form-group form-material col-md-6">
    		                            <label class="form-control-label" for="email">Type</label>
    		                            <input type="text" class="form-control" id="type" name="type" value="{{ $name_nya }}"  />
    		                        </div>
    		                    </div>
		                        @elseif($param_nya == 'payment')
		                        <div class="row">
		                            <div class="form-group form-material col-md-12">
    		                            <label class="form-control-label" for="email">Payment Method</label>
    		                            <input type="text" class="form-control" id="payment" name="payment" value="{{ $name_nya }}"  />
    		                        </div>
		                        </div>
		                        @elseif($param_nya == 'tenor')
		                        <div class="row">
		                            <div class="form-group form-material col-md-12">
    		                            <label class="form-control-label" for="email">Tenor</label>
    		                            <input type="text" class="form-control" id="tenor" name="tenor" value="{{ $name_nya }}"  />
    		                        </div>
		                        </div>
		                        @elseif($param_nya == 'city')
		                        <div class="row">
		                            <div class="form-group form-material col-md-12">
    		                            <label class="form-control-label" for="email">City</label>
    		                            <input type="text" class="form-control" id="city" name="city" value="{{ $name_nya }}"  />
    		                        </div>
		                        </div>
	              			    @endif
		                      	<div class="form-group form-material">
		                        	<button type="button" id="back_data" class="btn btn-danger">BACK</button>
		                        	<button type="button" id="edit_data" class="btn btn-primary">Edit Data</button>
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
    	$('#edit_data').click(function(){
            document.getElementById("edit_data").disabled = true;
    		$.post("{{ route('update-param') }}", {
                id  		    : '{{ $id_nya }}',
                main_category   : $('#main_category').val(),
                category        : $('#category').val(),
                cat_id          : $('#cat_id').val(),
                brand           : $('#brand').val(),
                subcat_id       : $('#subcat_id').val(),
                model           : $('#model').val(),
                merk_id         : $('#merk_id').val(),
                type            : $('#type').val(),
                model_id        : $('#model_id').val(),
                payment         : $('#payment').val(),
                tenor           : $('#tenor').val(),
                city            : $('#city').val(),
                param  		    : '{{ $param_nya }}',
                _token    	    : '{{ Session::token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){      
                		swal("Success!", datanotif.rcdesc, "success");  
                  		window.location.replace(datanotif.url);
              		} else {
                		swal("Error!", datanotif.rcdesc, "error");
                        document.getElementById("edit_data").disabled = false;
              		}
                }
            });
    	});
    	
    	$('#back_data').click(function(){
    	    var param = '{{ $param_nya }}';
    	    if(param == 'category') {
    	        window.location.replace("{{ route('category') }}");
    	    } else if(param == 'brand') {
    	        window.location.replace("{{ route('brand') }}");
    	    } else if(param == 'model') {
    	        window.location.replace("{{ route('model') }}");
    	    } else if(param == 'type') {
    	        window.location.replace("{{ route('type') }}");
    	    } else if(param == 'mcategory') {
    	        window.location.replace("{{ route('mcategory') }}");
    	    } else if(param == 'payment') {
    	        window.location.replace("{{ route('payment') }}");
    	    } else if(param == 'tenor') {
    	        window.location.replace("{{ route('tenor') }}");
    	    } else if(param == 'city') {
    	        window.location.replace("{{ route('city') }}");
    	    }
    	});
    </script>