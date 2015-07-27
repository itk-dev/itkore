<?php

/**
 * @file
 * Contains \Drupal\imagick\Plugin\ImageToolkit\Operation\imagick\Desaturate.
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

use Drupal\system\Plugin\ImageToolkit\Operation\gd\Desaturate as GdDesaturate;
use Imagick;

/**
 * Defines imagick desaturate operation.
 *
 * @ImageToolkitOperation(
 *   id = "imagick_desaturate",
 *   toolkit = "imagick",
 *   operation = "desaturate",
 *   label = @Translation("desaturate"),
 *   description = @Translation("Desaturate an image.")
 * )
 */
class Desaturate extends GdDesaturate {

  /**
   * {@inheritdoc}
   */
  protected function execute(array $arguments = array()) {
    /* @var $res \Imagick */
    $res = $this->getToolkit()->getResource();

    return $res->setImageType(imagick::IMGTYPE_GRAYSCALEMATTE);
  }

}
