            $(document).ready(function() {
                "use strict";
                // This Page Javascript
                $('input, textarea').placeholder();
                /* team bxslider Start */
                $('.teamslider').bxSlider({
                    controls: false,
                    auto: true,
                    mode: 'vertical',
                    pagerCustom: '#bx-pager',
                    slideMargin: 0,
                });
                /* team bxslider End */

                /* popup vimeo **/
        $('.popup-vimeo').magnificPopup({
          disableOn: 700,
          type: 'iframe',
          mainClass: 'mfp-fade',
          removalDelay: 160,
          preloader: false,

          fixedContentPos: false
        });
                /* popup vimeo end **

                /* For Fit Vimeo Youtube Videos Target your .container, .wrapper, .post, etc.*/
                $(".featured_image, .responsive_video").fitVids();

                /* Testimonials 3D slider Start */
                $('#dg-container').gallery({
                    current: 0,
                    // index of current item
                    autoplay: false,
                    // slideshow on / off
                    interval: 2000
                            // time between transitions
                });
                /* Testimonials 3D slider End */

                /* Slider on Blog Posts as Gallery Starts */
                $(".rslides").responsiveSlides({
                    auto: true,
                    pager: true,
                    nav: true,
                    speed: 500,
                    maxwidth: 800,
                    prevText: "",
                    nextText: "",
                    namespace: "transparent-btns"
                });
                /* Slider on Blog Posts as Gallery Ends */

                /* Google Map Loading */
                $('#map_contact').gmap3({
                    map: {
                        options: {
                            maxZoom: 18,
                            mapTypeId: "folio_map",
                            mapTypeControlOptions: {
                                mapTypeIds: ["folio_map", google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.SATELLITE, google.maps.MapTypeId.TERRAIN]
                            }
                        }
                    },
                    styledmaptype: {
                        id: "folio_map",
                        options: {
                            name: "Sincapp Map"
                        },
                        styles: [
                            {
                                featureType: "all",
                                elementType: "all",
                                stylers: [
                                    {saturation: -100},
                                ]
                            }
                        ]
                    },
                    marker: {
                        address: "Ufuktepe Mah. Sevenler Sk. No:6 Keçiören/Ankara",
                        options: {
                            icon: new google.maps.MarkerImage(
                                    base_url + "files/home/images/map_marker_orange.png",
                                    new google.maps.Size(40, 40, "px", "px")
                                    )
                        }
                    },
                },
                        "autofit");
            });