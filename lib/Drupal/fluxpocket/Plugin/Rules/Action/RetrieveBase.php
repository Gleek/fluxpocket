<?php

/**
 * @file
 * Contains RetreiveBase.
 */

namespace Drupal\fluxpocket\Plugin\Rules\Action;

use Drupal\fluxpocket\Plugin\Service\PocketAccount;
use Drupal\fluxpocket\Plugin\Service\PocketAccountInterface;
use Drupal\fluxpocket\Rules\RulesPluginHandlerBase;

/**
 * Base class for Pocket Rules plugin handler.
 */
abstract class RetrieveBase extends RulesPluginHandlerBase implements \RulesActionHandlerInterface {

  /**
   * Convert page url to the item id stored in Pocket.
   * @param object $client
   *    Object to connect to Pocket services.
   * @param string|null $page_url
   *    String url to be converted to item_id
   * @return int|null $id
   *    Item Id of the given url
   */
  public function getItemIdFromUrl($client, $page_url = NULL) {
    if ($page_url == NULL) {
      return NULL;
    }
    $options = array(
    'state'         => 'all',
    'detailType'    => 'simple'
    );
    $list = $client->retrieve($options);

    // Calculate the item_id for the url.
    $id = NULL;
    foreach ($list->{'list'} as $index => $elements) {
      if ($list->{'list'}->$index->{'given_url'} == $page_url) {
        $id = $list->{'list'}->$index->{'item_id'};
      }
    }
    return $id;
  }

}
