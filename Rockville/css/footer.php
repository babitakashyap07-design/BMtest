<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage planeteriaweb
 * @since planeteriaweb 1.0
 */

?>
<?php
$footer_logo = get_field('footer_logo', 'option');
$footer_adress = get_field('footer_adress', 'option');
$footer_link = get_field('footer_link', 'option'); ?>

<footer class="footer">
    <div class="container">
        <div class="footer-row row">
            <div class="foot_col left_col">
                <div class="footmenu">
                    <h3>Doing Business With Us</h3>
                        <?php wp_nav_menu(array("menu" => "Doing Business With Us", 'container'  => false, 'echo'  => true, 'items_wrap'  => '<ul id="%1$s" class="%2$s">%3$s</ul>', 'depth'  => 10)); ?>
                    <h3>Who We Are</h3>
                        <?php wp_nav_menu(array("menu" => "Who We Are", 'container'  => false, 'echo'  => true, 'items_wrap'  => '<ul id="%1$s" class="%2$s">%3$s</ul>', 'depth'  => 10)); ?>
                </div>
            </div>
            <?php if($footer_logo){?>
            <div class="foot_col center_col">
                <div class="foot_logo">
                    <a href="<?php echo $footer_link['url'];?>" target="<?php echo $footer_link['target'];?>"><img src="<?php echo $footer_logo['url'];?>" alt="<?php echo $footer_logo['alt'];?>"></a>
                </div>
            </div>
            <?php } else {?>
            <div class="foot_col center_col">
                <div class="foot_logo">
                    <a href="<?php echo site_url("/");?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/footer-logo.svg" alt="logo"></a>
                </div>
            </div>
            <?php } ?>
            <div class="foot_col right_col">
                <div class="foot_right">
                    <?php if($footer_adress){?>
                        <?php echo $footer_adress;?>
                    <?php } ?>
                    <div class="footmenu">
                        <?php wp_nav_menu(array("menu" => "Footer Right Menu", 'container'  => false, 'echo'  => true, 'items_wrap'  => '<ul id="%1$s" class="%2$s">%3$s</ul>', 'depth'  => 10)); ?>
                    </div>
                    <div class="foot_media">
                        <?php wp_nav_menu( array("menu" => "Social Menu", 'container'  => false, 'echo'  => true, 'items_wrap'  => '<ul id="%1$s" class="%2$s">%3$s</ul>','depth'  => 10, 'walker' => new fluent_themes_custom_walker_nav_menu) );?>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <p>Copyright <?php echo date('Y');?> SORTA-METRO</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
<script type="text/javascript" src="https://addevent.com/libs/atc/1.6.1/atc.min.js" async defer></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
<script data-account="ioxTnBjlFl" src="https://accessibilityserver.org/widget.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
    $(function() {
        //https://getdatepicker.com/4/
        $('.route_date').datetimepicker({
            format: 'MM/DD/YY'
        });
        $('.route_time').datetimepicker({
            format: 'hh:mma'
        });
    });
</script>
<script>
$(".buttonsearch").click(function () {
    $(this).closest('div').find('.orig').focus();
});
</script>

<script>
    $(".close").click(function() {
        Cookies.set("setco", 1);
        //Cookies.set("setcotrue1",  true,  time()+86400);
    });
    $(window).on('load', function() {
        var cokk = Cookies.get("setco");
        console.log(cokk);
        if (cokk != 1) {
            $(".alert-area").show();
        }
    });
</script>


