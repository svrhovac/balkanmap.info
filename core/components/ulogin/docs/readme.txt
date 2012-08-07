=== uLogin  ===
Donate link: http://ulogin.ru/
Tags: ulogin, login, social, authorization
Requires at least: 2.0 revolution
Tested up to: 2.2.0-pl2
Stable tag: 1.7

uLogin is a widget that allows users to sign in with their Facebook, Vkontakte, Odnoklassniki, Google accounts.


== Installation ==

Install it from MODX package managment.

Run: [[!uLogin]]
 
Parameters:

ul_id   - Widget's id;
display - Display option (small/panel/window);
wintip  - Window tip message;
fields  - The list of requested fields from the user profile;
provdires - List of providers on panel;
hidden - List of providers on dropdown menu;
redirect - Link to receive token;
callback - Java script function to receive token without redirect;
usr_hello - User's greeting;
usr_profile - Link to user profile;
signout_msg - Description for "Sign out" link;
signout_url - "Sign out" link;
usrpanel - Name of user panel's template (default - userpanel). File wildcard "*.chunk.tpl";