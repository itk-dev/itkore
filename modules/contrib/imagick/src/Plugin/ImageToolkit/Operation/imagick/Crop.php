<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Crop.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

use Drupal\system\Plugin\ImageToolkit\Operation\gd\Crop as GdCrop;
use Imagick;

/**
 * Defines imagick crop operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_crop",
 *   toolkit = "imagick",
 *   operation = "crop",
 *   label = @Translation("Crop"),
 *   description = @Translation("Crops an image to the given dimensions (ignoring aspect ratio).")
 * )
 */
class Crop extends GdCrop {

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    $res->cropImage($arguments['width'], $arguments['height'], $arguments['x'], $arguments['y']);
    return $res->setImagePage($arguments['width'], $arguments['height'], 0, 0);
  }

}
