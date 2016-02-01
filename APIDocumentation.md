﻿﻿#summary Documentation for the API
#labels Section-API,Featured

The **miniqdb API** is a simple way for non-humans to read the database. It is provided through api.php.

REST (XML) is currently implemented; JSON is soon to come. More actions will also soon be available.

Throughout this documentation, the root of the miniqdb instance will be `http://example.com/stuff/miniqdb`; therefore, the URL we will be accessing will be `http://example.com/stuff/miniqdb/api.php`.

# Basic syntax #
URLs are setup using GET requests. For example, accessing the URL
> `http://example.com/stuff/miniqdb/api.php?method=rest&act=quote&id=42`
would return quote 42 in REST format.

The _method_ variable is optional; it defaults to rest. The _act_ variable is **required**. Other variables may be available or required depending on the action; per-action syntax is defined below.

# quote #
Retrieve a single quote by id.

## Variables ##

| **Variable** | **Required?** | **Description** |
|:-------------|:--------------|:----------------|
| id           | yes           | id of quote you want to access |

Example: `http://example.com/stuff/miniqdb/api.php?method=rest&act=quote&id=42` would return quote 42.

## Return ##
A single element, `quote`, is returned. The text of this element is the quote itself.

### `quote` Attributes ###
| **Attribute** | **Description** |
|:--------------|:----------------|
| id            | id number of the quote |
| timestamp     | UNIX epoch of when quote was added |
| lines         | number of lines in the quote |

# stats #
Retrieve statistics on the qdb.

## Variables ##

| **Variable** | **Required?** | **Description** |
|:-------------|:--------------|:----------------|
|              |               | There are no variables for this action |

Example: `http://example.com/stuff/miniqdb/api.php?method=rest&act=stats` would return statistics.

## Return ##
A single element, `stats`, is returned. This contains the attribute `count`, which is a count of all the quotes in the database.

# random #
Retrieve random quotes.

## Variables ##

| **Variable** | **Required?** | **Description** |
|:-------------|:--------------|:----------------|
| count        | no            | number of random quotes you want |

Example: `http://example.com/stuff/miniqdb/api.php?method=rest&act=random&count=2` would return 2 random quotes.

## Return ##
`quote` element(s) are returned. The text of these elements is the quote itself.

### `quote` Attributes ###
| **Attribute** | **Description** |
|:--------------|:----------------|
| id            | id number of the quote |
| timestamp     | UNIX epoch of when quote was added |
| lines         | number of lines in the quote |

# Errors #
| **Error number** | **Error text** | **Explanation** |
|:-----------------|:---------------|:----------------|
| 1                | invalid method | You specified an incorrect method. Valid methods are listed above. |
| 2                | invalid act    | You specified an invalid action. Valid actions are listed above. |
| 3                | no quote id    | You did not specify the quote id when it was required for `act=quote`. |
| 4                | invalid quote id | The quote id you specified was invalid. |

# bugz. #
File an issue or feature request with the labels Project-miniqdb and Component-API.