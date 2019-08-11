    <footer class="site-footer">
        <div class="site-footer-legal">© 2019 WTB</div>
        <div class="site-footer-right">
            Develop by <a href="https://solusiid.com">Solusi Indonesia Digital</a>
        </div>
    </footer>

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
    <script src="{{ asset('global/vendor/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('global/vendor/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('global/vendor/datatables.net-fixedheader/dataTables.fixedHeader.js') }}"></script>
    <script src="{{ asset('global/vendor/datatables.net-fixedcolumns/dataTables.fixedColumns.js') }}"></script>
    <script src="{{ asset('global/vendor/datatables.net-rowgroup/dataTables.rowGroup.js') }}"></script>
    <script src="{{ asset('global/vendor/datatables.net-scroller/dataTables.scroller.js') }}"></script>
    <script src="{{ asset('global/vendor/datatables.net-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('global/vendor/datatables.net-responsive-bs4/responsive.bootstrap4.js') }}"></script>
    <script src="{{ asset('global/vendor/datatables.net-buttons/dataTables.buttons.js') }}"></script>
    <script src="{{ asset('global/vendor/datatables.net-buttons/buttons.html5.js') }}"></script>
    <script src="{{ asset('global/vendor/datatables.net-buttons/buttons.flash.js') }}"></script>
    <script src="{{ asset('global/vendor/datatables.net-buttons/buttons.print.js') }}"></script>
    <script src="{{ asset('global/vendor/datatables.net-buttons/buttons.colVis.js') }}"></script>
    <script src="{{ asset('global/vendor/datatables.net-buttons-bs4/buttons.bootstrap4.js') }}"></script>
    <script src="{{ asset('global/vendor/asrange/jquery-asRange.min.js') }}"></script>
    <script src="{{ asset('global/vendor/bootbox/bootbox.js') }}"></script>
    
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
    <script src="{{ asset('global/js/Plugin/datatables.js') }}"></script>

    <script src="{{ asset('assets/examples/js/tables/datatable.js') }}"></script>
    <script src="{{ asset('assets/examples/js/uikit/icon.js') }}"></script>
    <script>
        $(document).ready(function () {
            getNotif();
        });
        setInterval(function() {
            //getMenu();
        }, 1000);
        function getMenu() {
           $.post("{{ route('api-list-menu') }}", {
                id : "{{ Auth::user()->id }}",
                _token : '{{ Session::token() }}'
            }, function(data, status) {
                if(data) {
                    $("#menu_utama").html(data);
                }
            }); 
        }
        function getNotif() {
            $.post("{{ route('total-notif') }}", {
                id : "{{ Auth::user()->id }}",
                _token : '{{ Session::token() }}'
            }, function(data, status) {
                if(data) {
                    $("#form_data").html(data);
                }
            });
        }
    </script>

    <script src="{{ asset('global/vendor/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('global/vendor/bootstrap-tokenfield/bootstrap-tokenfield.min.js') }}"></script>
    <script src="{{ asset('global/vendor/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('global/vendor/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('global/vendor/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('global/vendor/switchery/switchery.js') }}"></script>
    <script src="{{ asset('global/vendor/asrange/jquery-asRange.min.js') }}"></script>
    <script src="{{ asset('global/vendor/ionrangeslider/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('global/vendor/asspinner/jquery-asSpinner.min.js') }}"></script>
    <script src="{{ asset('global/vendor/clockpicker/bootstrap-clockpicker.min.js') }}"></script>
    <script src="{{ asset('global/vendor/ascolor/jquery-asColor.min.js') }}"></script>
    <script src="{{ asset('global/vendor/asgradient/jquery-asGradient.min.js') }}"></script>
    <script src="{{ asset('global/vendor/ascolorpicker/jquery-asColorPicker.min.js') }}"></script>
    <script src="{{ asset('global/vendor/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>
    <script src="{{ asset('global/vendor/jquery-knob/jquery.knob.js') }}"></script>
    <script src="{{ asset('global/vendor/bootstrap-touchspin/bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('global/vendor/jquery-labelauty/jquery-labelauty.js') }}"></script>
    <script src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('global/vendor/timepicker/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('global/vendor/datepair/datepair.min.js') }}"></script>
    <script src="{{ asset('global/vendor/datepair/jquery.datepair.min.js') }}"></script>
    <script src="{{ asset('global/vendor/jquery-strength/password_strength.js') }}"></script>
    <script src="{{ asset('global/vendor/jquery-strength/jquery-strength.min.js') }}"></script>
    <script src="{{ asset('global/vendor/multi-select/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('global/vendor/typeahead-js/bloodhound.min.js') }}"></script>
    <script src="{{ asset('global/vendor/typeahead-js/typeahead.jquery.min.js') }}"></script>
    <script src="{{ asset('global/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/select2.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/bootstrap-tokenfield.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/bootstrap-select.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/icheck.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/switchery.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/asrange.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/ionrangeslider.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/asspinner.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/clockpicker.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/ascolorpicker.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/bootstrap-maxlength.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/jquery-knob.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/bootstrap-touchspin.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/card.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/jquery-labelauty.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/jt-timepicker.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/datepair.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/jquery-strength.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/multi-select.js') }}"></script>
    <script src="{{ asset('global/js/Plugin/jquery-placeholder.js') }}"></script>

    <script src="{{ asset('assets/examples/js/forms/advanced.js') }}"></script>
</body>
</html>