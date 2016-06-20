<?php
/**
* @file
* Contains \Drupal\itk_instagram_hashtag\Plugin\Field\FieldType\InstagramHashtagItem.
*/

namespace Drupal\itk_instagram_hashtag\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'field_instagram_hashtag' field type.
 *
 * @FieldType(
 *   id = "field_instagram_hashtag",
 *   label = @Translation("Instagram hashtag"),
 *   module = "itk_instagram_hashtag",
 *   description = @Translation("This field stores an instagram hashtag in the database."),
 *   default_widget = "field_instagram_hashtag_default_widget",
 *   default_formatter = "field_instagram_hashtag_default_formatter"
 * )
 */
class InstagramHashtagItem extends FieldItemBase {
  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field) {
    return array(
      'columns' => array(
        'value' => array(
          'type' => 'text',
          'size' => 'tiny',
          'not null' => FALSE,
        ),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('Value'));

    return $properties;
  }
}

