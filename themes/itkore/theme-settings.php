<?php

/**
 * @file
 * Theme setting callbacks for the Itkore theme.
 */

/**
 * Implements hook_form_FORM_ID_alter().
 *
 * @param $form
 *   The form.
 * @param $form_state
 *   The form state.
 */
function itkore_form_system_theme_settings_alter(&$form, \Drupal\Core\Form\FormStateInterface $form_state) {
  $nid = theme_get_setting('itkore_opening_hours_url');
  $item = $nid ? \Drupal\node\Entity\Node::load($nid) : null;

  $form['itkore_opening_hours_url'] = array(
    // '#type' => 'textfield',
    '#type' => 'entity_autocomplete',
    '#target_type' => 'node',
    '#attributes' => array(
      'data-autocomplete-first-character-blacklist' => '/#?',
    ),
    '#description' => t('Start typing the title of a page to select it.'),

    '#default_value' => $item,
    '#title' => t('Opening hours page'),
    '#weight' => -2,
  );

}