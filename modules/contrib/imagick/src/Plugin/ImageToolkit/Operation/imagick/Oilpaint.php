<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Oilpaint.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

/**
 * Defines imagick oilpaint operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_oilpaint",
 *   toolkit = "imagick",
 *   operation = "oilpaint",
 *   label = @Translation("Oilpaint"),
 *   description = @Translation("Oilpaints the image.")
 * )
 */
class Oilpaint extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'radius' => array(
        'description' => 'The threshold of the oilpaint effect.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->oilPaintImage($arguments['radius']);
  }

}
