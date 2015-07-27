<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Frame.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

use Imagick;
use ImagickPixel;

/**
 * Defines imagick frame operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_frame",
 *   toolkit = "imagick",
 *   operation = "frame",
 *   label = @Translation("Frame"),
 *   description = @Translation("Frames an image with a border.")
 * )
 */
class Frame extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'matte_color' => array(
        'description' => 'The string representing the matte color',
      ),
      'width' => array(
        'description' => 'The width of the border',
      ),
      'height' => array(
        'description' => 'The height of the border',
      ),
      'inner_bevel' => array(
        'description' => 'The angle of the blur',
      ),
      'outer_bevel' => array(
        'description' => 'The angle of the blur',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();
    $color = new ImagickPixel($arguments['matte_color']);

    return $res->frameImage($color, $arguments['width'], $arguments['height'], $arguments['inner_bevel'], $arguments['outer_bevel']);
  }

}