<?php

/**
 * @file
 * Contains PocketEntryTaskHandler.
 */

namespace Drupal\fluxpocket\Task;
/**
 * Event dispatcher for the Facebook status messages.
 */
class PocketEntryTaskHandler extends PocketTaskBase {

  /**
   * {@inheritdoc}
   */
  public function runTask() {
    $owner = $this->task['data']['owner'];

    // Assemble the request arguments.
    $arguments = array(
      'state'         => 'all',
      'detailType'    => 'complete'
    );

    // Retrieve the timestamp of the last status update that was processed and
    // continue right there.
    $store = fluxservice_key_value('fluxpocket.entries');
    $arguments['since'] = $store->get($this->task['identifier']) ?: $this->task['date'];

    $account = $this->getAccount();
    $response = $account->client()->retrive($arguments);
    $messages = $response->{'list'};
    if (($response && $messages)){
      foreach($messages as &$message) {
        $message['type'] = 'entry';
      }
      $messages = fluxservice_entify_multiple($messages, 'fluxpocket_object', $account);
      foreach ($messages as $message) {
        rules_invoke_event($this->getEvent(), $account, $message, $owner);
      }

      // Store the timestamp of the last status message that was processed.
      $last = end($messages);
      $store->set($this->task['identifier'], $last->getUpdatedTime());
    }
  }

}