<script type="text/javascript">
    var map;
    (function($) {
        /*
         *  render_map
         *  This function will render a Google Map onto the selected jQuery element
         */
        function render_map($el) {
            // var
            var $markers = $el.find('.marker');
            // Add custom data-zoom
            window.gmapzoom = parseInt($markers.attr('data-zoom'));
            window.commzoom = parseInt($markers.attr('data-zoom'));

            if (isNaN(window.gmapzoom)) {
                window.gmapzoom = 16;
            }
            if (isNaN(window.commzoom)) {
                window.commzoom = 10;
            }

            // debugger;
            // vars
            var previousMarker;
            // vars
            if ($("body.page-id-338").length > 0) {
                var args = {
                    zoom: window.gmapzoom,
                    center: new google.maps.LatLng(0, 0),
                    scrollwheel: false,
                    mapTypeId: google.maps.MapTypeId.SATELLITE
                };
            } else {
                var args = {
                    zoom: window.gmapzoom,
                    center: new google.maps.LatLng(0, 0),
                    scrollwheel: false,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
            }
            // create map
            map = new google.maps.Map($el[0], args);
            $(document).trigger("map_ready");
            // add a markers reference
            map.markers = [];
            // add markers
            $markers.each(function() {
                add_marker($(this), map);
            });
            // center map
            center_map(map);
        }

        // create info window outside of each - then tell that singular infowindow to swap content based on click
        var infowindow = new google.maps.InfoWindow({
            content: '',
            pixelOffset: new google.maps.Size(0, 500)
        });

        /*
         *  add_marker
         *  This function will add a marker to the selected Google Map
         */

        var infoWindows = [];

        function add_marker($marker, map) {

            // var
            var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));
            var title = $marker.data('title');

            // create marker
            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: title,
                icon: "/wp-content/themes/planeteriaweb/img/marker-red.svg"
            });

            // add to array
            map.markers.push(marker);

            // if marker contains HTML, add it to an infoWindow
            if ($marker.html()) {
                // create info window
                var infoWindow = new google.maps.InfoWindow({
                    content: $marker.html()
                });

                infoWindows.push(infoWindow);

                // show info window when marker is clicked
                google.maps.event.addListener(marker, 'click', function() {

                    //close all
                    for (var i = 0; i < infoWindows.length; i++) {
                        infoWindows[i].close();
                    }

                    infoWindow.open(map, marker);
                });

                google.maps.event.addListener(map, 'click', function() {
                    infoWindow.close();
                });
            }

        }

        /*
         *  center_map
         *  This function will center the map, showing all markers attached to this map
         */
        function center_map(map) {

            if (map.markers.length == 0) {
                return;
            }
            // vars
            var bounds = new google.maps.LatLngBounds();
            // loop through all markers and create bounds
            $.each(map.markers, function(i, marker) {
                var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
                bounds.extend(latlng);
            });
            // only 1 marker?
            if (map.markers.length == 1) {
                // set center of map
                map.setCenter(bounds.getCenter());
                map.setZoom(window.gmapzoom);
                if ($("body.single-community").length > 0) {
                    map.setZoom(window.commzoom);
                }
            } else {
                // fit to bounds
                map.fitBounds(bounds);
            }
        }

        /*
         *  document ready
         *  This function will render each map when the document is ready (page has loaded)
         */
        $(document).ready(function() {
            $('.acf-map').each(function() {
                render_map($(this));
            });
        });

    })(jQuery);


    /*
     *  hide markers
     *  This function will show all the markers that have the filtered type
     */
    function filterMarkers(type) {
        for (var i = 0; i < map.markers.length; i++) {
            var one_marker = map.markers[i];
            console.log(one_marker);
            var typetax = one_marker.type.split(" ");
            if (!one_marker.getVisible() && typetax.indexOf(type) != -1) {
                one_marker.setVisible(true);
            }
        }
    }

    /*
     *  hide markers
     *  This function will hide all the markers on the map
     */
    function hideMarkers() {
        for (var i = 0; i < map.markers.length; i++) {
            var one_marker = map.markers[i];
            one_marker.setVisible(false);
            console.log('hiding');
        }
    }
    /*
     *  show markers
     *  This function will show all the markers on the map
     */
    function showMarkers() {
        for (var i = 0; i < map.markers.length; i++) {
            var one_marker = map.markers[i];
            one_marker.setVisible(true);
            console.log('showing');
        }
    }
    /*
    $('.gm-ui-hover-effect').click(function(){
        $(".acf-map").click();
    });*/
</script>
<script>
    $(document).on("scroll", function() {
        if ($(document).scrollTop() > 0) {
            $(".main_header").addClass("shrink");
            $("body").addClass("bodyshrink");

        } else {
            $(".main_header").removeClass("shrink");
            $("body").removeClass("bodyshrink");

        }
    });
