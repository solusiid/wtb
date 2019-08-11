
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="WTB Admin Panel by solusiID">
    <meta name="author" content="Solusi Indonesia Digital">
    <title>Login WTB</title>
    <link rel="apple-touch-icon" href="{{ asset('assets/images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('global/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('global/css/bootstrap-extend.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/site.min.css') }}">
    <link rel="stylesheet" href="{{ asset('global/vendor/animsition/animsition.css') }}">
    <link rel="stylesheet" href="{{ asset('global/vendor/asscrollable/asScrollable.css') }}">
    <link rel="stylesheet" href="{{ asset('global/vendor/switchery/switchery.css') }}">
    <link rel="stylesheet" href="{{ asset('global/vendor/intro-js/introjs.css') }}">
    <link rel="stylesheet" href="{{ asset('global/vendor/slidepanel/slidePanel.css') }}">
    <link rel="stylesheet" href="{{ asset('global/vendor/flag-icon-css/flag-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('global/vendor/waves/waves.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/examples/css/pages/login.css') }}">
    <link rel="stylesheet" href="{{ asset('global/fonts/material-design/material-design.min.css') }}">
    <link rel="stylesheet" href="{{ asset('global/fonts/brand-icons/brand-icons.min.css') }}">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    <script src="{{ asset('global/vendor/breakpoints/breakpoints.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
      Breakpoints();
    </script>
</head>
<body class="animsition page-login layout-full page-dark">
    <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">>
      	<div class="page-content vertical-align-middle">
	        <div class="brand">
	          	<h2 class="brand-text">WANT TO BUY</h2>
	        </div>
        	<p>SIGN INTO YOUR PAGES ACCOUNT</p>
	        <form method="post" action="login.html">
	          	<div class="form-group form-material floating" data-plugin="formMaterial">
		            <input type="email" class="form-control empty" id="inputEmail" name="email">
		            <label class="floating-label" for="inputEmail">Email</label>
	          	</div>
	          	<div class="form-group form-material floating" data-plugin="formMaterial">
		            <input type="password" class="form-control empty" id="inputPassword" name="password" onkeypress="return runScript(event)">
		            <label class="floating-label" for="inputPassword">Password</label>
	          	</div>
	          	<button type="button" id="solusiid_masuk" class="btn btn-primary btn-block">Sign in</button>
	        </form>

        	<footer class="page-copyright page-copyright-inverse">
          	<p>DEVELOP BY SOLUSI INDONESIA DIGITAL</p>
          	<p>© 2019 WTB. All RIGHT RESERVED.</p>
        	</footer>
      	</div>
    </div>
    <script src="{{ asset('global/vendor/babel-external-helpers/babel-external-helpers.js') }}"></script>
    <script src="{{ asset('global/vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('global/vendor/popper-js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('global/vendor/bootstrap/bootstrap.js') }}"></script>
    <script src="{{ asset('global/vendor/animsition/animsition.js') }}"></script>
    <script src="{{ asset('global/vendor/mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('global/vendor/asscrollbar/jquery-asScrollbar.js') }}"></script>
    <script src="{{ asset('global/vendor/asscrollable/jquery-asScrollable.js') }}"></script>
    <script src="{{ asset('global/vendor/ashoverscroll/jquery-asHoverScroll.js') }}"></script>
    <script src="{{ asset('global/vendor/waves/waves.js') }}"></script>
    
    <!-- Plugins -->
    <script src="{{ asset('global/vendor/switchery/switchery.js') }}"></script>
    <script src="{{ asset('global/vendor/intro-js/intro.js') }}"></script>
    <script src="{{ asset('global/vendor/screenfull/screenfull.js') }}"></script>
    <script src="{{ asset('global/vendor/slidepanel/jquery-slidePanel.js') }}"></script>
    <script src="{{ asset('global/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>
    
    <!-- Scripts -->
    <script src="{{ asset('global/js/Component.js') }}"></script>
    <script src="{{ asset('global/js/Plugin.js') }}"></script>
    <script src="{{ asset('global/js/Base.js') }}"></script>
    <script src="{{ asset('global/js/Config.js') }}"></script>
    
    <script src="{{ asset('assets/js/Section/Menubar.js') }}"></script>
    <script src="{{ asset('assets/js/Section/GridMenu.js') }}"></script>
    <script src="{{ asset('assets/js/Section/Sidebar.js') }}"></script>
    <script src="{{ asset('assets/js/Section/PageAside.js') }}"></script>
    <script src="{{ asset('assets/js/Plugin/menu.js') }}"></script>
    
    <script src="{{ asset('global/js/config/colors.js') }}"></script>
    <script src="{{ asset('assets/js/config/tour.js') }}"></script>
    
    <!-- Page -->
    <script src="{{ asset('assets/js/Site.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/asscrollable.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/slidepanel.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/switchery.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/jquery-placeholder.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/material.js') }}"></script>
    
    <script>
      	(function(document, window, $){
        	'use strict';
    
        	var Site = window.Site;
        	$(document).ready(function(){
          	Site.run();
        	});
      	})(document, window, jQuery);

        function runScript(e) {
            if (e.keyCode == 13) {
                login();
            }
        }
        
        function login() {
            document.getElementById("solusiid_masuk").disabled = true;
            $.post("{{ route('do-login') }}", {
                email  : $('#inputEmail').val(),
                password  : $('#inputPassword').val(),
                _token    : '{{ Session::token() }}'
            },
            function(data, status){
                if(data) {
                    var datanotif = JSON.parse(data);
                    if(datanotif.rc == '00'){        
                  		window.location.replace("{{route('dashboard')}}");
              		} else {
                		swal("Error!", datanotif.messages, "error");
                        document.getElementById("solusiid_masuk").disabled = false;
              		}
                }
            });
        }
      	$('#solusiid_masuk').click(function(){
      		login();
      	});
    </script>
</body>
</html>
