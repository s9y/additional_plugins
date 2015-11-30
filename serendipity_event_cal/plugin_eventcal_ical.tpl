{* file: plugin_eventcal_ical.tpl - 2015-11-29, Ian *}
##STARTICAL##BEGIN:VCALENDAR
PRODID:{$ical_proid}
VERSION:2.0
METHOD:{$ical_method}
CALSCALE:GREGORIAN
UTC-OFFSET:{$ical_offset}
X-WR-CALNAME:{$ical_title}
X-WR-CALDESC:{$ical_desc}
BEGIN:VTIMEZONE
TZID:{$ical_tzid}
X-LIC-LOCATION:{$ical_tzid}
BEGIN:DAYLIGHT
TZOFFSETFROM:{$ical_offset}
TZOFFSETTO:+0200
TZNAME:CEST
DTSTART:19700329T020000
RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=-1SU;BYMONTH=3
END:DAYLIGHT
BEGIN:STANDARD
TZOFFSETFROM:+0200
TZOFFSETTO:{$ical_offset}
TZNAME:{$ical_tzname}
DTSTART:19701025T030000
RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=-1SU;BYMONTH=10
END:STANDARD
END:VTIMEZONE
{foreach from=$ical_events item="event"}
{if isset($event.sdesc)}
BEGIN:VEVENT
CREATED:{$event.tstamp|date_format:"%Y%m%dT%H%M%S"}Z
LAST-MODIFIED:{$event.modified|date_format:"%Y%m%dT%H%M%S"}Z
DTSTAMP:{$ical_dtstamp}Z
SEQUENCE:{$event.id}
{if $event.uid}
UID:{$event.uid}
{else}
UID:{$ical_uid}-ID-{$event.id}@{$ical_host}
{/if}
SUMMARY:{$event.sdesc}
DTSTART;VALUE=DATE:{$event.sdato|date_format:"%Y%m%d"}
{if $event.edato && $event.tipo == 2}
DTEND;VALUE=DATE:{$event.edato|date_format:"%Y%m%d"}T240000
{/if}
ORGANIZER;CN="{$event.app_by}";RSVP=FALSE:MAILTO:""
DESCRIPTION:{$event.ldesc|replace:"\n":"\\n"}
{if $event.url}
URL;VALUE=URI:{$event.url}
{/if}
{if $ical_mailf}
ORGANIZER:MAILTO:{$ical_mailf}
{/if}
{if !$event.edato && $event.tipo == 2}
RRULE:FREQ=WEEKLY;UNTIL={$event.edato|date_format:"%Y%m%d"};INTERVAL=1
{/if}
{if $event.tipo == 3}
RRULE:FREQ=MONTHLY;UNTIL={$event.edato|date_format:"%Y%m%d"};INTERVAL=1;BYDAY={$event.recur}
{/if}
{if $event.tipo == 4}
RRULE:FREQ=WEEKLY;UNTIL={$event.edato|date_format:"%Y%m%d"};INTERVAL=1;BYDAY={$event.recur}
{/if}
{if $event.tipo == 5}
RRULE:FREQ=WEEKLY;UNTIL={$event.edato|date_format:"%Y%m%d"};INTERVAL=2;BYDAY={$event.recur}
{/if}
{if $event.tipo == 6}
RRULE:FREQ=YEARLY;INTERVAL=1;BYMONTH={$event.sdato|date_format:"%m"}
{/if}
PRIORITY:5
CLASS:PUBLIC
TRANSP:TRANSPARENT
END:VEVENT
{/if}
{/foreach}
END:VCALENDAR##ENDICAL##