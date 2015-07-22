<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Colorshift
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

use Imagick;
use ImagickPixel;

/**
 * Defines imagick coloroverlay operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_colorshift",
 *   toolkit = "imagick",
 *   operation = "colorshift",
 *   label = @Translation("Colorshift"),
 *   description = @Translation("Applies a colorshift effect on an image")
 * )
 */
class Colorshift extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'HEX' => array(
        'description' => 'The color used to shift.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    $color = $arguments['HEX'];
    $alpha = $arguments['alpha'];

    $color = empty($color) ? 'none' : $color;

    return $res->colorizeImage(new ImagickPixel($color), 1);
  }

}