</script>
<script>
    (function($) {
        /* $('.accordion_event > li:eq(0) .acco_title').addClass('active').next().slideDown();*/

        $('.meetingBox').click(function(j) {
            var dropDown = $(this).closest('.meetingBoxblock').find('.meeting-panel-info');

            $(this).closest('.meetingRow').find('.meeting-panel-info').not(dropDown).slideUp();

            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                $(this).closest('.meetingRow').find('.meetingBox.active').removeClass('active');
                $(this).addClass('active');
            }

            dropDown.stop(false, true).slideToggle();

            j.preventDefault();
        });
    })(jQuery);
</script>



<script>
    (function($) {
        /* $('.accordion_event > li:eq(0) .acco_title').addClass('active').next().slideDown();*/

        $('.accordion_era .main_acco_title').click(function(j) {
            var dropDown = $(this).closest('.accordion_block').find('.acco_panel');

            $(this).closest('.accordion_era').find('.acco_panel').not(dropDown).slideUp();

            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                $(this).closest('.accordion_era').find('.main_acco_title.active').removeClass('active');
                $(this).addClass('active');
            }

            dropDown.stop(false, true).slideToggle();

            j.preventDefault();
        });
    })(jQuery);
</script>







<script>
  
(function($, window) {
        var adjustAnchor = function() {

            var $anchor = $(':target'),
                    fixedElementHeight = 150;

            if ($anchor.length > 0) {

                $('html, body')
                    .stop()
                    .animate({
                        scrollTop: $anchor.offset().top - fixedElementHeight
                    }, 200);
					window.scrollTo(0, $anchor.offset().top -  fixedElementHeight ) ;

            }

        };

        $(window).on('hashchange load', function() {
            adjustAnchor();
        });

    })(jQuery, window);
</script>



<!--

<script>
    $(document).ready(function() {
        $("#input_3_3, #input_14_8, #input_17_5, #field_9_4, #input_9_7, #input_33_11,#field_37_1,#input_19_6,#input_18_3,#input_11_5,#input_11_12,#input_11_13,#input_25_1,#input_12_21,#field_26_3,#input_27_1,#field_8_9,#input_40_16,#input_24_1,#input_23_6,#input_35_1,#input_13_1,#input_31_5,#input_39_3,#input_39_9,#input_10_1,#field_40_7,#field_40_16,#input_16_10,#input_53_3,#input_22_4,#input_22_7,#input_22_9").keypress(function(e) {
            if (!(/^[ A-Za-z]*$/.test(e.key))) {
                e.preventDefault();
            }
        });

        $('#input_3_3').on('input', function() {
            $(this).val($(this).val().replace(/[^A-Za-z\s]/gi, ''));
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#input_3_5, #input_4_3, #input_14_9, #input_17_3, #input_9_6, #input_9_9, #field_33_9,#input_18_6,#input_11_15,#input_12_24,#input_26_4,#input_27_4,#input_8_12,#input_8_16,#input_29_11,#input_30_7,#input_40_19,#input_24_3,#input_23_11,#input_35_4,#field_13_3,#input_36_6,#input_31_7,#input_39_7,#input_39_12,#input_16_9,#input_53_7,#input_22_6,#input_22_11,#input_7_11").keypress(function(e) {
            if (!(/^[ A-Za-z0-9.@_-]*$/.test(e.key))) {
                e.preventDefault();
            }
        });
    });
</script>


<script>
    $('#ajaxsearchpro1_1 , #input_3_3 , #input_3_5, #input_14_1 ').bind("cut copy paste", function(e) {
        e.preventDefault();
    });
</script>
<script>
    $(document).ready(function() {
        $("#input_9_10_5,#input_25_8,#input_27_6_5,#input_8_6_5,#input_8_10_5,#input_29_10_5,#input_40_17_5,#input_23_9,#input_23_10,#input_35_3,#input_13_4,#input_36_7,#input_36_20,#input_36_18,#input_36_19").keypress(function(e) {
            if (!(/^[ 0-9]*$/.test(e.key))) {
                e.preventDefault();
            }
        });
    });
