<?php

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_FORM_ID_alter() for install_configure_form().
 *
 * Allows the profile to alter the site configuration form.
 */
function itkore_profile_form_install_configure_form_alter(&$form, FormStateInterface $form_state) {
  $form['#submit'][] = 'itkore_profile_form_install_configure_submit';
}

/**
 * Submission handler to sync the contact.form.feedback recipient.
 */
function itkore_profile_form_install_configure_submit($form, FormStateInterface $form_state) {
// Update user/1 to use english language for administration pages.
  /*
  db_update('users_field_data')
    ->fields(array(
      'preferred_admin_langcode' => 'en',
    ))
    ->condition('uid', 1)
    ->execute();
*/
// Set config variables
  \Drupal::service('config.factory')->getEditable('system.theme')->set('admin', 'seven')->save();
  \Drupal::service('config.factory')->getEditable('system.theme')->set('default', 'itkore')->save();

  // Setup content
  \Drupal::service('module_installer')->install(['itkore_blocks']);
  \Drupal::service('module_installer')->install(['itkore_content_types']);
}
