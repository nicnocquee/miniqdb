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

include "header.php";

echo <<<EOF
<form action="submit.php" method="post">
<p><a href="bulk.php">bulk add</a></p>
<p>please remember to remove timestamps and unrelated chatter. keep quotes to 80 characters wide (the width of this box).</p>
<textarea name="quote" rows="15" cols="80"></textarea></p>
<p><i>Did you remove timestamps?</i></p>
<p><i>Did you keep your quotes to 80 characters wide?</i></p>
<p><input type="submit" value="Add quote"></p>
EOF;

echo $footer;

?>
