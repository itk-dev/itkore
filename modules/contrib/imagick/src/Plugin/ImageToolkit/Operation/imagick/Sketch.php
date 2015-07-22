<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Sketch.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

/**
 * Defines imagick sketch operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_sketch",
 *   toolkit = "imagick",
 *   operation = "sketch",
 *   label = @Translation("Sketch"),
 *   description = @Translation("Generates a sketch from an image.")
 * )
 */
class Sketch extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'radius' => array(
        'description' => 'The radius of the sketch.',
      ),
      'sigma' => array(
        'description' => 'The sigma of the sketch.',
      ),
      'angle' => array(
        'description' => 'The angle of the sketch.',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->sketchImage($arguments['radius'], $arguments['sigma'], $arguments['angle']);
  }

}
