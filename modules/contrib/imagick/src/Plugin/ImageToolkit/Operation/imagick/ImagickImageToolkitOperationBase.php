<?php

/**
 * @file
 * Contains Drupal\imagick\Plugin\ImageToolkit\Operation\gd\GDToolkitOperationBase
 */

namespace Drupal\imagick\Plugin\ImageToolkit\Operation\imagick;

use Drupal\Core\ImageToolkit\ImageToolkitOperationBase;

abstract class ImagickImageToolkitOperationBase extends ImageToolkitOperationBase {

  /**
   * The correctly typed image toolkit for GD operations.
   *
   * @return \Drupal\imagick\Plugin\ImageToolkit\ImagickToolkit
   */
  protected function getToolkit() {
    return parent::getToolkit();
  }

}
