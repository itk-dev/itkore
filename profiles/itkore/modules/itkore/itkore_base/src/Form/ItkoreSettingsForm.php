<?php
/**
 * @file
 * Contains Drupal\itkore_base\Form\ItkoreSettingsForm.
 */

namespace Drupal\itkore_base\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;


/**
 * Class ContentEntityExampleSettingsForm.
 * @package Drupal\itkore_base\Form
 * @ingroup itkore_booking
 */
class ItkoreSettingsForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'itkore_settings';
  }

  /**
   * Get key/value storage for base config.
   *
   * @return object
   */
  private function getBaseConfig() {
    return \Drupal::getContainer()->get('itkore_base.itkore_config');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->getBaseConfig();
    // ----------- Frontpage ----------- //

    // Add frontpage wrapper.
    $form['frontpage_wrapper'] = array(
      '#title' => $this->t('Frontpage settings'),
      '#type' => 'details',
      '#weight' => '1',
      '#open' => TRUE,
    );

    $form['frontpage_wrapper']['frontpage_title'] = array(
      '#title' => $this->t('Frontpage title'),
      '#type' => 'textfield',
      '#default_value' => $config->get('itkore_frontpage.frontpage_title'),
      '#weight' => '1',
    );

    $form['frontpage_wrapper']['frontpage_lead'] = array(
      '#title' => $this->t('Frontpage lead text'),
      '#type' => 'textfield',
      '#default_value' => $config->get('itkore_frontpage.frontpage_lead'),
      '#weight' => '2',
    );

    $form['frontpage_wrapper']['frontpage_sub'] = array(
      '#title' => $this->t('Frontpage sub text'),
      '#type' => 'textfield',
      '#default_value' => $config->get('itkore_frontpage.frontpage_sub'),
      '#weight' => '3',
    );

    $form['frontpage_wrapper']['frontpage_button'] = array(
      '#title' => $this->t('Frontpage button text'),
      '#type' => 'textfield',
      '#default_value' => $config->get('itkore_frontpage.frontpage_button'),
      '#weight' => '4',
    );

    $form['frontpage_wrapper']['frontpage_link'] = array(
      '#title' => $this->t('Frontpage button link'),
      '#type' => 'textfield',
      '#default_value' => $config->get('itkore_frontpage.frontpage_link'),
      '#weight' => '5',
    );

    $fids = array();
    if (!empty($input)) {
      if (!empty($input['frontpage_image'])) {
        $fids[0] = $form_state->getValue('frontpage_image');
      }
    }
    else {
      $fids[0] = $config->get('itkore_frontpage.frontpage_image', '');
    }

    $form['frontpage_wrapper']['frontpage_image'] = array(
      '#title' => $this->t('Frontpage image'),
      '#type' => 'managed_file',
      '#default_value' => ($fids[0]) ? $fids : '',
      '#upload_location' => 'public://',
      '#weight' => '3',
      '#open' => TRUE,
      '#description' => t('The image used at the top of the frontpage.'),
    );


    // ----------- Footer ----------- //

    // Add footer wrapper.
    $form['footer_wrapper'] = array(
      '#title' => $this->t('Footer settings'),
      '#type' => 'details',
      '#weight' => '2',
      '#open' => TRUE,
    );

    $form['footer_wrapper']['footer_text'] = array(
      '#title' => $this->t('Footer text'),
      '#type' => 'text_format',
      '#format' => 'filtered_html',
      '#default_value' => $config->get('itkore_footer.footer_text'),
      '#weight' => '1',
    );

    $form['footer_wrapper']['footer_twitter'] = array(
      '#title' => $this->t('Twitter URL'),
      '#type' => 'textfield',
      '#default_value' => $config->get('itkore_footer.footer_twitter'),
      '#weight' => '2',
    );

    $form['footer_wrapper']['footer_instagram'] = array(
      '#title' => $this->t('Instagram URL'),
      '#type' => 'textfield',
      '#default_value' => $config->get('itkore_footer.footer_instagram'),
      '#weight' => '3',
    );

    $form['footer_wrapper']['footer_linkedin'] = array(
      '#title' => $this->t('Linkedin URL'),
      '#type' => 'textfield',
      '#default_value' => $config->get('itkore_footer.footer_linkedin'),
      '#weight' => '4',
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Save changes'),
      '#weight' => '6',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message('Settings saved');

    // Fetch the file id previously saved.
    $config = $this->getBaseConfig();
    $old_fid = $config->get('itkore_frontpage.frontpage_image', '');

    // Load the file set in the form.
    $value = $form_state->getValue('frontpage_image');
    $form_fid = count($value) > 0 ? $value[0] : 0;
    $file = ($form_fid) ? File::load($form_fid) : FALSE;

    // If a file is set.
    if ($file) {
      $fid = $file->id();
      // Check if the file has changed.
      if ($fid != $old_fid) {

        // Remove old file.
        if ($old_fid) {
          removeFile($old_fid);
        }

        // Add file to file_usage table.
        \Drupal::service('file.usage')->add($file, 'itkore_base', 'user', '1');
      }
    }
    else {
      // If old file exists but no file set in form, remove old file.
      if ($old_fid) {
        removeFile($old_fid);
      }
    }

    $this->getBaseConfig()->setMultiple(array(
      'itkore_frontpage.frontpage_title' => $form_state->getValue('frontpage_title'),
      'itkore_frontpage.frontpage_lead' => $form_state->getValue('frontpage_lead'),
      'itkore_frontpage.frontpage_sub' => $form_state->getValue('frontpage_sub'),
      'itkore_frontpage.frontpage_button' => $form_state->getValue('frontpage_button'),
      'itkore_frontpage.frontpage_link' => $form_state->getValue('frontpage_link'),
      'itkore_footer.footer_text' => $form_state->getValue('footer_text')['value'],
      'itkore_footer.footer_twitter' => $form_state->getValue('footer_twitter'),
      'itkore_footer.footer_instagram' => $form_state->getValue('footer_instagram'),
      'itkore_footer.footer_linkedin' => $form_state->getValue('footer_linkedin'),
      'itkore_frontpage.frontpage_image' => $file ? $file->id() : NULL
      )
    );
  }
}

/**
 * Deletes a a file from file usage table.
 *
 * @param int $fid
 *   The file id of the file to delete.
 */
function removeFile($fid) {
  // Load and delete old file.
  $file = File::load($fid);
  \Drupal::service('file.usage')->delete($file, 'itkore_base', 'user', '1', '1');
}
