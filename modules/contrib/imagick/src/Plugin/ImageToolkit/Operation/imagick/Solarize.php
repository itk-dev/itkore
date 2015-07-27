<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Solarize.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

/**
 * Defines imagick solarize operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_solarize",
 *   toolkit = "imagick",
 *   operation = "solarize",
 *   label = @Translation("Solarize"),
 *   description = @Translation("Solarizes an image.")
 * )
 */
class Solarize extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'threshold' => array(
        'description' => 'The threshold of the solarize effect.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->solarizeImage($arguments['threshold']);
  }

}
