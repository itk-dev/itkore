<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageEffect\NoiseImageEffect.
 */

namespace Drupal\imagick\Plugin\ImageEffect;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Image\ImageInterface;
use Drupal\image\ConfigurableImageEffectBase;
use imagick;

/**
 * Adds noise to an image resource.
 *
 * @ImageEffect(
 *   id = "image_noise",
 *   label = @Translation("Noise"),
 *   description = @Translation("Adds noise to the image.")
 * )
 */
class NoiseImageEffect extends ConfigurableImageEffectBase {

  /**
   * {@inheritdoc}
   */
  public function applyEffect(ImageInterface $image) {
    if (!$image->apply('noise', $this->configuration)) {
      $this->logger->error('Image noise failed using the %toolkit toolkit on %path (%mimetype)', array('%toolkit' => $image->getToolkitId(), '%path' => $image->getSource(), '%mimetype' => $image->getMimeType()));
      return FALSE;
    }
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'type' => imagick::NOISE_UNIFORM,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['type'] = array(
      '#type' => 'select',
      '#title' => t('Noise type'),
      '#options' => array(
        imagick::NOISE_UNIFORM => t('Uniform'),
        imagick::NOISE_GAUSSIAN => t('Gaussian'),
        imagick::NOISE_MULTIPLICATIVEGAUSSIAN => t('Multiplicative gaussian'),
        imagick::NOISE_IMPULSE => t('Impulse'),
        imagick::NOISE_LAPLACIAN => t('Laplacian'),
        imagick::NOISE_POISSON => t('Poisson'),
        imagick::NOISE_RANDOM => t('Random'),
      ),
      '#default_value' => $this->configuration['type'],
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);

    $this->configuration['type'] = $form_state->getValue('type');
  }

}
