<?php
/**
 * @file
 * Contains key/value storage for itkore base config .
 */

namespace Drupal\itkore_base\State;

use Drupal\Core\KeyValueStore\DatabaseStorage;
use Drupal\Component\Serialization\SerializationInterface;
use Drupal\Core\Database\Connection;

class BaseConfig extends DatabaseStorage {
  /**
   * @param \Drupal\Component\Serialization\SerializationInterface $serializer
   * @param \Drupal\Core\Database\Connection $connection
   */
  public function __construct(SerializationInterface $serializer, Connection $connection) {
    parent::__construct('itkore_base.itkore_config', $serializer, $connection);
  }
}