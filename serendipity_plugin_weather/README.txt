About
=====

This plugin uses PEAR::Services_Weather to retrieve METAR weather information
for a given location and display them.

Installation
============

    export SERENDIPITY_HOME=/path/to/serendipity    
    mkdir -p $SERENDIPITY_HOME/plugins/serendipity_plugin_weather
    cp serendipity_plugin_weather.php \
       $SERENDIPITY_HOME/plugins/serendipity_plugin_weather
    cp -r dot/pixel $SERENDIPITY_HOME
