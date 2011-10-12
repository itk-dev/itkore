<?php
 /**
  * @file
  * Overrides template from Omega and prints secondary menu in region.
  */
?>

<div<?php print $attributes; ?>>
  <div<?php print $content_attributes; ?>>
    <?php 
      // @todo Generate variable for menu
      print theme('links__system_secondary_menu', array(
        'links' => $secondary_menu, 
        'attributes' => array(
          'class' => array(
            'links', 
            'inline', 
            'secondary-menu',
            'menu',
            )
          ), 
        )); 
      ?>
    <?php print $content; ?>
  </div>
</div>
