<?php
/**
 * @file
 * Contains Drupal\itk_instagram_hashtag\Form\InstagramHashtagSettingsForm.
 */

namespace Drupal\itk_instagram_hashtag\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class InstagramHashtagSettingsForm.
 * @package Drupal\koba_booking\Form
 * @ingroup koba_booking
 */
class InstagramHashtagSettingsForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'itk_instagram_hashtag_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('itk_instagram_hashtag.settings');
    $account = $this->currentUser();

    // Admin settings tab.
    $form['itk_instagram_hashtag_settings'] = array(
      '#title' => $this->t('Instagram Hashtag settings'),
      '#type' => 'details',
      '#weight' => '5',
      '#access' => $account->hasPermission('configure settings'),
      '#open' => TRUE,
    );

    $form['itk_instagram_hashtag_settings']['client_id'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Set Instagram client id'),
      '#default_value' => $config->get('itk_instagram_hashtag.client_id'),
      '#required' => TRUE,
    );

    $form['itk_instagram_hashtag_settings']['resolution'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Choose resolution'),
      '#default_value' => $config->get('itk_instagram_hashtag.resolution'),
      '#required' => TRUE,
    );

    $form['itk_instagram_hashtag_settings']['sort_by'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('How should it be sorted'),
      '#default_value' => $config->get('itk_instagram_hashtag.sort_by'),
      '#required' => TRUE,
    );

    $form['itk_instagram_hashtag_settings']['limit'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('How many items should max be displayed?'),
      '#default_value' => $config->get('itk_instagram_hashtag.limit'),
      '#required' => TRUE,
    );

    $form['itk_instagram_hashtag_settings']['enable_caption'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Should caption be displayed?'),
      '#default_value' => $config->get('itk_instagram_hashtag.enable_caption'),
      '#required' => FALSE,
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

    $this->configFactory()->getEditable('itk_instagram_hashtag.settings')
      ->set('itk_instagram_hashtag.client_id', $form_state->getValue('client_id'))
      ->set('itk_instagram_hashtag.resolution', $form_state->getValue('resolution'))
      ->set('itk_instagram_hashtag.sort_by', $form_state->getValue('sort_by'))
      ->set('itk_instagram_hashtag.limit', $form_state->getValue('limit'))
      ->set('itk_instagram_hashtag.enable_caption', $form_state->getValue('enable_caption'))
      ->save();

    // Make sure the new settings are available to the js.
    \Drupal::cache('render')->deleteAll();
  }
}
