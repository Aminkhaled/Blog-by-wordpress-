<?php
/**
 * Created by PhpStorm.
 * User: Dreamer
 * Date: 8/19/2017
 * Time: 4:26 PM
 */

//-- Custom styles for this template

function styles(){
    wp_enqueue_style('blog',get_template_directory_uri()."/blog.css");
}

add_action('wp_enqueue_scripts','styles');

//Wordpress title

add_theme_support('title-tag');

function add_custom_menu(){
    add_menu_page('custom settings','custom settings','manage_options','custom-settings','custom_settings_page',null,99);
}
add_action( 'admin_menu', 'add_custom_menu' );

    // Create Custom Global Settings
    function custom_settings_page() { ?>
    <div class="wrap">
        <h1>Custom Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('section');
            do_settings_sections('theme-options');
            submit_button();
            ?>
        </form>
    </div>
<?php } 
?>

<?php
function add_twitter(){?>        
    <input type="text" id="twitter" name="twitter" value="<?php echo get_option('twitter');?>">

    <?php
}
?>
<?php
    function add_github(){?>
    <input type="text" id="github" name="github" value="<?php echo get_option('github');?>">
<?php
}
?>


<?php
function custom_settings_page_setup() {
    add_settings_section('section','All Settings',null,'theme-options');
//    Twitter Url
    add_settings_field('twitter','Twitter URL','add_twitter','theme-options','section');
    register_setting('section','twitter');
//    Github url
  add_settings_field('github','Github URL','add_github','theme-options','section');
  register_setting('section','github');
}

add_action('admin_init','custom_settings_page_setup');


//Featured Images
    add_theme_support('post-thumbnails');
    
//    create custom posts
    
    function create_custom_posts(){
register_post_type('my_custom_post',array(
        'labels' => array(
                'name'=> __('My Custom Post'),
            'singular_name'=> __('My Custom Post'),
        ),
    'public'=> true,
      'has_archive' => true,
      'supports' => array(
               'title',
               'editor',
               'thumbnails',
               'custom-fields'
      )
));
    }
    
    add_action('init','create_custom_posts');
    
?>
<?php
function logo_display()
{
    ?>
    <input type="file" name="logo" />
    <?php echo get_option('logo'); ?>
    <?php
}

function handle_logo_upload()
{
    if(!empty($_FILES["demo-file"]["tmp_name"]))
    {
        $urls = wp_handle_upload($_FILES["logo"], array('test_form' => FALSE));
        $temp = $urls["url"];
        return $temp;
    }

    return $option;
}

function display_theme_panel_fields()
{
    add_settings_section("section", "All Settings", null, "theme-options");

    add_settings_field("logo", "Logo", "logo_display", "theme-options", "section");

    register_setting("section", "logo", "handle_logo_upload");
}

add_action("admin_init", "display_theme_panel_fields");