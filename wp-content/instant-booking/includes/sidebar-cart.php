<?php
/*
 
if ( function_exists('register_sidebar') ) {
        register_sidebar(array(
           'name'=> 'Sidebar cart',
           'id' => 'sidebar_cart',
           'before_widget' => '<div id="sidebar--cart" class="sidebart_cart">',
           'after_widget' => '</div>',
           'before_title' => '<h3 class="widgettitle"><button type="submit" id="close-cart class="close-cart")">&times;</a>',
           'after_title' => '</h3>',
        ));
}
    add_action("admin_init", "sidebar_init");
    add_action('save_post', 'save_sidebar_link');
    function sidebar_init(){
        add_meta_box("sidebar_meta", "Sidebar Selection", "sidebar_link", "page", "side", "default");
    }
 
    function sidebar_link(){
        global $post, $dynamic_widget_areas;
        $custom  = get_post_custom($post->ID);
        $link    = $custom["_sidebar"][0];
    ?>
<div class="link_header">
    <?
    echo '<select name="link" class="sidebar-selection">';
    echo '<option>Select Sidebar</option>';
    echo '<option>-----------------------</option>';
    foreach ( $dynamic_widget_areas as $list ){
 
            if($link == $list){
              echo '<option value="'.$list.'" selected="true">'.$list.'</option>';
            }else{
              echo '<option value="'.$list.'">'.$list.'</option>';
            }
        }
    echo '</select><br />';
    ?>
</div>
<p>Select sidebar to use on this page.</p>
<?php
}
 
function save_sidebar_link(){
global $post;
if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {return $post->ID;}
    update_post_meta($post->ID, "_sidebar", $_POST["link"]);
}
add_action('admin_head', 'sidebar_css');
function sidebar_css() {
    echo'
    <style type="text/css">
        .sidebar-selection{width:100%;}
    </style>
    ';
}*/