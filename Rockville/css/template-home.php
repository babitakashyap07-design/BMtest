<?php
/* Template Name: Homepage */
get_header();
$banner = get_field('banner');
$hide_overlay = get_field('hide_overlay');
$text_repeater = get_field('text_repeater');
$compare = ">=";
$show_meeting ="future";
$orderby = 'ASC';   
$date_now = converToTz(date('Y-m-d H:i:s'), "America/New_York", 'Y-m-d');
$banner_icon = get_field('banner_icon');
$transit_service_heading = get_field('transit_service_heading');
$transit_service_repeater = get_field('transit_service_repeater');
$insta_shortcode = get_field('insta_shortcode');
//$newsleftimg = get_field('news_image');
?>
<?php if($banner):?>
    <div class="main_banner" id="page_content">
        <div id="demo" class="carousel slide " data-ride="carousel" data-interval="false">
            <!-- The slideshow -->
            <div class="carousel-inner">
                <?php 
				$count = 1;
				foreach($banner as $bimage):
				$banner_image = $bimage['select_image'];
				$slide_link = $bimage['link'];
				?>
                <div class="carousel-item <?php if($count == 1){?><?php echo 'active';?><?php } ?>">
                    <?php if($banner_image){?>
                        <?php if($slide_link){?>
                        <a href="<?php echo $slide_link['url'];?>" target="<?php echo $slide_link['target'];?>">
                        <?php } ?>
                            <img src="<?php echo $banner_image['url'];?>" alt="<?php echo $banner_image['alt'];?>">
                        <?php if($slide_link){?>
                        </a>
                        <?php } ?>
                    <?php } ?>
                </div>
                <?php $count++; endforeach; wp_reset_query();?>
            </div>
			  <div class="tripPlanner_wrap">
            <div class="tripPlanner">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab1">Trip Planner</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab2">Rider Alerts</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane  active" id="tab1">
                        <form action="//www.google.com/maps" class="transit-form" method="get" target="_blank">
                            <div class="search_wrap">
                                <div class="form-group start">
                                    <label class="start" for="start">START</label>
                                    <input autocomplete="off" class="input-text form-control" id="start" name="saddr"
                                        type="text" value="" placeholder="Address/Stop/Landmark" required>
                                </div>

                                <div class="form-group end">
                                    <label class="end" for="end">END</label>
                                    <input autocomplete="off" class="input-text form-control" id="end" name="daddr"
                                        type="text" value="" placeholder="Address/Stop/Landmark" required>
                                </div>

                                <div class="form-group">
                                    <div class="radiobuttons">
                                        <div class="rdio rdio-primary radio-inline"> 
                                            <input name="ttype" value="dep" id="radio1" type="radio">
                                            <label for="radio1">DEPART AT</label>
                                        </div>
                                        <div class="rdio rdio-primary radio-inline">
                                            <input name="ttype" value="arr" id="radio2" type="radio" checked>
                                            <label for="radio2">ARRIVE BY</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group date_time">
                                    <div class="date_time_wrap d-flex">
                                        <div class="dt_col">
                                            <label class="end" for="fdate">DATE</label>
                                            <input type="text" maxlength="100" class="route_date form-control"
											value="<?php echo $date = current_time('m/d', $gmt = 0); //echo date('m/d/Y'); ?>"
											name="date" id="fdate"
											placeholder="<?php echo $date = current_time('m/d', $gmt = 0); //echo date('m/d/Y'); ?>">
                                        </div>
                                        <div class="dt_col">
                                            <label class="end" for="ftime">TIME</label>
                                            <input type="text" class="route_time form-control" maxlength="100"
											value="<?php echo $time = current_time('g:ia', $gmt = 0); //echo date('g:ia'); ?>"
											name="time" id="ftime"
											placeholder="<?php echo $time = current_time('g:ia', $gmt = 0); //echo date('g:ia'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="go_btn">
                                    <input name="ie" type="hidden" value="UTF8">
                                    <input name="f" type="hidden" value="d">
                                    <input class="sort" name="sort" type="hidden" value="def"> <input class="dirflg"
                                        name="dirflg" type="hidden" value="r">
                                    <input name="hl" type="hidden" value="en">
                                    <input class="maia-button tripPlanSubmit btn_sm" id="direction-submit" type="submit"
                                        value="Go!" data-g-event="Maia: Button"
                                        data-g-action="Maia: Primary � Content" data-g-label="Maia: (empty)">
                                    <!--<input class="tripPlanSubmit darkBlueBtn" value="GO" type="submit">-->
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane  fade" id="tab2">
                        <div class="alertlists">
                            <?php
                            $alerts = getAlerts('all');

                            foreach ($alerts as $alert) {
                                ?>
                                <div class="alertrow">
                                    <h4>ROUTES AFFECTED:
                                        <?= implode(", ", $alert['affected_routes']); ?>
                                    </h4>
                                    <p>
                                        <?= $alert['title']; ?>
                                        <?= !empty($alert['link']) ? '<a href="' . $alert['link'] . '"> LEARN MORE </a>' : ''; ?>
                                    </p>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="gobtn">
                            <a href="<?= site_url('service-alerts') ?>" class="btn_sm">VIEW ALL ALERTS</a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
			
        </div>
    </div>
<?php endif;?>
<?php if($banner_icon):?>
    <div class="nav_section">
        <div class="container">
            <div class="navBlock row no-margin">
                <?php 
                //$count = 1;
                foreach($banner_icon as $icon):
                $banner_icon = $icon['banner_icon'];
                $icon_heading = $icon['icon_heading'];
                $icon_content = $icon['icon_content'];
                $icon_link = $icon['icon_link'];
                $size = 'gen_img';
                $thumb = $banner_icon['sizes'][ $size ];
                ?>
                <div class="navcol">
                    <a href="<?php echo $icon_link['url'];?>" target="<?php echo $icon_link['target'];?>">
                        <div class="navBlock_col">
                            <?php if($banner_icon){?>
                            <div class="navblock_icon">
                                <img src="<?php echo esc_url($thumb);?>" alt="<?php echo $banner_icon['alt'];?>">
                            </div>
                            <?php } ?>
                            <?php if($icon_heading || $icon_content){?>
                            <div class="navblock_txt">
                                <?php if($icon_heading){?>
                                <h4><?php echo $icon_heading;?></h4>
                                <?php } ?>
                                <?php if($icon_content){?>
                                <p><?php echo $icon_content;?></p>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </a>
                </div>
                <?php endforeach; wp_reset_query();?>
            </div>
        </div>
    </div>
<?php endif;?>
<?php if($transit_service_repeater):?>
    <div class="main-services section-padding">
        <div class="container">
            <?php if($transit_service_heading){?>
            <div class="top-Title text-center ">
                <h2><?php echo $transit_service_heading;?></h2>
            </div>
            <?php } ?>
            <div class="img_button_row row">
                <?php 
                //$count = 1;
                foreach($transit_service_repeater as $tservice):
                $select_video_image = $tservice['select_video_image'];
                $video_heading = $tservice['video_heading'];
                $video_info = $tservice['video_info'];
                $video_link = $tservice['video_link'];
                $size = 'gen_img';
                $thumb = $select_video_image['sizes'][ $size ];
                ?>
                <div class="col-md-4 img_btn_col">
                    <div class="img_block">
                        <a href="<?php echo $video_link['url'];?>" target="<?php echo $video_link['target'];?>">
                            <?php if($select_video_image){?>
                                <img src="<?php echo esc_url($thumb);?>" alt="<?php echo $banner_icon['alt'];?>">
                            <?php } ?>
                            <?php if($video_heading){?>
                            <div class="img_block_title">
                                <h3><?php echo $video_heading;?></h3>
                            </div>
                            <?php } ?>
                            <?php if($video_heading || $video_info){?>
                            <div class="img_block_descr">
                                <?php if($video_heading){?>
                                <h3><?php echo $video_heading;?></h3>
                                <?php } ?>
                                <?php if($video_info){?>
                                <p><?php echo $video_info;?></p>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </a>
                    </div>
                </div>
                <?php endforeach; wp_reset_query();?>
            </div>
        </div>
    </div>
<?php endif;?>

<?php
$next_args = array(
'post_type' => 'post',
'post_status' => 'publish',
'posts_per_page'=> 4,
'meta_key' => '_is_ns_featured_post', 
'meta_value' => 'yes',
'order'=>'DESC',
'orderby'=>'date'
);
$the_query = new WP_Query( $next_args );
?>
<?php if ( $the_query->have_posts() ) : ?> 
    <section class="NewsMettings gray">
        <div class="container">
            <div class="top-Title text-center ">
                <h2>Latest News</h2>
            </div>
            <div class="row newsRowMain">
                <?php
                while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $imgID  = get_post_thumbnail_id($post->ID);
                $img    = wp_get_attachment_image_src($imgID,'img_text', false, ''); 
                //$img1    = wp_get_attachment_image_src($imgID,'img_text', false, '');
                $imgAlt = get_post_meta($imgID,'_wp_attachment_image_alt', true);
                $excerpt = strip_shortcodes(wp_trim_words( $post->post_excerpt, 30));
                $content = strip_shortcodes(wp_trim_words( $post->post_content, 30));
                $regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";
                ?>
                <div class="col-md-3 mt_card_col">
                    <div class="mt-img-wrap ">
                        <a href="<?php the_permalink();?>">
                            <?php if($img){?>
                            <div class="img_mt_block">
                                <img src="<?php echo $img[0];?>" alt="<?php echo $imgAlt;?>">
                            </div>
                            <?php } ?>
                            <div class="text_mt_block">
                                <h3><?php the_title();?></h3>
                                <h5><?php echo get_the_date('F d, Y'); ?></h5>
                                <?php if($excerpt){?>
                                <p><?php echo preg_replace($regex, ' ', $excerpt);?></p>
                                <?php } elseif($content){?>
                                <p><?php echo preg_replace($regex, ' ', $content);?></p>
                                <?php } ?>
                            </div>
                        </a>
                    </div>
                </div>
                <?php }?>
            </div>
            <div class="allBtn text-center">
                <a href="/news/" class="btn_sm">ALL NEWS</a>
            </div>
        </div>
    </section>
<?php endif; wp_reset_postdata();?>
    <?php if($insta_shortcode){?>
        <section class="follow-us">
            <?php echo do_shortcode($insta_shortcode);?>
        </section>
    <?php } else {?>
    <section class="follow-us">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/follow-us.png" style="width: 100%;" alt="">
    </section>
    <?php } ?>
<script>
google.maps.event.addDomListener(window, 'load', function () {
var input = document.getElementById('start');
var input1 = document.getElementById('end');
var autocomplete = new google.maps.places.Autocomplete(input);
var autocomplete1 = new google.maps.places.Autocomplete(input1);
});
</script>
<?php get_footer();?>