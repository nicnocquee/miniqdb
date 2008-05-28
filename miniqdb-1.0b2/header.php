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

require 'config.php';

$totalq = $db->query("SELECT COUNT(*) FROM miniqdb");
$numq = $totalq->fetchColumn(0);

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">';
echo "<html>";
echo <<<EOF
	<head>
		<title>$qdbname</title>
		<style type="text/css">
			body {
				font-size: 14px;
				font-family: sans-serif;
			}
            h1 {
                display: inline;
            }
	    span#user {
	    	float: right;
	    }
            h1 a {
                color: black;
                text-decoration: none;
            }
            form[action="quote.php"] {
                display: inline;
		padding-left: 10px;
            }
			pre {
				font-family: monospace;
			}
			div.quote {
				margin-bottom: 10px;
			}
			div.quote pre:first-line {
				color: #666666;
				font-size: 12px;
				border-bottom: 1px solid #666666;
			}
		</style>
	</head>
	<body>
		<h1><a href="index.php">$qdbname</a></h1>
		<form action="quote.php" method="get">
			<span>$numq quotes - <a href="all.php">all</a> - <a href="index.php">random</a> - <a href="latest.php">latest 10</a> - <a href="add.php">add</a> - #<input type="text" name="id" size="4" /></span>
		</form>
EOF;

$footer = "<p><small>powered by <a href=\"http://miniqdb.googlecode.com/\">miniqdb</a></body></html>";

?>
