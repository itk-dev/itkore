<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Posterize.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

/**
 * Defines imagick solarize operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_posterize",
 *   toolkit = "imagick",
 *   operation = "posterize",
 *   label = @Translation("Posterize"),
 *   description = @Translation("Posterizes an image.")
 * )
 */
class Posterize extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'colors' => array(
        'description' => 'Color levels per channel.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->posterizeImage($arguments['colors'], TRUE);
  }

}
