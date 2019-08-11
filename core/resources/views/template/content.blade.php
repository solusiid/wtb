@include('template.header')
@include('template.menu')
@if(!empty($page))
   @include($page)
@endif
@include('template.footer')