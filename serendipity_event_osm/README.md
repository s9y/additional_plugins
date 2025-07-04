# OpenStreetMap plugin for Serendipity

With this plugin you can implement one ore more interactive
maps for geo tagged entries and uploaded \*.gpx files.
The map is build by [OpenLayers][ol], a high-performance
JavaScript library.

## Setup

Some plugins are needed to make it work.

### serendipity_event_geo_json or Geo-JSON object

First you need a JSON object with all the geo information
for your maps. This can be simple done with the plugin
`serendipity_event_geo_json` or by hand as a JavaScript
global constant like below.
	
```javascript
const geo = {
	"entries": [
		{
			"title": "I love Bochum",
			"url": "/archives/12-I-love-Bochum.html",
			"date": 1536588060,
			"size": 211,
			"author": "surrim",
			"pos": [51.414369, 6.729898],
			"categories": [42]
		},
		/* (more entries) */
	],
	"uploads": [
		{
			"title": "2021-06-30-essen-bochum.gpx",
			"url": "/uploads/my-tour/2021-06-30-essen-bochum.gpx",
			"date": 1610319360,
			"size": 105144
		},
		/* (more uploads) */
	]
};
```

### serendipity_event_static_osm

Next you need `serendipity_event_static_osm`.
It's needed to include all OpenLayers scripts and
stylesheets once. It can also remove all unnecessary things
from \*.gpx files like timestamps and metadata. This
behavior is enabled by default.
Enabling this is highly recommented to minimize traffic and
for uploading tracked data, for example from OsmAnd or
Garmin.
Geo data (including altitudes) will be untouched.

### serendipity_event_osm

This plugin can be used to include map instances. You can
set a default map position, zoomlevel, one or
more folders for the \*.gpx files and categories.
It inserts a div-element like below.

```html
<div
	class="map"
	data-category="42"
	data-path="/uploads/my-tour/"
	data-latitude="45.76697"
	data-longitude="4.83519"
	data-zoom="4"
	style="height: 463px"
></div>
```

All the div-elements will be processed by the mentioned
static scripts later.
You can display the total distance of all \*.gpx files by
using a span-element like this.

```html
Total distance: <span class="distance-counter" data-category="42">(calculating...)</span> kilometers.
```

## How to use

Now you can enable the `serendipity_event_geotag` plugin to
enter coordinates of your entries. When you paste data like
"45.76697, 4.83519" it will be put into the latitude and
longitude fields. After saving the changes the entry will be
shown on the map.
Uploading \*.gpx files is even simpler. After uploading a
file you will find it on the map.

## Features

- Minimap
  For faster position changes
- Fullscreen mode
  To use all of the pixels of your monitor or smartphone
  display
- Zoom
  You can use the mouse wheel, double click, use the buttons
  or two fingers on touchscreens to zoom
- Scale
  Shown to make it easier to see distances
- Rainbow colors
  The date of the entries and \*.gpx files is used to
  calculate its color by the day of the month. For example
  dates at the beginning or end of a month are red, dates in
  the middle of a months are cyan
- Interaction
  When you click on the map it will display a list of
  entries to read and tracks to download. Extra information
  like track length and date is shown as a tooltip

## Author

Kathi Sewelies <ruhrtour@surrim.org>

[ol]: https://openlayers.org/
