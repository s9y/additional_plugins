# serendipity_plugin_piwik

## Description

This is just a small sidebar-plugin which can connect to your Piwik-installation. If you want to
use it, you have to set up an user who has at least read-access to piwik. Within user-managment of
piwik you can create a new one, if you don't want to use admin.

If you don't need one part of the statistics, just disable it.

If you want to change the order of output, install the plugin twice, it's stackable :)
Now, you can can enable or disable any part of every instance until you are happy ;)

## known bugs

In some cases (i think, it only happens if main/index-page is in the top xx-list) page-url and page-title of section "most read entries" are not for the same page. I don't know why, but Piwik gives different output for the fetching of url and title and at the moment i don't know how i could solve this problem.
