Spritpreise v1 by kill0rz (C) 2016 - visit kill0rz.com

Copyright
#########

Dieser Hack wurde unter "kill0rz' Unilecence v1.0 vom 08.08.2014" veröfentlicht. Diese liegt bei.

Beschreibung
############

Dieser Hack zeigt auf der Startseite die aktuellen Benzinpreise des Standortes des jeweiligen Nutzers an.
Möcthe der Nutzer seinen Standort nicht preisgeben, so werden die voreingestellten Koordinaten benutzt.

Changelog
#########

v1.0 (28.04.2016)
----
Grundskript

Datenschutz
###########

Die Position wird nur bei expliziter Nutzerinteraktion (Klick auf den Button) bestimmt und auch nur bis zum Ende der Browsersession gespeichert. Der Forenbetreiber mit diesem Hack hat keine Möglichkeit, diese auszulesen.

Die Daten werden einem externen Dienstleister gezogen. Bitte informiere deine Nutzer darüber, dass ihr aktueller Standort an tankerkoenig.de übertragen wird.

API-Schlüssel holen
###################

Zur Benutzung des Hacks ist es notwendig, einen API-Schlüssel von Tankerkoenig zu haben. Diesen bekommst du hier: https://creativecommons.tankerkoenig.de/#register

Installtion
###########

Lade die alle Dateien in der Struktur von /wbb2/ in deinen Forenordner.

Konfiguration anpassen: get_tank.php
======================= ------------

Oben in der Datei findest du die Konfigurationen.
Die einzelnen Parameter sind in der Datei erklärt.


Datei anpassen: index.php
=============== ---------

Suche:
eval("\$tpl->output(\"" . $tpl->get("index") . "\");");

Füge darüber ein:
include "get_tank.php";

Template anpassen: headinclude.tpl
================== ---------------

Füge ganz am Ende ein:
<script src="js/geolocation.js" type="text/javascript"></script>


Template anpassen: index.tpl
================== ---------

Suche:
<tr align="center">
	<td>
		<img src="{$style['imagefolder']}/on.gif" alt="{$lang->items['LANG_START_NEW_POSTS']}" title="{$lang->items['LANG_START_NEW_POSTS']}" border="0" /></td>
	<td>
		<span class="smallfont">{$lang->items['LANG_START_NEW_POSTS']}&nbsp;&nbsp;&nbsp;&nbsp;</span>
	</td>
	<td>
		<img src="{$style['imagefolder']}/off.gif" alt="{$lang->items['LANG_START_NONEW_POSTS']}" title="{$lang->items['LANG_START_NONEW_POSTS']}" border="0" /></td>
	<td>
		<span class="smallfont">{$lang->items['LANG_START_NONEW_POSTS']}&nbsp;&nbsp;&nbsp;&nbsp;</span>
	</td>
	<td>
		<img src="{$style['imagefolder']}/offclosed.gif" alt="{$lang->items['LANG_START_BOARD_CLOSED']}" title="{$lang->items['LANG_START_BOARD_CLOSED']}" border="0" /></td>
	<td>
		<span class="smallfont">{$lang->items['LANG_START_BOARD_CLOSED']}&nbsp;&nbsp;&nbsp;&nbsp;</span>
	</td>
	<td>
		<img src="{$style['imagefolder']}/link.gif" alt="{$lang->items['LANG_START_BOARD_LINK']}" title="{$lang->items['LANG_START_BOARD_LINK']}" border="0" /></td>
	<td>
		<span class="smallfont">{$lang->items['LANG_START_BOARD_LINK']}</span>
	</td>
</tr>
</table>


Füge darüber ein:
<table cellpadding="{$style['tableincellpadding']}" cellspacing="{$style['tableincellspacing']}" border="{$style['tableinborder']}" style="width:{$style['tableinwidth']}" class="tableinborder">
	<tr class="tabletitle">
		<td colspan="3">
			<span class="normalfont">
				<b>Aktuelle Benzinpreise</b>
			</span>
		</td>
	</tr>
	<tr>
		<td class="tablea">$get_tank_output[e10]</td>
		<td class="tableb">$get_tank_output[e5]</td>
		<td class="tablea">$get_tank_output[diesel]</td>
	</tr>
	<tr>
		<td class="tableb">
			<button id='geolocStart' onclick="ermittlePosition()">Ermittle aktuellen Standort</button>
		</td>
		<td class="tablea">
			$get_tank_headline
		</td>
		<td class="tableb">
			$get_tank_headline_werte
		</td>
	</tr>
</table>
<br />



FERTIG!
Nun können du und alle User auf der Startseite den aktuellen Spritpreis sehen!

Viel Spaß bei der Verwendung,
kill0rz
http://kill0rz.com/
Stand: 28.04.2016
