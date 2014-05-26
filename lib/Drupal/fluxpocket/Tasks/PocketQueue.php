<?php namespace Drupal\fluxpocket\Tasks\Pocket;

use Drupal\fluxpocket\Tasks\Pocket\NoItemException;
use Drupal\fluxpocket\Tasks\Pocket\InvalidItemTypeException;

class PocketQueue
{

    private $actions = array();

    /**
     * Grab the list of actions created so far
     * @return array
     */
    public function getActions()
    {

        return $this->actions;

    }

    /**
     * Clear the actions array
     * This is typically used after the send API call has been made
     * @return boolean
     */
    public function clear()
    {

        $this->actions = array();
        return sizeof($this->actions) == 0;

    }


    /**
     * All single actions are routed through this method,
     * to wrap the request in the required format for the
     * pocket API.
     *
     * Valid actions are: favorite, unfavorite, archive, readd, delete
     *
     * @param  int $item_id
     * @param  string $action
     */
    public function queue($item_id = null, $action = null)
    {

        if( is_null($item_id) ) {
            throw new NoItemException("No item id was sent");
        } else if ( ! is_numeric($item_id) ){
            throw new InvalidItemTypeException("The item id: $item_id is not valid it should be a number");
        }

        $this->actions[] =
            array(
                'action'        => $action,
                'item_id'       => $item_id,
                'time'          => time()
            );

        return true;

    }



    /**
     * Archive a particular bookmark
     *
     * @param  int $item_id
     */
    public function add($link_info = array())
    {

        if( ! isset($link_info['url']) ) {
            throw new NoItemException("The url is required when adding a link");
        }

        $base_info  = array(
            'action'        => 'add',
            'time'          => time()
        );

        $link_info = array_merge($base_info, $link_info);

        $this->actions[] = $link_info;

        return true;

    }



    /**
     * Archive a particular bookmark
     *
     * @param  int $item_id
     */
    public function archive($item_id = null)
    {
        return self::queue($item_id, 'archive');
    }



    /**
     * Re-add a bookmark that was previously archived
     *
     * @param  int $item_id
     */
    public function readd($item_id = null)
    {
        return self::queue($item_id, 'readd');
    }



    /**
     * Mark as bookmark as a favorite
     *
     * @param  int $item_id
     */
    public function favorite($item_id = null)
    {
        return self::queue($item_id, 'favorite');
    }



    /**
     * Unmark as bookmark as a favorite
     *
     * @param  int $item_id
     */
    public function unfavorite($item_id = null)
    {
        return self::queue($item_id, 'unfavorite');
    }



    /**
     * Remove a particular bookmark
     *
     * @param  int $item_id
     */
    public function delete($item_id = null)
    {
        return self::queue($item_id, 'delete');
    }



}
