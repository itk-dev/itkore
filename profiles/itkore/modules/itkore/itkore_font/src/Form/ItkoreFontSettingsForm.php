<?php
/**
 * @file
 * Contains Drupal\itkore_font\Form\ItkoreSettingsForm.
 */

namespace Drupal\itkore_font\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ContentEntityExampleSettingsForm.
 * @package Drupal\itkore_admin\Form
 * @ingroup itkore_booking
 */
class ItkoreFontSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'itkore_font_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'itkore_font.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('itkore_font.settings');

    $form['font_settings'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Font'),
      '#default_value' => $config->get('itkore_font'),
      '#options' => array(
        '_none_' => $this->t('Default'),
        'roboto' => $this->t('Roboto'),
        'source_sans_pro' => $this->t('Source Sans Pro'),
        'titillium_web' => $this->t('Titillium Web'),
      ),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('itkore_font.settings')
      ->set('itkore_font', $form_state->getValue('font_settings'))
      ->save();

    // Flush all to ensure that the font selection works around the whole
    // system. Simply clearing the theme cache do not work.
    drupal_flush_all_caches();

    parent::submitForm($form, $form_state);
  }
}
