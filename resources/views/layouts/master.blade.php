<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>@yield('page_title') | Admin </title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content={{csrf_token()}}>

        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/morris/morris.css') }}">

        <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
        
        <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        
        <link href="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/plugins/datetimepicker/css/datetimepicker.css') }}" rel="stylesheet" type="text/css">
        <link href="https://cdn.plyr.io/3.6.4/plyr.css" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/profile.css') }}" rel="stylesheet" type="text/css">
    </head>


    <body class="fixed-left">

        <!-- <div id="preloader"><div id="status"><div class="spinner"></div></div></div> -->
        <div id="preloader">
            <div class="loading-element">
                <div class="inner one"></div>
                <div class="inner two"></div>
                <div class="inner three"></div>
            </div>
        </div>

        <div id="wrapper">

            @include('layouts.sidebar')

            <div class="content-page">

                <div class="content">

                    @include('layouts.header')

                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-sm-12">
                                    @yield('page_head')

                                    <h5 class="page-title">@yield('page_title')</h5>
                                </div>
                            </div>

                            @yield('content')

                        </div>

                    </div>

                </div>

                @include('layouts.footer')

            </div>

        </div>

        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
        <script src="{{ asset('assets/js/detect.js') }}"></script>
        <script src="{{ asset('assets/js/fastclick.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.blockUI.js') }}"></script>
        <script src="{{ asset('assets/js/waves.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>

        <!--Morris Chart-->
        <!-- <script src="{{ asset('assets/plugins/morris/morris.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/raphael/raphael-min.js') }}"></script> -->
        <script src="{{ asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>

        <!-- dashboard -->
        <!-- <script src="{{ asset('assets/pages/dashboard.js') }}"></script> -->

        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>

        <script src="{{ asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>

        <!-- datatable -->
        <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.j')}}s"></script>

        <script src="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('assets/pages/sweet-alert.init.js') }}"></script>

        <script src="{{ asset('assets/plugins/moment/moment.js') }}"></script>

        <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/datetimepicker/js/datetimepicker.js')}}"></script>
        <script src="https://cdn.plyr.io/3.6.4/plyr.js"></script>
        <script>
            $(document).ready(function() {
                $('form').parsley();
            });
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove();
                });
            }, 3000);
            $(document).ready(function () {
                if($("#answer").length > 0){
                    tinymce.init({
                        selector: "textarea#answer",
                        theme: "modern",
                        height:300,
                        plugins: [
                            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                            "save table contextmenu directionality emoticons template paste textcolor"
                        ],


                    });
                }
            });
            $('#select_all').on('click', function(){
                if($('.select_row').is(':checked')){
                    $('input[type="checkbox"]').prop('checked', false);
                } else {
                    $('input[type="checkbox"]').prop('checked', true);
                }
            });
        </script>
        @stack('page_scripts')
    </body>
</html>
