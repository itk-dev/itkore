<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Wave.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

/**
 * Defines imagick wave operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_wave",
 *   toolkit = "imagick",
 *   operation = "wave",
 *   label = @Translation("Wave"),
 *   description = @Translation("Adds a wave effect to an image.")
 * )
 */
class Wave extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'amplitude' => array(
        'description' => 'The amplitude of the wave.',
      ),
      'length' => array(
        'description' => 'The length of the wave.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->waveImage($arguments['amplitude'], $arguments['length']);
  }

}
