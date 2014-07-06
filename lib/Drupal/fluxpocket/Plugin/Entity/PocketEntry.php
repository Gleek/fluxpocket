<?php

/**
 * @file
 * Contains PocketEntry.
 */

namespace Drupal\fluxpocket\Plugin\Entity;

use Drupal\fluxservice\Entity\RemoteEntity;

/**
 * Entity class for Pocket Entries.
 */
class PocketEntry extends RemoteEntity implements PocketEntryInterface {

  /**
   * Defines the entity type.
   *
   * This gets exposed to hook_entity_info() via fluxservice_entity_info().
   */
  public static function getInfo() {
    return array(
      'name' => 'fluxpocket_entry',
      'label' => t('Pocket : Entry'),
      'module' => 'fluxpocket',
      'service' => 'fluxpocket',
      'controller class' => '\Drupal\fluxpocket\PocketEntryController',
      'entity keys' => array(
        'id' => 'drupal_entity_id',
        'remote id' => 'id',
      ),
      'fluxservice_efq_driver' => array(
        'default' => '\Drupal\fluxpocket\PocketEntryEntityQueryDriver',
      ),
    );
  }

  /**
   * Gets the entity property definitions.
   */
  public static function getEntityPropertyInfo($entity_type, $entity_info) {
    $info['item_id'] = array(
      'label' => t('Remote identifier'),
      'description' => t('The unique remote identifier of the Entry.'),
      'type' => 'text',
    );

    $info['time_added'] = array(
      'label' => t('Creation time'),
      'description' => t('The timestamp for when the URL was added.'),
      'type' => 'text',
      'getter callback' => 'entity_property_verbatim_date_get',
    );

    $info['time_updated'] = array(
      'label' => t('Updation time'),
      'description' => t('The timestamp for when the URL was updated.'),
      'type' => 'text',
    );

    $info['given_url'] = array(
      'label' => t('URL'),
      'description' => t('The URL for the entry.'),
      'type' => 'text',
      'required' => TRUE,
      'setter callback' => 'entity_property_verbatim_set',
    );

    $info['resolved_url'] = array(
      'label' => t('URL'),
      'description' => t('The URL for the entry.'),
      'type' => 'text',
    );

    $info['given_title'] = array(
      'label' => t('Given Title'),
      'description' => t('The Given Title for the entry'),
      'type' => 'text',
    );


    $info['resolved_title'] = array(
      'label' => t('Resolved Title'),
      'description' => t('The Resolved Title for the entry by Pocket'),
      'type' => 'text',
    );

    $info['excerpt'] = array(
      'label' => t('Excerpt'),
      'description' => t('The first few lines of the item \(articles only\)'),
      'type' => 'text',
    );

    $info['favorite'] = array(
      'label' => t('Favorite'),
      'description' => t('Indicates whether the URL is added to favorites or not'),
      'type' => 'text',
    );

    $info['status'] = array(
      'label' => t('Status'),
      'description' => t('Indicates whether the URL is added to Archives or is set for deletion'),
      'type' => 'text',
    );

    $info['is_article'] = array(
      'label' => t('Is Article'),
      'description' => t('Indicates whether the URL is an article or not'),
      'type' => 'text',
    );

    $info['has_image'] = array(
      'label' => t('Has Image'),
      'description' => t('Indicates whether the URL has an image or not'),
      'type' => 'text',
    );

    $info['has_video'] = array(
      'label' => t('Has Video'),
      'description' => t('Indicates whether the URL has an video or not'),
      'type' => 'text',
    );

    $info['word_count'] = array(
      'label' => t('Word Count'),
      'description' => t('Gives the word count of the article'),
      'type' => 'text',
    );

    return $info;
  }

}
