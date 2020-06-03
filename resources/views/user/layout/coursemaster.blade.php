<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    @include('user.layout.top')
</head>
<body>

    <!-- Left Panel -->
        @include('user.layout.coursenavigation')
    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
            @include('user.layout.header')
        <!-- Header-->
            @yield('content')
    </div><!-- /#right-panel -->

    <!-- Right Panel -->

   @include('user.layout.bottom')
</body>
</html>
