<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Resize.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

use Drupal\system\Plugin\ImageToolkit\Operation\gd\Resize as GdResize;
use Imagick;

/**
 * Defines imagick resize operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_resize",
 *   toolkit = "imagick",
 *   operation = "resize",
 *   label = @Translation("Resize"),
 *   description = @Translation("Resizes an image to the given dimensions (ignoring aspect ratio).")
 * )
 */
class Resize extends GdResize {

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->resizeImage($arguments['width'], $arguments['height'], Imagick::FILTER_LANCZOS, 1);
  }

}
