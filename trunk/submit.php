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
$quote = $_POST["quote"];
$epoch = date("U");

// Replace IRC "<" and ">" characters with the HTML equivalent.
// Then strip newlines from the top and bottom of the quote.
$quote_lt = ereg_replace('<', '&lt;' , $quote);
$quote_gt = ereg_replace('>', '&gt;' , $quote_lt);
$quote_lb = trim($quote_gt);

// Insert into database as new. We leave out ID number cause the
// database will autoincrement that field by itself.

$sql = "INSERT INTO miniqdb (epoch,quote) VALUES ('$epoch','$quote_lb')";
$result = mysql_query($sql);
$id = mysql_insert_id();

echo "<p>quote posted</p>";
echo "<p>Quote <a href=\"quote.php?id=$id\">$id</a> was just added.</p>";
echo "<p><a href=\"index.php\">Go back to the QDB</a></p>";

echo $footer;

?>
