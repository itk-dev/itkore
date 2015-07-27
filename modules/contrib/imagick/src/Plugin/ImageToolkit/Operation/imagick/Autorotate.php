<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Autorotate.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

use Imagick;
use ImagickPixel;

/**
 * Defines imagick autorotate operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_autorotate",
 *   toolkit = "imagick",
 *   operation = "autorotate",
 *   label = @Translation("Autorotate"),
 *   description = @Translation("Autorotates an image using EXIF data.")
 * )
 */
class Autorotate extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    $orientation = $res->getImageOrientation();

    switch ($orientation) {
      case imagick::ORIENTATION_BOTTOMRIGHT:
        $res->rotateimage(new ImagickPixel(), 180); // rotate 180 degrees
        break;
      case imagick::ORIENTATION_RIGHTTOP:
        $res->rotateimage(new ImagickPixel(), 90); // rotate 90 degrees CW
        break;
      case imagick::ORIENTATION_LEFTBOTTOM:
        $res->rotateimage(new ImagickPixel(), -90); // rotate 90 degrees CCW
        break;
    }

    // Now that it's auto-rotated, make sure the EXIF data is correct in case the EXIF gets saved with the image!
    return $res->setImageOrientation(imagick::ORIENTATION_TOPLEFT);
  }

}
