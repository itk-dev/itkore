<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Blur.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

use Drupal\imagick\ImagickConst;

/**
 * Defines imagick blur operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_blur",
 *   toolkit = "imagick",
 *   operation = "blur",
 *   label = @Translation("Blur"),
 *   description = @Translation("Blurs an image, different methods can be used.")
 * )
 */
class Blur extends ImagickImageToolkitOperationBase {

  /**
   * {@inheritdoc}
   */
  protected function arguments() {
    return array(
      'type' => array(
        'description' => 'The type of blur used',
      ),
      'radius' => array(
        'description' => 'The radius of the Gaussian, in pixels, not counting the center pixel.',
      ),
      'sigma' => array(
        'description' => 'The standard deviation of the Gaussian, in pixels',
      ),
      'angle' => array(
        'description' => 'The angle of the blur',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    switch ($arguments['type']) {
      case ImagickConst::NORMAL_BLUR:
        return $res->blurImage($arguments['radius'], $arguments['sigma']);
        break;
      case ImagickConst::ADAPTIVE_BLUR:
        return $res->adaptiveBlurImage($arguments['radius'], $arguments['sigma']);
        break;
      case ImagickConst::GAUSSIAN_BLUR:
        return $res->gaussianBlurImage($arguments['radius'], $arguments['sigma']);
        break;
      case ImagickConst::MOTION_BLUR:
        return $res->motionBlurImage($arguments['radius'], $arguments['sigma'], $arguments['angle']);
        break;
      case ImagickConst::RADIAL_BLUR:
        return $res->radialBlurImage($arguments['angle']);
        break;
      default:
        return NULL;
        break;
    }
  }

}
