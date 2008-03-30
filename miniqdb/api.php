<?php

/*  miniqdb - A simple quote database written in PHP
    Copyright (C) 2008  Ian Weller <ianweller@gmail.com>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA. */

require "config.php";

header("Content-type: application/xml");

function return_data($method, $data) {
	global $dom;
	if ($method == 'rest') {
		$dom = new DOMDocument('1.0');
		$root = $dom->appendChild($dom->createElement('miniqdb'));
		element_iter_rest($data, $root);
		echo $dom->saveXML();
	} else {
		die("<b>Utter fail:</b> Caught in infinite invalid method loop.");
	}
	exit();
}

function element_iter_rest($array, $parent) {
	global $dom;
	foreach($array as $key=>$value) {
		foreach($value as $thatone) {
			$element = $dom->createElement($key);
			foreach($thatone as $stuff=>$moar) {
				if ($stuff == '#text') {
					$element->appendChild($dom->createTextNode($moar));
				} else if (substr($stuff, 0, 1) == '@') {
					$element->setAttribute(substr($stuff, 1), $moar);
				} else {
					element_iter_rest($thatone, $element);
				}
			}
			$parent->appendChild($element);
		}
	}
}

function throw_error($id) {
	global $_method;
	switch ($id) {
		case 1:
			$text = "invalid method";
			break;
		case 2:
			$text = "invalid act";
			break;
		case 3:
			$text = "no quote id";
			break;
		case 4:
			$text = "invalid quote id";
			break;
		default:
			$text = "unknown error";
	}
	return_data($_method, array('error' => array(0 => array('@id' => $id, '#text' => $text))));
}

function act_quote($method) {
	// act quote
	// required vars: id
	global $db;
	if (isset($_GET['id'])) {
		$_id = $_GET['id'];
	} else {
		throw_error(3);
	}
	$st = $db->prepare("SELECT * FROM miniqdb WHERE id=?");
	$st->execute(array($_id));
	if ($st->rowCount() == 0) {
		throw_error(4);
	} else {
		$data = array();
		$data['quote'] = array();
		foreach ($st->fetchAll() as $r) {
			$quote = array();
			$quote['@id'] = $r['id'];
			$quote['@timestamp'] = $r['epoch'];
			$quote['#text'] = implode("\n", explode("\r\n", $r['quote']));
			$quote['@lines'] = count(explode("\r\n", $r['quote']));
			$data['quote'][] = $quote;
		}
		return_data($method, $data);
	}
}

function act_stats($method) {
	global $db;
	// act stats
	// no vars
	$totalq = $db->query("SELECT COUNT(*) FROM miniqdb");
	$numq = $totalq->fetchColumn(0);
	$data = array();
	$data['stats'] = array();
	$data['stats'][] = array('@count' => $numq);
	return_data($method, $data);
}

// variable method
// You can use REST. This is the default. JSON soon.
if (!isset($_GET['method'])) {
	$_method = 'rest';
} else if ($_GET['method'] == 'rest') {
	$_method = 'rest';
} else {
	$_method = 'rest';
	throw_error(1);
}

// variable act
// Current available actions: quote stats
if (!isset($_GET['act'])) {
	throw_error(2);
}
switch($_GET['act']) {
	case 'quote':
		act_quote($_method);
		break;
	case 'stats':
		act_stats($_method);
		break;
	default:
		throw_error(2);
}

?>
