<script src="{{ asset('teacher/assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="{{ asset('teacher/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/main.js') }}"></script>


    <script src="{{ asset('teacher/assets/js/lib/chart-js/Chart.bundle.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/widgets.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/lib/vector-map/jquery.vmap.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/lib/vector-map/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/lib/vector-map/jquery.vmap.sampledata.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/lib/vector-map/country/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/lib/chosen/chosen.jquery.min.js') }}"></script>

<!-- home -->
    <script href="{{ asset('home/lib/jquery/jquery.min.js') }}"></script>
  <script href="{{ asset('home/lib/jquery/jquery-migrate.min.js') }}"></script>
  <script href="{{ asset('home/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script href="{{ asset('home/lib/easing/easing.min.js') }}"></script>
  <script href="{{ asset('home/lib/superfish/hoverIntent.js') }}"></script>
  <script href="{{ asset('home/lib/superfish/superfish.min.js') }}"></script>
  <script href="{{ asset('home/lib/wow/wow.min.js') }}"></script>
  <script href="{{ asset('home/lib/owlcarousel/owl.carousel.min.js') }}"></script>
  <script href="{{ asset('home/lib/magnific-popup/magnific-popup.min.js') }}"></script>
  <script href="{{ asset('home/lib/sticky/sticky.js') }}"></script>



  <script href="{{ asset('home/contactform/contactform.js') }}"></script>
  <script href="{{ asset('home/js/main.js') }}"></script>

<!-- Home -->

    <script>
        ( function ( $ ) {
            "use strict";

            jQuery( '#vmap' ).vectorMap( {
                map: 'world_en',
                backgroundColor: null,
                color: '#ffffff',
                hoverOpacity: 0.7,
                selectedColor: '#1de9b6',
                enableZoom: true,
                showTooltip: true,
                values: sample_data,
                scaleColors: [ '#1de9b6', '#03a9f5' ],
                normalizeFunction: 'polynomial'
            } );
        } )( jQuery );


        ( function ( $ ) {
            jQuery(".myselect").chosen({
                disable_search_threshold: 10,
                no_results_text: "Oops...nothing found!",
                width: "100%",
                max_selected_options: 2
            });
            
        } )( jQuery );

        $(document).ready(function() {
            $('#bootstrap-data-table').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
        } );
       
    </script>