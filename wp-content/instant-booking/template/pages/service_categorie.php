<?php 

global $devise;
global $mode;
global $mode_affiche;

$args = array(
    'taxonomy' => 'categorie',
    'orderby' => 'name',
    'order'   => 'DESC'
);

$cats = get_categories($args);
foreach($cats as $cat) {
  ?>
  <div class=""><a href="<?php echo get_category_link( $cat->term_id ) ?>">
      <span class="ib_catnme"><?php echo esc_html($cat->name); ?></span>
      <span class="ib_catprice"><?php echo esc_html(get_term_meta( $cat->term_id, 'categoriePrice',true)); ?></span>
  </a>
</div>
<?php }?>