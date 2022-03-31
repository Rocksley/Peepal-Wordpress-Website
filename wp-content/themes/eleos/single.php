<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package eleos
 */

get_header('other'); ?>

<!-- subheader begin -->
<div class="section padding-top-big-bottom background-color-grey">  
    <div class="container"> 
        <div class="twelve columns" data-scroll-reveal="enter bottom move 100px over 1s after 0.1s">
            <div class="section-title">
            <?php $format = get_post_format(); ?>
            <?php while(have_posts()) : the_post(); ?>
                <h2><?php the_title(); ?></h2>   
                <?php if($format == 'image'){ ?>         
                <div class="shadow-title"><?php esc_html_e('image post', 'eleos'); ?></div> 
                <?php } elseif($format == 'gallery') { ?>                      
                <div class="shadow-title"><?php esc_html_e('gallery post', 'eleos'); ?></div> 
                <?php } elseif($format == 'audio') { ?>                       
                <div class="shadow-title"><?php esc_html_e('audio post', 'eleos'); ?></div> 
                <?php } elseif($format == 'video') { ?>                      
                <div class="shadow-title"><?php esc_html_e('video post', 'eleos'); ?></div> 
                <?php } ?>
            <?php endwhile;?>
            </div>
        </div>
        <div class="clear"></div>
<!-- subheader close -->

<!-- content begin -->
        <div class="eight columns">
                <?php while(have_posts()) : the_post(); ?> 
                    <div class="page-content">
                        <?php get_template_part( 'content', ( post_type_supports( get_post_type(), 'post-formats' ) ? get_post_format() : get_post_type() ) ); ?>                              
                    </div>
                    <?php wp_link_pages(); ?>                 
                <?php endwhile;?>
                                                                
                <div class="comm-number background-color-white">

                    <p> <?php comments_number( '0 comments', '1 comments', '% comments' ); ?>  <?php if(has_tag()) { ?><span><?php the_tags(' ', ' ' ); ?></span> <span> <?php esc_html_e('tags:', 'eleos'); ?> </span> <?php } ?></p>
                
                </div>

                <?php comments_template();?>  
        </div>
        <div class="four columns">
            <div class="sidebar background-color-white">                
        	   <?php get_sidebar();?>
            </div>
        </div>
        <div class="twelve columns" data-scroll-reveal="enter bottom move 100px over 1s after 0.1s">
            
            <div class="project-links"> 
            
                <?php $prev_post = get_adjacent_post(false, '', true); $next_post = get_adjacent_post(false, '', false); ?>
                <?php if($prev_post) { ?><a href="<?php echo get_permalink($prev_post->ID); ?>"><div class="link-project-block left"> <?php esc_html_e('prev', 'eleos'); ?> </div> </a><?php } ?>
                <?php if($next_post) { ?><a href="<?php echo get_permalink($next_post->ID); ?>"><div class="link-project-block right"> <?php esc_html_e('next', 'eleos'); ?> </div> </a><?php } ?>
            
            </div>

        </div>
    </div>
</div>
<!-- content close -->
	
<?php get_footer(); ?>
