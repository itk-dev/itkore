<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\DefineCanvas.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

use Imagick;
use ImagickPixel;

/**
 * Defines imagick define canvas operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_define_canvas",
 *   toolkit = "imagick",
 *   operation = "define_canvas",
 *   label = @Translation("Define canvas"),
 *   description = @Translation("Define the canvas of an image.")
 * )
 */
class DefineCanvas extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'HEX' => array(
        'description' => 'The color of the canvas',
      ),
      'under' => array(
        'description' => 'This will create a solid flat layer, probably totally obscuring the source image',
      ),
      'exact_measurements' => array(
        'description' => 'Do we have to use exact measurements',
      ),
      'exact' => array(
        'description' => 'Exact measurements',
      ),
      'relative' => array(
        'description' => 'Relative measurements',
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
    $under = $arguments['under'];
    $exact_size = $arguments['exact_measurements'];
    $exact = $arguments['exact'];
    $relative = $arguments['relative'];

    $canvas = new Imagick();
    $canvas->setFormat('jpg');

    $color = empty($color) ? 'none' : $color;
    if ($exact_size) {
      $width = $this::imagick_percent_filter($exact['width'], $res->getImageWidth());
      $height = $this::imagick_percent_filter($exact['height'], $res->getImageHeight());

      list($x, $y) = explode('-', $exact['anchor']);
      $x = image_filter_keyword($x, $width, $res->getImageWidth());
      $y = image_filter_keyword($y, $height, $res->getImageHeight());
    }
    else {
      $width = $res->getImageWidth() + $relative['leftdiff'] + $relative['rightdiff'];
      $height = $res->getImageHeight() + $relative['topdiff'] + $relative['bottomdiff'];

      $x = $relative['leftdiff'];
      $y = $relative['topdiff'];
    }

    $canvas->newImage($width, $height, new ImagickPixel($color));
    if ($under) {
     $canvas->compositeImage($res, imagick::COMPOSITE_DEFAULT, $x, $y);
    }

    $this->getToolkit()->setResource($canvas);
    return $canvas;
  }

  /**
   * Helper function to calculate width from percentage
   */
  private function imagick_percent_filter($length_specification, $current_length) {
    if (strpos($length_specification, '%') !== FALSE) {
      $length_specification = $current_length !== NULL ? str_replace('%', '', $length_specification) * 0.01 * $current_length : NULL;
    }
    return $length_specification;
  }

}
