<?php

/**
 * @file
 * Contains PocketEntryTaskBase.
 */

namespace Drupal\fluxpocket\Tasks;
/**
 * Common base class for Pocket task handlers.
 */
abstract class PocketEntryTaskBase extends PocketTaskBase {

  /**
   * {@inheritdoc}
   */
  public function runTask() {
    // Retrieve the timestamp of the last update that was processed and
    // continue right there.
    $store = fluxservice_key_value('fluxpocket.entries.since');
    $arguments = $this->getRequestArguments();
    $identifier = $this->task['identifier'];
    $account = $this->getAccount();


    $entries = $this->getList($account, $arguments);


    $updated_time = $this->getTime(end($entries));

    if ( $entries ) {
      $entries = fluxservice_entify_multiple($entries, 'fluxpocket_entry', $account);
      foreach ($entries as $entry) {
        rules_invoke_event($this->getEvent(), $account, $entry);
      }

      // Store the timestamp of the last item that was processed.
      //$last = end($entries);
      $store->set($this->task['identifier'], $updated_time);
    }
    elseif (empty($arguments['since'])) {
      $store->set($identifier, FALSE);
    }
  }


  /**
   *Retrieves the List for the particular task
   *
   */
  protected function getList($account, $arguments) {
    $response = $account->client()->retrieve($arguments);
    //Converting to array (encoding the object as json and then decoding as array)
    $entries = json_decode (json_encode ($response->{'list'}) , true);
    return $entries;
  }


  /**
   *Retrieves the corresponding time for particular task
   *
   */
  abstract protected function getTime($entries);

  /**
   * Retrieves the request arguments based on the event configuration.
   *
   * @return array
   *   The request arguments.
   */
  abstract protected function getRequestArguments();



}