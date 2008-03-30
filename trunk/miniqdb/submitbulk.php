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

require "header.php";

// Gets args from POST
$quote = stripslashes_if_gpc_magic_quotes($_POST["quote"]);

// Explode that text.
$kaboom = explode("\r\n\r\n", $quote);

$ids = array();

foreach($kaboom as $quote) {

	global $ids;
	
	// Replace IRC "<" and ">" characters with the HTML equivalent.
	// Then strip newlines from the top and bottom of the quote.
	$quote_lt = ereg_replace('<', '&lt;' , $quote);
	$quote_gt = ereg_replace('>', '&gt;' , $quote_lt);
	$quote_lb = trim($quote_gt);

	// Insert into database as new. We leave out ID number cause the
	// database will autoincrement that field by itself.

	$st = $db->prepare('INSERT INTO miniqdb (epoch,quote) VALUES (?,?)');
	$st->execute(array(date('U'), $quote_lb));
	$ids[] = $db->lastInsertId();

}

$qcount = count($ids);
echo "<p>$qcount quotes posted</p>";
echo "<p>The following $qcount quotes were added:</p>";
foreach($ids as $id) {
	$idstrs[] = "<a href=\"quote.php?id=$id\">$id</a>";
}
$quotes = implode(' ', $idstrs);
echo "<p>$quotes</p>";
echo "<p><a href=\"index.php\">Go back to the QDB</a></p>";

?>
