	<link rel="stylesheet" href="{{ asset('assets/examples/css/pages/profile.css') }}">
	<div class="page">
	    <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Master</li>
                <li class="breadcrumb-item active">{{ $path_name }}</li>
                <li class="breadcrumb-item active">{{ $page_name }}</li>
            </ol>
        </div>
      	<div class="page-content container-fluid">
        	<div class="row">
	          	<div class="col-lg-12">
	            	<div class="panel">
	              		<div class="panel-body">
	              			<form autocomplete="off">
	              			    @if($param == 'city')
	              			    <div class="row">
			                        <div class="form-group form-material col-md-12">
			                          <label class="form-control-label" for="email">City</label>
			                          <input type="text" class="form-control" id="name_kota" name="name_kota"  />
			                        </div>
		                      	</div>
		                      	@elseif($param == 'type')
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="email">Model</label>
			                          <select id="model_id" class="form-control" data-plugin="select2">
			                          @foreach($model as $value)
			                            <option value="{{ $value->id }}">{{ $value->name_model }}</option>
			                          @endforeach
			                          </select>
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="email">Type</label>
			                          <input type="text" class="form-control" id="name_type" name="name_type"  />
			                        </div>
		                      	</div>
		                      	@elseif($param == 'model')
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="email">Brand</label>
			                          <select id="merk_id" class="form-control" data-plugin="select2">
			                          @foreach($merk as $value)
			                            <option value="{{ $value->id }}">{{ $value->name_merk }}</option>
			                          @endforeach
			                          </select>
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="email">Model</label>
			                          <input type="text" class="form-control" id="name_model" name="name_model"  />
			                        </div>
		                      	</div>
		                      	@elseif($param == 'brand')
		                      	<div class="row">
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="email">Category</label>
			                          <select id="subcat_id" class="form-control" data-plugin="select2">
			                          @foreach($category as $value)
			                            <option value="{{ $value->id }}">{{ $value->name_sub_cat }}</option>
			                          @endforeach
			                          </select>
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="email">Brand</label>
			                          <input type="text" class="form-control" id="name_merk" name="name_merk"  />
			                        </div>
		                      	</div>
		                      	@elseif($param == 'category')
		                      	<div class="row">
		                      	    <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="email">Main Category</label>
			                          <select id="cat_id" class="form-control" data-plugin="select2">
			                          @foreach($mcategory as $value)
			                            <option value="{{ $value->id }}">{{ $value->name_cat }}</option>
			                          @endforeach
			                          </select>
			                        </div>
			                        <div class="form-group form-material col-md-6">
			                          <label class="form-control-label" for="email">Category</label>
			                          <input type="text" class="form-control" id="name_sub_cat" name="name_sub_cat"  />
			                        </div>
		                      	</div>
		                      	@elseif($param == 'mcategory')
		                      	<div class="row">
			                        <div class="form-group form-material col-md-12">
			                          <label class="form-control-label" for="email">Main Category</label>
			                          <input type="text" class="form-control" id="name_mcat" name="name_mcat"  />
			                        </div>
		                      	</div>
	              			    @endif
		                      	<div class="form-group form-material">
		                        	<button type="button" id="back_data" class="btn btn-danger">BACK</button>
		                        	<button type="button" id="edit_data" class="btn btn-primary">Tambah Data</button>
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
    		$.post("{{ route('tambahdataadd') }}", {
                name_kota  	: $('#name_kota').val(),
                model_id  	: $('#model_id').val(),
                name_type  	: $('#name_type').val(),
                merk_id  	: $('#merk_id').val(),
                name_model  : $('#name_model').val(),
                subcat_id   : $('#subcat_id').val(),
                name_merk   : $('#name_merk').val(),
                cat_id      : $('#cat_id').val(),
                name_mcat   : $('#name_mcat').val(),
                name_sub_cat   : $('#name_sub_cat').val(),
                param  		: '{{ $param }}',
                _token    	: '{{ Session::token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){      
                		swal("Success!", datanotif.rcdesc, "success");  
                  		window.location.replace(datanotif.url);
              		} else {
                		swal("Error!", datanotif.rcdesc, "error");
              		}
                }
            });
    	});
    	
    	$('#back_data').click(function(){
    	    var param = '{{ $param }}';
    	    if(param == 'category') {
    	        window.location.replace("{{ route('category') }}");
    	    } else if(param == 'brand') {
    	        window.location.replace("{{ route('brand') }}");
    	    } else if(param == 'model') {
    	        window.location.replace("{{ route('model') }}");
    	    } else if(param == 'type') {
    	        window.location.replace("{{ route('type') }}");
    	    } else if(param == 'city') {
    	        window.location.replace("{{ route('city') }}");
    	    }
    	})
    </script>