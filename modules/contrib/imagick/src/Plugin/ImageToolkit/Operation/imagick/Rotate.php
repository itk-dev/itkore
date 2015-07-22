<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Rotate.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

use Drupal\system\Plugin\ImageToolkit\Operation\gd\Desaturate as GdRotate;
use Imagick;
use ImagickPixel;

/**
 * Defines imagick rotate operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_rotate",
 *   toolkit = "imagick",
 *   operation = "rotate",
 *   label = @Translation("rotate"),
 *   description = @Translation("Rotates an image.")
 * )
 */
class Rotate extends GdRotate {

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();
    $background = new ImagickPixel();

    if (!empty($arguments['background'])) {
      $background->setColor('#' . dechex($arguments['background']));
    }
    else {
      $background->setColor('none');
    }

    return $res->rotateImage($background, $arguments['degrees']);
  }

}
