<?php

/**
 * @file
 * Contains Modify url.
 */

namespace Drupal\fluxpocket\Plugin\Rules\Action;

use Drupal\fluxpocket\Plugin\Service\PocketAccount;
use Drupal\fluxpocket\Plugin\Service\PocketAccountInterface;
use Drupal\fluxpocket\Rules\RulesPluginHandlerBase;
use Duellsy\Pockpack\PockpackQueue;

/**
 * Action for posting a status message on a page.
 */
class UnfavoriteUrl extends RulesPluginHandlerBase implements \RulesActionHandlerInterface {

  /**
   * Defines the action.
   */
  public static function getInfo() {
    return static::getInfoDefaults() + array(
      'name' => 'fluxpocket_unfavorite_url',
      'label' => t('Un-Favorite an item in Pocket'),
      'parameter' => array(
        'page_url' => array(
          'type' => 'uri',
          'label' => t('Url'),
          'description' => t('The complete url of item already added to favorites. (e.g. http://www.example.com/page.html) or data-selector (eg. node:url in data selector mode)'),
        ),
        'account' => static::getAccountParameterInfo(),
      ),
    );
  }


  /**
   * Executes the action.
   */
  public function execute($page_url, PocketAccountInterface $account) {
    $client = $account->client();
    //Structuring the array of url to be added
    //Getting Url List
    $options = array(
    'state'         => 'all',
    'detailType'    => 'simple'
    );
    $list= $client->retrieve($options);

    $pockpack_q = new PockpackQueue();

    //Calculate the item_id for the url
    unset($id);
    foreach ($list->{'list'} as $index => $elements) {
      if ($list->{'list'}->$index->{'given_url'} == $page_url) {
        $id = $list->{'list'}->$index->{'item_id'};
      }
    }

    if (isset($id)) {
      $pockpack_q->unfavorite($id);
    }
    $client->send($pockpack_q);
  }

}
