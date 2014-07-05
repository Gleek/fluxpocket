FluxPocket
=============
[Pocket](http://getpocket.com)\(Formerly Read-It-Later\) Integration for Fluxkraft
----------------------------------------------------------------------------------------

**Project Under Development**

This project is done as the Google Summer of Code Project under Drupal.
You can read the full proposal on http://goo.gl/g5UpZY 

####Dependecies####
- fluxservices Integration
- duellsy pockpack Package \(install through composer\)

####What Works####
- Authentication
- Action
  - Add url along with tags
  - Delete URL
  - Archive / Unarchive URL
  - Favorite / Unfavorite URL
- Events / Triggers
  - URL is added

####What's Left####
- Documentation
- Some Actions and Events \(Refer to the [issues](https://github.com/Gleek/fluxpocket/issues)\)

####Usage####
- `git clone` the Project in the `/sites/all/modules`
- Enable this newly added module from admin panel
- Install composer dependencies through
```
 drush composer-json-rebuild
 drush composer-manager update
```
- Create a [Pocket App](http://getpocket.com/developer/apps/new)
- Add a service endpoint for Pocket (Add consumer key)
- Add service account (authorise the app)
- Add Rules
- Enjoy!!
  
