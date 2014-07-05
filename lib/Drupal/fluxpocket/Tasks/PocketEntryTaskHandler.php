<?php

/**
 * @file
 * Contains PocketEntryTaskHandler.
 */

namespace Drupal\fluxpocket\Tasks;
/**
 * Event dispatcher for the Facebook status messages.
 */
class PocketEntryTaskHandler extends PocketTaskBase {

  /**
   * {@inheritdoc}
   */
  public function runTask() {
    // Retrieve the timestamp of the last status update that was processed and
    // continue right there.
    $store = fluxservice_key_value('fluxpocket.entries.since');
    $arguments = $this->getRequestArguments();
    $identifier = $this->task['identifier'];
    $account = $this->getAccount();
    $response = $account->client()->retrieve($arguments);
    //Converting to array (encoding the object as json and then decoding as array)
    $entries = json_decode(json_encode($response->{'list'}),true);

    //Hack to get the updated time Correct method is to implement this in entity class
    $updated_time = intval(end($entries)['time_updated']);

    if (($response && $entries)) {
      $entries = fluxservice_entify_multiple($entries, 'fluxpocket_entry', $account);
      foreach ($entries as $entry) {
        rules_invoke_event($this->getEvent(), $account, $entry);
      }

      // Store the timestamp of the last status message that was processed.
      //$last = end($entries);
      $store->set($this->task['identifier'], $updated_time);
    }
    elseif (empty($arguments['since'])) {
      $store->set($identifier, FALSE);
    }
  }

  /**
   * Retrieves the request arguments based on the event configuration.
   *
   * @return array
   *   The request arguments.
   */
  protected function getRequestArguments() {
    $arguments = array(
      'state'         => 'all',
      'detailType'    => 'complete',
      'sort'          => 'oldest'
    );
    // We store the remote identifier of the last Pocket Entry that was
    // processed so that we can benefit from the 'since_id' query argument.
    $store = fluxservice_key_value('fluxpocket.entries.since');
    if ($since_id = $store->get($this->task['identifier'])) {
      $arguments['since'] = $since_id;
    }
    // If it hasn't been set yet, it means that we are running this for thes
    // first time. In order to prevent flooding and processing of old Entries we
    // limit the request to only three Entries.
    elseif ($since_id === NULL) {
      $arguments['count'] = 3;
    }
    return $arguments;
  }

}
