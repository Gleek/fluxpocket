<?php

/**
 * @file
 * Contains UploadFile.
 */

namespace Drupal\fluxpocket\Plugin\Rules\Action;

use Drupal\fluxpocket\Plugin\Service\PocketAccount;
use Drupal\fluxpocket\Plugin\Service\PocketAccountInterface;
use Drupal\fluxpocket\Rules\RulesPluginHandlerBase;
use Duellsy\Pockpack\PockpackQueue;

/**
 * Action for posting a status message on a page.
 */
class AddUrl extends RulesPluginHandlerBase implements \RulesActionHandlerInterface {

  /**
   * Defines the action.
   */
  public static function getInfo() {
    return static::getInfoDefaults() + array(
      'name' => 'fluxpocket_add_url',
      'label' => t('Add Url to Pocket'),
      'parameter' => array(
        'page_url' => array(
          'type' => 'uri',
          'label' => t('Url'),
          'description' => t('The complete url. (e.g. http://www.example.com/page.html) or data-selector (eg. node:url in data selector mode)'),
        ),
        'tags' => array(
          'type' => 'text',
          'label' => t('List of tags'),
          'description' => t('List of tags seperated by comma (,)'),
          '#required' => FALSE,
        ),
        'account' => static::getAccountParameterInfo(),
      ),
    );
  }

  function fluxpocket_form_alter(&$form, &$form_state, $form_id) {
   drupal_set_message($form_id);  // print form ID to messages
   drupal_set_message(print_r($form, TRUE));  // print array to messages
  }

  /**
   * Executes the action.
   */
  public function execute($page_url, $tags, PocketAccountInterface $account) {
    $client = $account->client();
    //Structuring the array of url to be added
    //Getting Tag List
    $tag_ar = explode(",",$tags);
    //Trimming spaces from array list
    $tag_ar = array_filter(array_map('trim', $tag_ar));
    $link_info = array(
      'url'       => $page_url,
      'tags'      => $tag_ar
    );

    $pockpack_q = new PockpackQueue();

    $pockpack_q->add($link_info);
    $client->send($pockpack_q);
  }
}
