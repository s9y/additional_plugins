<?php
/*	templates.functions.inc.php

	Template functions

Copyright (C) 2006 Chris Lander

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

Contact:
	Chris Lander		Email: clander@labbs.com

	LABBS Web Services
	54 Stanley Street
	Luton
	Bedfordshire
	United Kingdom
	LU1 5AN
*/

function expand_templatevars($templatevars) {
	debug_msg ("FUNCTION: ".__FUNCTION__,3);

	$iterate=true;
	while ($iterate) {
		$iterate = false;
		reset ($templatevars);
		while (list($key, $haystack) = each ($templatevars)) {
			debug_msg ('Haystack Name: '.$haystack['name'].' Value: '.$haystack['value'],5);
			$tplvars = $templatevars;
			foreach ($tplvars as $needle) {
				debug_msg ('&nbsp;&nbsp;&nbsp;&nbsp;Needle Name: '.$needle['name'].' Value: '.$needle['value'],5);
				if ($haystack['name'] != $needle['name']) {
					if (strstr($haystack['value'], '{'.$needle['name'].'}')) {
						debug_msg ('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Found Needle Name: '.$needle['name'].' in '.$haystack['name'],5);
						$haystack['value'] = str_replace('{'.$needle['name'].'}', $needle['value'], $haystack['value']);
						$iterate = true;
						$templatevars[$key] = $haystack;
					}
				}else{
					if (strstr($haystack['value'], '{'.$needle['name'].'}')) {
						debug_msg ('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Found Needle Name: '.$needle['name'].' in '.$haystack['name'],5);
						$haystack['value'] = str_replace('{'.$needle['name'].'}', '', $haystack['value']);
						$templatevars[$key] = $haystack;
					}
				}
			}
		}
	}
	return $templatevars;
} // end function expand_templatevars($templatevars, $blogdata, $templatedata)
?>