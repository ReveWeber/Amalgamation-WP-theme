<?php
/**
 * Amalgamation Theme Customizer.
 *
 * @package Amalgamation
 */

/*
* Front page helper functions
*/

// todo: ajax load of contents of front page panels
add_action( 'wp_ajax_nopriv_amalgamation_fp_ajax_load', 'amalgamation_fp_ajax_response' );
add_action( 'wp_ajax_amalgamation_fp_ajax_load', 'amalgamation_fp_ajax_response' );

function amalgamation_fp_ajax_response() {
    $content_type = $_POST['content_type'];
    $content_id = intval($_POST['content_id']);
    if ( $content_type == 'post' ) {
        echo Amalgamation_Front_Panel_Post($content_id);
    } else if ( $content_type == 'page' ) {
        echo Amalgamation_Front_Panel_Page($content_id);
    } else {
        echo Amalgamation_Front_Panel_Latest();
    }
    die();
}

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
    $wp_customize->remove_section('header_image');
    $wp_customize->remove_section('background_image');
    $wp_customize->remove_control('background_color');
    $wp_customize->remove_control('header_textcolor');
    
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
    
    $wp_customize->add_setting( 'fp_panel_1', array( 
        'default' => 'latest',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage', 
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
        'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( 'panel_1_page', array(
        'label' => __( 'Page to show', 'amalgamation' ),
        'section' => 'front_page_content',
        'type' => 'dropdown-pages',
    ) );
    $wp_customize->add_setting( 'panel_1_post', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
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
        'transport' => 'postMessage', 
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
        'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( 'panel_2_page', array(
        'label' => __( 'Page to show', 'amalgamation' ),
        'section' => 'front_page_content',
        'type' => 'dropdown-pages',
    ) );
    $wp_customize->add_setting( 'panel_2_post', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
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
        'transport' => 'postMessage', 
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
        'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( 'panel_3_page', array(
        'label' => __( 'Page to show', 'amalgamation' ),
        'section' => 'front_page_content',
        'type' => 'dropdown-pages',
    ) );
    $wp_customize->add_setting( 'panel_3_post', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
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
        'transport' => 'postMessage', 
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
        'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( 'panel_4_page', array(
        'label' => __( 'Page to show', 'amalgamation' ),
        'section' => 'front_page_content',
        'type' => 'dropdown-pages',
    ) );
    $wp_customize->add_setting( 'panel_4_post', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( new Post_Dropdown_Control( 
        $wp_customize, 
        'panel_4_post', 
        array(
            'label' => __( 'Post to show', 'amalgamation' ),
            'section' => 'front_page_content',
            'settings' => 'panel_4_post',
    ) ) );

    $wp_customize->add_section( 'archive_length', array( 
        'title' => __( 'Blog Archives', 'amalgamation' ), 
        'description' => __( 'Choose whether blog archive pages show full content or post excerpts.', 'amalgamation' )
    ) );
    $wp_customize->add_setting( 'archive_length_setting', array( 
        'default' => 'full',
        'sanitize_callback' => 'sanitize_text_field',
        //'transport' => 'postMessage', 
    ) );
    $wp_customize->add_control( 'archive_length_setting', array(
      'label' => __( 'Blog archives show:', 'amalgamation' ),
      'section' => 'archive_length',
      'type' => 'radio',
      'choices' => array( 
          'full' => __( 'Full content', 'amalgamation' ), 
          'excerpt' => __( 'Excerpts', 'amalgamation' ), 
      ),
    ) );   
}

add_action( 'customize_register', 'amalgamation_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function amalgamation_customize_preview_js() {
	wp_enqueue_script( 'amalgamation_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20160308', true );
    $php_array = array( 'admin_ajax' => admin_url( 'admin-ajax.php' ) );
    wp_localize_script( 'amalgamation_customizer', 'php_array', $php_array );
 
}
add_action( 'customize_preview_init', 'amalgamation_customize_preview_js' );

/**
* Allows dynamic hide/show of panel content options
*/
function amalgamation_customizer_controls_js() {
	wp_enqueue_script( 'amalgamation_customizer_controls', get_template_directory_uri() . '/js/customizer-controls.js', array( 'jquery' ), '20130508', true );
}
add_action( 'customize_controls_enqueue_scripts', 'amalgamation_customizer_controls_js' );
