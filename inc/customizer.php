<?php
/**
 * Amalgamation Theme Customizer.
 *
 * @package Amalgamation
 */

/*
* Front page helper functions
*/

function Amalgamation_Front_Panel_Post($selectedPostId) {
    $my_query = new WP_Query( array ( 'p' => $selectedPostId,) );
    while ( $my_query->have_posts() ) : $my_query->the_post();
        get_template_part( 'template-parts/content', 'front' );
    endwhile; 
}

function Amalgamation_Front_Panel_Page($selectedPageId) {
    $my_query = new WP_Query( array ( 'page_id' => $selectedPageId,) );
    while ( $my_query->have_posts() ) : $my_query->the_post();
        get_template_part( 'template-parts/content', 'front' );
    endwhile; 
}

function Amalgamation_Front_Panel_Latest() {
    echo '<div class="supertitle">Latest Blog Post (<a href="' . esc_url( home_url( '/blog/' ) ) .'">see all</a>)</div>';
    $my_query = new WP_Query( array ( 'post_type' => 'post', 'posts_per_page' => 1, 'ignore_sticky_posts' => 1,) );
    while ( $my_query->have_posts() ) : $my_query->the_post();
        get_template_part( 'template-parts/content', 'front-posts' );
    endwhile;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function amalgamation_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    $wp_customize->remove_section('header_image');
    $wp_customize->remove_section('background_image');
        
    $wp_customize->add_section( 'front_page_content', array( 
        'title' => __( 'Front Page Content', 'amalgamation' ), 
        'description' => __( 'Content of panels of static front page. Does not apply if your front page is your blog archive.', 'amalgamation' )
    ) );
    
    // post dropdown custom control modified from Tom Rhodes'
    // https://github.com/tommusrhodus/wp-cusomizer-posts-dropdown    
    if (class_exists('WP_Customize_Control')) {
        class Post_Dropdown_Control extends WP_Customize_Control {
              public function render_content() {
                    ?>
                    <label>
                        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                        <select data-customize-setting-link="<?php echo $this->id; ?>">
                            <?php  $posts = get_posts('numberposts=-1');
                            foreach ( $posts as $post ) { ?>
                                <option value="<?php echo $post->ID; ?>" <?php if ( get_theme_mod($this->id) == $post->ID ) echo 'selected="selected"'; ?>><?php echo $post->post_title; ?></option>
                            <?php } ?>
                        </select>
                    </label>
<?php
               }
        }
    }
    if (class_exists('WP_Customize_Control')) {
        class Show_Hide_Hack_Control extends WP_Customize_Control {
            public function render_content() {
                ?>
                <script>
                    jQuery(function($) {
                        for( var i = 1 ; i < 5 ; i++ ) {
                            $('#customize-control-panel_'+i+'_post').hide();
                            $('#customize-control-panel_'+i+'_page').hide();
                        }
                        $( '#accordion-section-front_page_content' ).click(function() {
                            for( var i = 1 ; i < 5 ; i++ ) {
                                if ($('input:radio[name=_customize-radio-fp_panel_'+i+']:checked').val() == 'post') {
                                    $('#customize-control-panel_'+i+'_post').slideDown();
                                    $('#customize-control-panel_'+i+'_page').slideUp();
                                } else if ($('input:radio[name=_customize-radio-fp_panel_'+i+']:checked').val() == 'page') {
                                    $('#customize-control-panel_'+i+'_page').slideDown();
                                    $('#customize-control-panel_'+i+'_post').slideUp();
                                } else {
                                    $('#customize-control-panel_'+i+'_page').slideUp();
                                    $('#customize-control-panel_'+i+'_post').slideUp();
                                }
                            }
                        });
                    });
                </script>
                <?php
            }
        }
    }
    
    $wp_customize->add_setting( 'fp_panel_1', array( 
        'default' => 'latest',
        'sanitize_callback' => 'sanitize_text_field',
        //'transport' => 'postMessage', 
    ) );
    $wp_customize->add_control( 'fp_panel_1', array(
      'label' => __( 'Content of panel 1 (upper left)', 'amalgamation' ),
      'description' => __( 'Includes title, excerpt, and featured image if any.', 'amalgamation' ),
      'section' => 'front_page_content',
      'type' => 'radio',
      'choices' => array( 
          'page' => __( 'Page', 'amalgamation' ), 
          'latest' => __( 'Latest blog post', 'amalgamation' ), 
          'post' => __( 'Fixed blog post', 'amalgamation' ), 
      ),
    ) );
    $wp_customize->add_setting( 'panel_1_page', array(
        'default' => '', 
        'sanitize_callback' => 'sanitize_text_field',
        //'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( 'panel_1_page', array(
        'label' => __( 'Page to show', 'amalgamation' ),
        'section' => 'front_page_content',
        'type' => 'dropdown-pages',
    ) );
    $wp_customize->add_setting( 'panel_1_post', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        //'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( new Post_Dropdown_Control( 
        $wp_customize, 
        'panel_1_post', 
        array(
            'label' => __( 'Post to show', 'amalgamation' ),
            'section' => 'front_page_content',
            'settings' => 'panel_1_post',
    ) ) );
    
    $wp_customize->add_setting( 'fp_panel_2', array( 
        'default' => 'latest',
        'sanitize_callback' => 'sanitize_text_field',
        //'transport' => 'postMessage', 
    ) );
    $wp_customize->add_control( 'fp_panel_2', array(
      'label' => __( 'Content of panel 2 (upper right)', 'amalgamation' ),
      'description' => __( 'Includes title, excerpt, and featured image if any.', 'amalgamation' ),
      'section' => 'front_page_content',
      'type' => 'radio',
      'choices' => array( 
          'page' => __( 'Page', 'amalgamation' ), 
          'latest' => __( 'Latest blog post', 'amalgamation' ), 
          'post' => __( 'Fixed blog post', 'amalgamation' ), 
      ),
    ) );
    $wp_customize->add_setting( 'panel_2_page', array(
        'default' => '', 
        'sanitize_callback' => 'sanitize_text_field',
        //'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( 'panel_2_page', array(
        'label' => __( 'Page to show', 'amalgamation' ),
        'section' => 'front_page_content',
        'type' => 'dropdown-pages',
    ) );
    $wp_customize->add_setting( 'panel_2_post', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        //'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( new Post_Dropdown_Control( 
        $wp_customize, 
        'panel_2_post', 
        array(
            'label' => __( 'Post to show', 'amalgamation' ),
            'section' => 'front_page_content',
            'settings' => 'panel_2_post',
    ) ) );
    
    $wp_customize->add_setting( 'fp_panel_3', array( 
        'default' => 'latest',
        'sanitize_callback' => 'sanitize_text_field',
        //'transport' => 'postMessage', 
    ) );
    $wp_customize->add_control( 'fp_panel_3', array(
      'label' => __( 'Content of panel 3 (lower left)', 'amalgamation' ),
      'description' => __( 'Includes title, excerpt, and featured image if any.', 'amalgamation' ),
      'section' => 'front_page_content',
      'type' => 'radio',
      'choices' => array( 
          'page' => __( 'Page', 'amalgamation' ), 
          'latest' => __( 'Latest blog post', 'amalgamation' ), 
          'post' => __( 'Fixed blog post', 'amalgamation' ), 
      ),
    ) );
    $wp_customize->add_setting( 'panel_3_page', array(
        'default' => '', 
        'sanitize_callback' => 'sanitize_text_field',
        //'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( 'panel_3_page', array(
        'label' => __( 'Page to show', 'amalgamation' ),
        'section' => 'front_page_content',
        'type' => 'dropdown-pages',
    ) );
    $wp_customize->add_setting( 'panel_3_post', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        //'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( new Post_Dropdown_Control( 
        $wp_customize, 
        'panel_3_post', 
        array(
            'label' => __( 'Post to show', 'amalgamation' ),
            'section' => 'front_page_content',
            'settings' => 'panel_3_post',
    ) ) );
    
    $wp_customize->add_setting( 'fp_panel_4', array( 
        'default' => 'latest',
        'sanitize_callback' => 'sanitize_text_field',
        //'transport' => 'postMessage', 
    ) );
    $wp_customize->add_control( 'fp_panel_4', array(
      'label' => __( 'Content of panel 4 (lower right)', 'amalgamation' ),
      'description' => __( 'Includes title, excerpt, and featured image if any.', 'amalgamation' ),
      'section' => 'front_page_content',
      'type' => 'radio',
      'choices' => array( 
          'page' => __( 'Page', 'amalgamation' ), 
          'latest' => __( 'Latest blog post', 'amalgamation' ), 
          'post' => __( 'Fixed blog post', 'amalgamation' ), 
      ),
    ) );
    $wp_customize->add_setting( 'panel_4_page', array(
        'default' => '', 
        'sanitize_callback' => 'sanitize_text_field',
        //'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( 'panel_4_page', array(
        'label' => __( 'Page to show', 'amalgamation' ),
        'section' => 'front_page_content',
        'type' => 'dropdown-pages',
    ) );
    $wp_customize->add_setting( 'panel_4_post', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        //'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( new Post_Dropdown_Control( 
        $wp_customize, 
        'panel_4_post', 
        array(
            'label' => __( 'Post to show', 'amalgamation' ),
            'section' => 'front_page_content',
            'settings' => 'panel_4_post',
    ) ) );
    $wp_customize->add_setting( 'panel_control_hack', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( new Show_Hide_Hack_Control( 
        $wp_customize,
        'panel_control_hack',
        array(
            'label' => '',
            'section' => 'front_page_content',
            'settings' => 'panel_control_hack',
        )
    ) );
}

add_action( 'customize_register', 'amalgamation_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function amalgamation_customize_preview_js() {
	wp_enqueue_script( 'amalgamation_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'amalgamation_customize_preview_js' );
