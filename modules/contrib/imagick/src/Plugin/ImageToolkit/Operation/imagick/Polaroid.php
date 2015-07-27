<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Polaroid.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

use ImagickDraw;

/**
 * Defines imagick oilpaint operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_polaroid",
 *   toolkit = "imagick",
 *   operation = "polaroid",
 *   label = @Translation("Polaroid"),
 *   description = @Translation("Adds a polaroid effect to the image.")
 * )
 */
class Polaroid extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'angle' => array(
        'description' => 'The angle of the polaroid effect.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    $angle = $arguments['angle'];
    // Generate a random angle when field is empty
    if (empty($angle)) {
      $angle = mt_rand(-30, 30);
    }

    return $res->polaroidImage(new ImagickDraw(), $angle);
  }

}
