<?php
/**
 * @file
 * Preprocess and alter functions for itkore theme.
 */

/**
 * Implements hook_preprocess_node().
 * 
 * Create helper function to target node of specific content types.
 */
function itkore_preprocess_node(&$vars, $hook) {
  $function = __FUNCTION__ . '_' . $vars['type'];
  if (function_exists($function)) {
    $function($vars, $hook);
  }
}

/**
 * Implements hook_preprocess_block().
 *
 * Create helper function to target blocks from specific modules.
 * Add common styling class to block-menu and block-menu-block.
 */
function itkore_preprocess_block(&$vars, $hook) {
  $function = __FUNCTION__ . '_' . $vars['elements']['#block']->module;
  if (function_exists($function)) {
    $function($vars, $hook);
  }
}

/**
 * Implement hook_preprocess_region().
 *
 * Make $main_menu and $secondary_menu available for printing in regions.
 */
function itkore_preprocess_region(&$vars) {
  $vars['main_menu'] = menu_navigation_links('menu-primary-links', 0);
  $vars['secondary_menu'] = menu_navigation_links('menu-secondary-links', 0);
}

/**
 * Implements hook_preprocess_page().
 * Insert Typekit code in $script if enabled in theme settings.
 */
function itkore_preprocess_page(&$vars) {
  // Check if typekit is enables and an ID has been defined.
  if (theme_get_setting('typekit_kit_id') != '' && theme_get_setting('typekit_enable') == '1') {
    // Create url to js
    $typekit_url = '//use.typekit.com/' . theme_get_setting('typekit_kit_id') .'.js';
    // Add Typekit js.
    drupal_add_js($typekit_url,
      array('type' => 'external', 'scope' => 'header', 'weight' => 9)
    );
    drupal_add_js('try{Typekit.load();}catch(e){}',
      array('type' => 'inline', 'scope' => 'header', 'weight' => 10)
    );
  };
}

/**
 * Implements hook_preprocess_field().
 *
 * Adds consistent classes to field wrappers for styling purposes.
 */
function itkore_preprocess_field(&$vars) {
  // Add .text-content to selected fields
  switch ($vars['element']['#field_type']) {
    case 'text_long':
       $vars['classes_array'][] = 'text-content';
      break;

    default:
      break;
  }
}

/**
 * Implements template_menu_link().
 *
 * Adds classes based on menu level to nested menus.
 */
function itkore_menu_link(array $variables) {

  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);

  // Adds the depth class just for main-menu.
  if ($element['#original_link']['menu_name'] == 'main-menu') {
    $element['#attributes']['class'][] = 'level-' . $element['#original_link']['depth'];
    return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
  }
  else {
    return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
  }
}

/**
 * Implements hook_breadcrumb().
 *
 * Add the current page title to the end of the breadcrumb.
 */
function itkore_breadcrumb($variables) {
  $output = '';
  $breadcrumb = $variables['breadcrumb'];

  // Build breadcrumb.
  if (!empty($breadcrumb)) {
    // Add current page title to the end of the breadcrumb.
    $breadcrumb[] = '<span>' . drupal_get_title() . '</span>';
  }

  // Provide a navigational heading to give context for breadcrumb links to
  // screen-reader users. Make the heading invisible with .element-invisible.
  $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
  $output .= '<nav class="breadcrumb">' . implode(' » ', $breadcrumb) . '</nav>';

  return $output;
}
