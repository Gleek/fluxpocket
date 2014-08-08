Usage
======


Installation
------------

- Install (dependencies)
  - flux Services integration
  - fluxkraft
  - Universally Unique ID
  - Entity API
  - Composer Manager
  - xautoload-7.x-4.x-dev

- Install Module
  - `git clone https://github.com/Gleek/fluxpocket.git` in the `/sites/all/modules`
- Enable these newly added module
- Install composer dependencies through
```
 drush composer-json-rebuild
 drush composer-manager update
```


Usage
-------

- Create a [Pocket App](http://getpocket.com/developer/apps/new)
- Add a service endpoint for Pocket (Add consumer key of the app created) (Configuration > Web Services > Service endpoint)
- Add service account (will authorise the app with your account)
- Add Rules (see below for details)
- Enjoy!!


Rules Provided
-----------------

###Events###
  - **A new URL was added in Pocket** : Triggered when a new url is added to the Pocket
  - **A URL is added to favorites in Pocket** : Triggered when a URL is added to favorites in Pocket
  - **A URL is added to archives in Pocket** : Triggered when a URL is added to archives in Pocket
  - **A URL is updated in Pocket** : Triggered when any change takes place in Pocket

*Caution:* Don't forget to configure your cron for the Events to work

###Action###
  - **Add url along with tags** : Addition of URL to Pocket. Optionally you can also provide tags
  - **Delete URL** : Deletion of URL from Pocket
  - **Archive / Unarchive URL** : Two seperate actions are provided for archiving purpose.
  - **Favorite / Unfavorite URL** : Two seperate actions are provided for favorite purpose
  - **Adding Tags** : Action Add tags to an entry in the already existing tags.
  - **Replacing Tags** : Replace tags of an entry with new provided tags.
  - **Clearing Tags**: Clear all tags of an entry


### Checking for tags ###

- Defining Event *A URL is updated* or any other event for the purpose
- Select Condition *List contain items*
- Using List *pocket:tags*
- Use direct input mode to write a tag to be checked manually or use the data selection mode to use a variable containing tag name
- You're done!!

### List of Variables provided by Events ###

|Token                   | Type         | Description                                |
|------------------------|--------------|--------------------------------------------|
| [pocket:item-id]	     | Integer      |   The unique remote identifier of the Entry.  - `12345`|
| [pocket:time-added]    | Integer	    |   The Unix timestamp for when the URL was added.  -`1407491922`|
| [pocket:time-updated]	 | Integer      |   The timestamp for when the URL was updated.  `1407491922` |
| [pocket:given-url]	 | Text         |   The Given URL for the entry.  `drupal.org`|
| [pocket:resolved-url]	 | Text         |   The URL for the entry, after being resolved by Pocket : `https://www.drupal.org/`|
| [pocket:given-title]   | Text         |	The Given Title for the entry : `My favorite page`|
| [pocket:resolved-title]| Text         |	The Resolved Title for the entry by Pocket : `Drupal - Open Source CMS | Drupal.org`|
| [pocket:excerpt]       | Text         |   The first few lines of the item (articles only) : `Drupal is an open source content management platform powering millions of websites and applications. It’s built, used, and supported by an active and diverse community of people around the world.`|
| [pocket:tags]	         | List of Text |   A collection of tags associated with the particular entry. :`"tag1","tag2"`|
| [pocket:favorite]		 | Integer      |   Indicates whether the URL is added to favorites or not :`1` if favorite ,`0` if not |
| [pocket:status]		 | Integer      |   Indicates whether the URL is added to Archives or is set for deletion: `1` if archived `2` if should be deleted |
| [pocket:is-article]	 | Integer      |	Indicates whether the URL is an article or not: `1` if article `0` if not |
| [pocket:has-image]	 | Integer      |	Indicates whether Pocket detects image on the page or not `1` if image found, `0` if not |
| [pocket:has-video]     | Integer	    |	Indicates whether Pocket detects video on the page or not `1` if image found, `0` if not |
| [pocket:word-count]	 | Integer	    |   Gives the word count of the article : `1021`|

###Example Rules

####Adding Drupal Article and automatically saving it in Pocket for later read####
**Event**
- **React on Rule** : After saving new content
- **Restrict by Type**: Article

**Action** (Add URL to pocket)
- **URL** : node:url
- **Tags** : \<Comma seperated tags, if any\>
- **Pocket Account** : \<Select your e-mail address\>

Similarly a rule can be added to delete or archive url in pocket everytime an Article is deleted on a drupal site.

####Tweeting about your favorite articles in Pocket (also involves fluxtwitter)####
**Event**
- **React on Rule** : A URL is added to favorites in Pocket
- **Account** : \<Select your email id from the list\>

**Action** (Tweet)
- **Value**: \[pocket:given-url] <any other text\>
- **Account**: \<Select your tweet handle\>


####Other Examples of Rules which are currently supported####

- Add new items from an RSS feed to Pocket (requires flux feeds)
- Save links from favorite tweet to Pocket (requires fluxtwitter)
- Shared link on facebook is saved to pocket (requires fluxfacebook)
- Favorite bookmarked file link in pocket is added to dropbox (requires fluxdropbox)
- Create a facebook post with what you just favorited in pocket

*Many other services can be implemented which may require seperarate fluxservices. Find more of them on [fluxservices drupal page](https://www.drupal.org/project/fluxservice)*