</script>


<script>
    $(document).ready(function() {
        $("#input_19_11, #input_19_16, #input_18_15, #input_18_19").keypress(function(e) {
            if (!(/^[ A-Za-z0-9.,@!$*&_-]*$/.test(e.key))) {
                e.preventDefault();
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#input_57_15, #input_57_19, #input_7_3, #input_8_4, #input_51_17, #input_51_5_1, #input_51_5_2, #input_51_5_3, #input_51_5_4, #input_51_5_5, #input_51_10, #input_51_11, #input_51_13, #input_51_14, #input_51_16, #input_51_8, #input_51_3_3, #input_51_3_6, #input_17_1_3, #input_17_1_6, #input_17_4, #input_17_16, #input_17_7, #input_17_17, #input_17_9, #input_36_23, #input_36_16_1, #input_36_16_2, #input_36_16_3, #input_36_16_4, #input_36_16_5, #input_36_23, #input_29_5, #input_29_6, #input_29_7, #input_29_9_3, #input_29_9_6, #input_29_10_1, #input_29_10_2, #input_29_10_3, #input_29_10_4, #input_29_10_5, #input_29_8, #input_50_1, #input_50_3, #input_50_4, #input_50_6, #input_50_8, #input_44_1_3, #input_44_1_6, #input_44_4, #input_44_5_1, #input_44_5_2, #input_44_5_3, #input_44_5_5, #input_44_3, #input_4_1, #input_4_13, #input_4_3, #input_4_9, #input_4_16, #input_4_8, #input_41_3, #input_41_5, #input_41_4_1, #input_41_4_2, #input_41_4_3, #input_41_4_4, #input_41_4_5, #input_14_1, #input_14_13, #input_14_4, #input_14_6_3, #input_14_6_6, #input_14_7, #input_14_8, #input_14_9, #input_24_1_3, #input_24_1_6, #input_24_3, #input_24_16_3, #input_24_16_6, #input_20_5, #input_20_6, #input_20_8, #input_20_12, #input_20_14, #input_20_17_3, #input_20_17_6, #input_20_18, #input_20_19, #input_20_20_1, #input_20_20_2, #input_20_20_3, #input_20_20_5, #input_11_1_1, #input_11_1_2, #input_11_1_3, #input_11_1_5, #input_11_3, #input_11_6, #input_11_12_3, #input_11_12_6, #input_11_13, #input_11_14_1, #input_11_14_2, #input_11_14_3, #input_11_14_5, #input_23_6_3, #input_23_6_6, #input_23_7_1, #input_23_7_2, #input_23_7_3, #input_23_7_4, #input_23_7_5, #input_23_9, #input_23_10, #input_23_11, #input_23_12, #input_22_3_1, #input_22_3_2, #input_22_3_3, #input_22_3_5, #input_22_4_3, #input_22_4_6, #input_22_5, #input_22_7_3, #input_22_7_6, #input_22_8, #input_22_9_3, #input_22_9_6, #input_22_10, #input_22_12_1, #input_22_12_2, #input_22_12_3, #input_22_12_5, #input_22_13, #input_22_15, #input_22_16, #input_22_17, #input_22_18, #input_22_19, #input_40_7_3, #input_40_7_6, #input_40_14, #input_40_16_3, #input_40_16_6, #input_40_17_1, #input_40_17_2, #input_40_17_3, #input_40_17_5, #input_28_11, #input_35_1_3, #input_35_1_6, #input_35_7, #input_32_1, #input_32_3_3, #input_32_3_6, #input_32_5, #input_32_8, #input_32_6, #input_32_9, #input_32_13, #input_38_1_3, #input_38_1_6, #input_38_3_1, #input_38_3_2, #input_38_3_3, #input_38_3_5, #input_38_6, #input_38_5, #input_38_8, #input_38_10, #input_38_9, #input_38_11, #input_38_13, #input_38_14, #input_38_15, #input_53_3_3, #input_53_3_4, #input_53_3_6, #input_12_1_1, #input_12_1_2, #input_12_1_3, #input_12_1_5, #input_12_1, #input_12_4, #input_12_5, #input_12_6, #input_12_8, #input_12_9, #input_12_12, #input_12_20, #input_12_22, #input_12_23, #input_12_21_3, #input_12_22_1, #input_12_22_2, #input_12_22_3, #input_12_22_5, #input_27_1_3, #input_27_1_6, #input_27_3, #input_27_5, #input_27_6, #input_27_6_1, #input_27_6_2, #input_27_6_3, #input_27_6_5, #input_37_1_3, #input_37_1_6, #input_37_7, #input_37_8, #input_7_6_1, #input_7_6_3, #input_7_8_3, #input_7_8_6, #input_16_1, #input_16_4, #input_16_5, #field_16_6, #input_16_6_1, #input_16_6_2, #input_16_6_3, #input_16_6_5, #input_16_10_3, #input_16_10_6, #input_52_3_1, #input_52_3_5, #input_52_4, #input_52_6_1, #input_52_6_2, #input_52_6_3, #input_52_7, #input_52_10, #input_52_11, #input_52_15, #input_15_3_3, #input_15_3_6, #input_15_11, #input_15_6, #input_15_7_1, #input_15_7_2, #input_15_7_3, #input_13_1_3, #input_13_1_6, #input_13_5_1, #input_13_5_2, #input_13_5_3, #input_13_11, #input_43_1_3, #input_43_1_6, #input_43_5, #input_43_6_1, #input_43_6_2, #input_43_6_3, #input_43_3, #input_45_1_3, #input_45_1_6, #input_45_4_1, #input_45_4_2, #input_45_4_3, #input_45_6, #input_45_8, #input_46_1_3, #input_46_1_6, #input_46_4_1, #input_46_4_2, #input_46_4_3, #input_46_3, #input_46_6, #input_9_4_3, #input_9_4_6, #input_9_7_3, #input_9_7_6, #input_9_10_1, #input_9_10_2, #input_9_10_3, #input_9_10_5, #input_9_14, #input_9_17, #input_19_3, #input_19_10, #input_19_4, #input_19_7, #input_19_13, #input_19_6_3, #input_19_6_6, #input_19_7_1, #input_19_7_2, #input_19_7_3, #input_19_7_5, #input_25_1_3, #input_25_1_6, #input_25_3, #input_25_4_1, #input_25_4_2, #input_25_4_3, #input_25_4_5, #input_25_6_1, #input_25_6_2, #input_25_6_3, #input_25_6_5, #input_25_8, #input_25_10, #input_31_9, #input_31_4, #input_31_5_3, #input_31_5_6, #input_39_2_1, #input_39_2, #input_39_13, #input_39_14, #input_39_19, #input_39_23, #input_39_24, #input_39_25, #input_39_26, #input_39_28, #input_39_2_2, #input_39_3_3, #input_39_3_6, #input_39_9_3, #input_39_13_1, #input_39_13_2, #input_39_31, #input_8_5, #input_8_6, #input_8_8, #input_8_11, #input_8_10, #input_8_14, #input_8_15, #input_8_18, #input_8_6_1, #input_8_6_3, #input_8_9_3, #input_8_9_6, #input_8_10_1, #input_8_10_3, #input_8_14_3, #input_8_14_6, #input_55_1_3, #input_55_1_6, #input_55_3, #input_55_4, #input_55_5_1, #input_55_5_2, #input_55_5_3, #input_55_8, #input_54_1_3, #input_54_1_6, #input_54_3, #input_54_4, #input_54_5_1, #input_54_5_2, #input_54_5_3, #input_54_8, #input_26_3_3, #input_26_3_6, #input_26_6, #input_26_7, #input_26_8, #input_33_8, #input_33_11_3, #input_33_11_6, #input_30_3, #input_30_4, #input_30_5, #input_30_6, #input_30_8, #input_30_9, #input_30_10, #input_30_11, #input_30_14, #input_57_3_3, #input_57_3_6, #input_57_12, #input_57_13, #input_57_14, #input_49_1, #input_49_5, #input_4_8 ,#input_17_1, #input_17_4, #input_17_7 , #input_17_8, #input_9_5, #input_9_10, #input_9_14, #input_37_3, #input_37_4, #input_37_7, #input_37_8, #input_25_3, #input_25_4, #input_25_6, #input_11_1, #input_11_14, #input_26_5, #input_26_6, #input_26_7, #input_26_8, #input_29_4, #input_29_9, #input_29_10,#field_40_17, #input_40_18, #input_24_16, #input_23_7, #input_23_12, #input_35_5, #input_17_9, #input_13_5, #input_13_11, #input_4_13, #input_4_12, #input_4_16, #field_36_1, #input_18_5, #input_18_12, #input_18_13, #input_18_14, #input_18_18, #input_11_3, #input_11_6").keypress(function(e) {
            if (!(/^[ A-Za-z0-9.,@!$*&_-'?]*$/.test(e.key))) {
                e.preventDefault();
            }
        });
    });
</script>

-->
<script>
    $(document).ready(function() {
        $("#input_62_5_5, #input_65_6_5, #input_65_10_5").attr('maxlength', '5');
    });
</script>


<script>
    $(document).ready(function() {
        $('[data-toggle="popover"]').popover({
            placement: 'top',
            html: true,
            title: 'User Info <a href="#" class="close" data-dismiss="alert">&times;</a>',
            content: '<div class="media"><img src="images/avatar-tiny.jpg" class="mr-3" alt="Sample Image"><div class="media-body"><h5 class="media-heading">Jhon Carter</h5><p>Excellent Bootstrap popover! I really love it.</p></div></div>'
        });
        $(document).on("click", ".popover .close", function() {
            $(this).parents(".popover").popover('hide');
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('img[src$="file.PNG"]').attr('src', '/wp-content/themes/planeteriaweb/img/Donate.png');
    });
</script>

<script>
    $(".expand_det  h6 ").matchHeight({
        byRow: true,
        property: 'height',
        target: null,
        remove: false
    });
	$(".event_box   .event_det ").matchHeight({
        byRow: true,
        property: 'height',
        target: null,
        remove: false
    });
		$(".img_text_card_col .text_card_block ").matchHeight({
        byRow: true,
        property: 'height',
        target: null,
        remove: false
    });
</script>


<script>
    $(document).ready(function() {
        $("#menu-main-menu li.dropFirst").append($(".routes-mega-menu").html());
        $(".routes-mega-menu").remove();
    });
</script>

<script>
    $(document).ready(function() {
        if (jQuery(window).width() < 1200) {
            $('.navbar-nav  > li.menu-item-has-children, .navbar-nav  > li.megamenu_item   ').append('<div class="plusMinus"></div>');
            jQuery(".navbar-nav  > li.menu-item-has-children  > .plusMinus , .navbar-nav  > li.megamenu_item  > .plusMinus").click(function() {
                //jQuery(".show-mobile").slideToggle('fast');
                //jQuery(this).parent().siblings('li').find('ul.sub-menu').slideUp("fast");
                //jQuery(this).parent().siblings('li').find('.plus-minus').removeClass("minusIcon");
                $(this).parent().find('.dropdown-menu ,.megamenu_drop,.megamenu').slideToggle("fast");
                $(this).parent().toggleClass('activeBlue');
                $(this).toggleClass("minsicon");
            });
           
			
         $(".social_media ").insertAfter('.nav_bottom  ');

            $('.megamenu_drop  li.menu-item-has-children  ').append('<div class="pls_minus"></div>');

            jQuery(".megamenu_drop  li.menu-item-has-children  .pls_minus").click(function() {
                $(this).parent().find('.sub-menu').slideToggle("fast");
                $(this).parent().toggleClass('active-item');
                $(this).toggleClass("minus-info");
            });

        }
       

        /*if (jQuery(window).width() < 992 ) {
        $('.navbar-nav  > li.megamenu_item   ').append('<div class="plusMinus"></div>');
        jQuery(".navbar-nav  > li.megamenu_item   > .plusMinus").click( function () {
        $(this).parent().find('.megamenu').slideToggle("fast");
        $(this).parent().toggleClass('activeBlue');
        $(this).toggleClass("minsicon");
        });
        }
        */
        $(".navbar-toggler").on("click", function() {
            $(this).toggleClass("active");
            $('.main_header').toggleClass("headerActive");
        });


        $('.dropdown-menu  > li.menu-item-has-children').append('<div class="plus-minus"></div>');
        jQuery(".dropdown-menu   > li.menu-item-has-children  > .plus-minus").click(function() {
            jQuery(this).parent().find('.mega-submenu').slideToggle("fast");
            jQuery(this).parent().siblings('li').find('ul.mega-submenu').slideUp("fast");
            jQuery(this).parent().siblings('li').find('.plus-minus').removeClass("minus-icon");
            jQuery(this).toggleClass("minus-icon");
        });
        $('#buttonsearch').click(function() {
            //$('#formsearch').toggle("'slide', {direction: 'right' }, 1000");
            $("#formsearch").slideToggle('fast');

        });
        $('.sc_close').click(function() {
            $("#formsearch").hide();

        });
	$('.text_card_block .btn_sm  ').parents('.img_text_card_col').find('.text-img-wrap').addClass("has-button ");

        jQuery(".menu-title span").click(function() {

            $(this).parent().parent().find('.foot_menu').slideToggle("fast");
            $(this).parent().toggleClass('active-menu');
            $(this).toggleClass("menu-minus");
        });
		 $('.wp-block-group > table').wrap('<div class="table-wrapper"></div>');
        /*
        	       $('.main_content > *').wrapAll('<div class="main-wrap"></div>');*/
				   if (window.location.hash) {
        // Offset the scroll position to account for the fixed header height
        var offset = $('.advgb-tabs-panel').outerHeight() + 30;
        $('html, body').animate({
            scrollTop: $(window.location.hash).offset().top - offset
        }, 1000);
    }
	  $('.rel_forms').parent(".col_right").addClass("has_forms ");
	   $('.alerticon').parent(".rtTitle").addClass("p-left ");
	  $('a[href$=".pdf"]').each(function() {
    // Open the PDF link in a new window
    $(this).attr('target', '_blank');
  });
  
 // $('.wp-block-image.alignleft,  .wp-block-image.alignright').wrap('<div class="left_right_wraper"></div>');

 
  
$('.carousel-inner').each(function() {
if ($(this).children('div').length === 1) $(this).siblings('.carousel-indicators, .carousel-control-prev, .carousel-control-next').hide();

});
  
    });
	
	$(window).on('resize', function(){
		
		if (jQuery(window).width() < 1200 ) {
 $(".social_media ").insertAfter('.nav_bottom  ');
			
		}
		if (jQuery(window).width() > 1200 ) {
 $(".social_media ").insertBefore('.top_search  ');	
		}
		
    
});

$(window).on('load', function() {
     $('.wp-block-image.alignleft,  .wp-block-image.alignright').wrap('<div class="left_right_wraper"></div>');
});
	
</script>

<script>
    $(document).ready(function() {

        if (typeof($('.main_content  > .wp-block-advgb-adv-tabs .advgb-tabs-panel').offset()) !== "undefined") {
            var fixmeTop = $('.advgb-tabs-panel').offset().top - 90; // get initial position of the element
            $(window).scroll(function() { // assign scroll event listener
                var currentScroll = $(window).scrollTop(); // get current position
                if (currentScroll >= fixmeTop) { // apply position: fixed if you
                    $('.advgb-tabs-panel').addClass('tab_stick');
                } else { // apply position: static
                    $('.advgb-tabs-panel').removeClass('tab_stick');
                }
            });
        }

        if (typeof($('.col_right .dp_sidebar').offset()) !== "undefined") {
            var fixmeTop = $('.col_right .dp_sidebar').offset().top - 90; // get initial position of the element
            $(window).scroll(function() { // assign scroll event listener
                var currentScroll = $(window).scrollTop(); // get current position
                if (currentScroll >= fixmeTop) { // apply position: fixed if you
                    $('.col_right .dp_sidebar').addClass('tab_stick');
                } else { // apply position: static
                    $('.col_right .dp_sidebar').removeClass('tab_stick');
                }
            });
        }
		
		  if (typeof($('.dp_detail_info .wp-block-advgb-adv-tabs .advgb-tabs-panel').offset()) !== "undefined") {
            var fixmeTop = $('.dp_detail_info .wp-block-advgb-adv-tabs .advgb-tabs-panel' ).offset().top - 90; // get initial position of the element
            $(window).scroll(function() { // assign scroll event listener
                var currentScroll = $(window).scrollTop(); // get current position
                if (currentScroll >= fixmeTop) { // apply position: fixed if you
                    $('.dp_detail_info .wp-block-advgb-adv-tabs .advgb-tabs-panel').addClass('tab_stick');
                } else { // apply position: static
                    $('.dp_detail_info .wp-block-advgb-adv-tabs .advgb-tabs').removeClass('tab_stick');
                }
            });
        }

    });
</script>


    <script>
        (function($) {
            /* $('.accordion_event > li:eq(0) .acco_title').addClass('active').next().slideDown();*/
            $('.routeAccdn .rtTitle').click(function(j) {
                var dropDown = $(this).closest('.accoRt_block').find('.accoRtpanel');
                $(this).closest('.routeAccdn').find('.accoRtpanel').not(dropDown).slideUp();

                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    $(this).closest('.routeAccdn').find('.rtTitle.active').removeClass('active');
                    $(this).addClass('active');
                }

                dropDown.stop(false, true).slideToggle();

                j.preventDefault();
            });

            $('.routeAccdn .rtTitle .btn_primary').click(function(j) {
                $('.accoRtpanel').addClass('hiden');
            });



        })(jQuery);

        (function($) {
            /* $('.accordion_event > li:eq(0) .acco_title').addClass('active').next().slideDown();*/

            $('.stpAccdn .stTitle').click(function(j) {
                var dropDown = $(this).closest('.accostp_block').find('.accostpanel');

                $(this).closest('.stpAccdn').find('.accostpanel').not(dropDown).slideUp();

                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    $(this).closest('.stpAccdn').find('.stTitle.active').removeClass('active');
                    $(this).addClass('active');
                }

                dropDown.stop(false, true).slideToggle();

                j.preventDefault();
            });
        })(jQuery);
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    
<script>
$(document).ready(function() {
    $('a[href*=\\#]').on('click', function(e){
       /* e.preventDefault();
        $('html, body').animate({
            scrollTop : $(this.hash).offset().top
        }, 500); */
    });
});
</script>
<script>
$(document).ready(function() {
setTimeout(() => {
console.log("Delayed for 1 second.");
$('#input_64_43').attr('width','300');
$('#input_62_43').attr('width','300');
$('#input_68_14').attr('width','300');
}, "1000");
});
</script>
<script>
	$(document).ready(function() {	
	$("#menu-main-menu li.dropFirst").append($(".routes-mega-menu").html());
	$(".routes-mega-menu").remove();
	$("#menu-main-menu li.dropSecond").append($(".fares-mega-menu").html());
	$(".fares-mega-menu").remove();
	});
	</script>
<script>
$(document).ready(function () {

	setTimeout(function(){
		var hash = window.location.hash
		if(hash!="")
		{
			$("a[href='"+hash+"']").click();
		}
	}, 500)
	$(".advgb-tab a").click(function(){
		var href = $(this).attr("href");
		if(href.indexOf("#") === 0)
		{
			window.location.hash = href;
		}
	})
});
</script>
<script>
jQuery(document).ready(function() {
    var currentUrl = window.location.href;
    jQuery(document).on('click', 'a', function(event) {
        var thishref = jQuery(this).attr('href');
        console.log(thishref)
        if(thishref.indexOf("#form") != -1){
            jQuery('a#form').trigger('click');
        }
    });
});
</script>
</body>
</html>