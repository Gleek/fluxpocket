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
 * Base class for twitter Rules plugin handler.
 */
abstract class RetrieveBase extends RulesPluginHandlerBase implements \RulesActionHandlerInterface {

  public function getItemIdFromUrl($client, $page_url = NULL) {
    if ($page_url == NULL) {
      return NULL;
    }
    $options = array(
    'state'         => 'all',
    'detailType'    => 'simple'
    );
    $list = $client->retrieve($options);
    //Calculate the item_id for the url
    $id = NULL;
    foreach ($list->{'list'} as $index => $elements) {
      if ($list->{'list'}->$index->{'given_url'} == $page_url) {
        $id = $list->{'list'}->$index->{'item_id'};
      }
    }
    return $id;
  }

}
