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
class ModifyUrl extends RulesPluginHandlerBase implements \RulesActionHandlerInterface {

  /**
   * Defines the action.
   */
  public static function getInfo() {
    return static::getInfoDefaults() + array(
      'name' => 'fluxpocket_modify_url',
      'label' => t('Modify/Delete Url from Pocket'),
      'parameter' => array(
        'page_url' => array(
          'type' => 'uri',
          'label' => t('Url'),
          'description' => t('The complete url. (e.g. http://www.example.com/page.html) or data-selector (eg. node:url in data selector mode)'),
        ),
        'extra' => array(
          'type' => 'integer',
          'label' => t('Method'),
          'description' => t('Type number for the option &nbsp; 0: Delete(default) &nbsp; 1: Archive &nbsp; 2: Favorite &nbsp; 3: Unfavorite &nbsp; 4: Re-Add'),
          'default value' => 0,
          'restriction' => 'input',
        ),
        'account' => static::getAccountParameterInfo(),
      ),
    );
  }


  /**
   * Executes the action.
   */
  public function execute($page_url,$extra, PocketAccountInterface $account) {
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
      if ($extra == 0) {
        $pockpack_q->delete($id);
      }
      elseif ($extra == 1) {
        $pockpack_q->archive($id);
      }
      elseif ($extra == 2) {
        $pockpack_q->favorite($id);
      }
      elseif ($extra == 3) {
        $pockpack_q->unfavorite($id);
      }
      elseif ($extra == 4) {
        $pockpack_q->readd($id);
      }
      $client->send($pockpack_q);
    }
  }

}
