<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Convert
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

use Drupal\imagick\ImagickConst;
use imagick;

/**
 * Defines imagick convert operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_convert",
 *   toolkit = "imagick",
 *   operation = "convert",
 *   label = @Translation("Convert"),
 *   description = @Translation("Converts image's filetype and quality")
 * )
 */
class Convert extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'format' => array(
        'description' => 'Image format.',
      ),
      'quality' => array(
        'description' => 'Image quality.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();
    $formats = ImagickConst::imagick_file_formats();

    $format = $arguments['format'];
    $quality = $arguments['quality'];

    // Set a white background color when converting to JPG because this file
    // format does not support transparency
    if ($format == 'image/jpeg') {
      $background = new Imagick();
      $background->newImage($res->getImageWidth(), $res->getImageHeight(), 'white');

      $res->compositeImage($background, Imagick::COMPOSITE_DSTOVER, 0, 0);
    }

    $res->setImageFormat($formats[$format]);
    $res->setImageProperty('quality', (int) $quality);

    return $res;
  }

}
