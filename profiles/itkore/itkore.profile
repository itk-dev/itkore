<?php

use Drupal\Core\Form\FormStateInterface;
use Drupal\language\Entity\ConfigurableLanguage;

/**
 * Implements hook_form_FORM_ID_alter() for install_configure_form().
 *
 * Allows the profile to alter the site configuration form.
 */
function itkore_form_install_configure_form_alter(&$form, FormStateInterface $form_state) {
  $form['#submit'][] = 'itkore_form_install_configure_submit';
}

/**
 * Submission handler to setup site.
 */
function itkore_form_install_configure_submit($form, FormStateInterface $form_state) {
  // Set config variables
  \Drupal::service('config.factory')
    ->getEditable('system.theme')
    ->set('admin', 'adminimal_theme')
    ->save();

  \Drupal::service('config.factory')
    ->getEditable('system.theme')
    ->set('default', 'itkore_base')
    ->save();

  // Install custom modules.
  \Drupal::service('module_installer')
    ->install(['itkore_content_types']);

  \Drupal::service('module_installer')
    ->install(['itk_paragraph']);
}