<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Coloroverlay
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

use Imagick;

/**
 * Defines imagick coloroverlay operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_coloroverlay",
 *   toolkit = "imagick",
 *   operation = "coloroverlay",
 *   label = @Translation("Coloroverlay"),
 *   description = @Translation("Applies the coloroverlay effect on an image")
 * )
 */
class Coloroverlay extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'HEX' => array(
        'description' => 'The color used to create the overlay.',
      ),
      'alpha' => array(
        'description' => 'The transparency of the overlay layer.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    $color = new Imagick();
    $color->newImage($res->getImageWidth(), $res->getImageHeight(), $arguments['HEX']);
    $color->setImageFormat('png');
    $color->setImageOpacity($arguments['alpha'] / 100);

    return $res->compositeImage($color, Imagick::COMPOSITE_DEFAULT, 0, 0);
  }

}
