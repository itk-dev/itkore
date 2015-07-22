<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Modulate.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

/**
 * Defines imagick modulate operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_modulate",
 *   toolkit = "imagick",
 *   operation = "modulate",
 *   label = @Translation("Modulate"),
 *   description = @Translation("Modulates the image.")
 * )
 */
class Modulate extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'brightness' => array(
        'description' => 'Brightness in percentage.',
      ),
      'saturation' => array(
        'description' => 'Saturation in percentage.',
      ),
      'hue' => array(
        'description' => 'Hue in percentage.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->modulateImage($arguments['brightness'], $arguments['saturation'], $arguments['hue']);
  }

}
