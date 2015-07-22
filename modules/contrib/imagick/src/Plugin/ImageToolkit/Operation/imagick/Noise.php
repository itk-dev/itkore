<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Noise.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

/**
 * Defines imagick noise operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_noise",
 *   toolkit = "imagick",
 *   operation = "noise",
 *   label = @Translation("Noise"),
 *   description = @Translation("Adds noise to the image.")
 * )
 */
class Noise extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'type' => array(
        'description' => 'The type of noise being used.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->addNoiseImage($arguments['type']);
  }

}
