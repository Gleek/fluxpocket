<?php

/**
 * @file
 * Contains ReplaceTag.
 */

namespace Drupal\fluxpocket\Plugin\Rules\Action;

use Drupal\fluxpocket\Plugin\Service\PocketAccount;
use Drupal\fluxpocket\Plugin\Service\PocketAccountInterface;
use Drupal\fluxpocket\Rules\RulesPluginHandlerBase;
use Duellsy\Pockpack\PockpackQueue;

/**
 * Action for replacing tags of a url with new ones.
 */
class ReplaceTag extends RetrieveBase {

  /**
   * Defines the action.
   */
  public static function getInfo() {
    return static::getInfoDefaults() + array(
      'name' => 'fluxpocket_replace_tag',
      'label' => t('Replace tags from a  Url with new ones in Pocket'),
      'parameter' => array(
        'page_url' => array(
          'type' => 'uri',
          'label' => t('Url'),
          'description' => t('The complete url. (e.g. http://www.example.com/page.html) or data-selector (eg. node:url in data selector mode)'),
        ),
        'tags' => array(
          'type' => 'text',
          'label' => t('List of tags to be replaced'),
          'description' => t('List of tags, seperated by comma (,)'),
        ),
        'account' => static::getAccountParameterInfo(),
      ),
    );
  }

  /**
   * Executes the action.
   */
  public function execute($page_url, $tags, PocketAccountInterface $account) {
    $client = $account->client();
    //Structuring the array of tags to be added
    //Getting Tag List
    $tag_ar = explode(",",$tags);
    //Trimming spaces from array list
    $tag_ar = array_filter(array_map('trim', $tag_ar));

    $item_id = RetrieveBase::getItemIdFromUrl($client, $page_url);

    $tag_info = array(
      'item_id'   => $item_id,
      'tags'      => $tag_ar
    );

    $pockpack_q = new PockpackQueue();

    $pockpack_q->tags_replace($tag_info);

    $client->send($pockpack_q);

  }
}
