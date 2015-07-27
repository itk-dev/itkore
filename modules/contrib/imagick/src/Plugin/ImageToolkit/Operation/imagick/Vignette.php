<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Vignette.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

/**
 * Defines imagick vignette operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_vignette",
 *   toolkit = "imagick",
 *   operation = "vignette",
 *   label = @Translation("Vignette"),
 *   description = @Translation("Adds vignette to an image.")
 * )
 */
class Vignette extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'blackpoint' => array(
        'description' => 'The black point.',
      ),
      'whitepoint' => array(
        'description' => 'The white point.',
      ),
      'x' => array(
        'description' => 'The X offset of the ellipse.',
      ),
      'y' => array(
        'description' => 'The Y offset of the ellipse.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->vignetteImage($arguments['blackpoint'], $arguments['whitepoint'], $arguments['x'], $arguments['y']);
  }

}
