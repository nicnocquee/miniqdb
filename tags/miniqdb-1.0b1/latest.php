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

$result = mysql_query("SELECT id,quote FROM miniqdb ORDER BY id DESC LIMIT 10", $conn);

while ($r = mysql_fetch_assoc($result)) {
	echo '<div class="quote">';
	echo '<pre><a href="quote.php?id=' . $r['id'] . '">#' . $r['id'] . "</a>\n";
	echo $r['quote'];
	echo '</pre></div>';
}

echo $footer;

?>
