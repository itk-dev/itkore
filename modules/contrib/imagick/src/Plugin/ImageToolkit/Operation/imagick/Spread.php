<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Spread.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

/**
 * Defines imagick spread operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_spread",
 *   toolkit = "imagick",
 *   operation = "spread",
 *   label = @Translation("Spread"),
 *   description = @Translation("Adds spread to an image.")
 * )
 */
class Spread extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'radius' => array(
        'description' => 'The color of the shadow.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->spreadImage($arguments['radius']);
  }

}
