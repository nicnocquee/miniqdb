###
# miniqdb - A minimalistic quote database
# Copyright (C) 2008  Ian Weller <ianweller@gmail.com>
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
###

import supybot.utils as utils
import supybot.conf as conf
from supybot.commands import *
import supybot.plugins as plugins
import supybot.ircutils as ircutils
import supybot.callbacks as callbacks
import urllib
import httplib
import urlparse
import re
from xml.dom import minidom 


class Miniqdb(callbacks.Plugin):
    """Use this plugin in conjunction with a miniqdb instance on a server. You
    can use the "quote" command to view the link and information about a
    quote."""
    threaded = True

    def _prompt_user_passwd(self, host, realm):
        username = conf.supybot.plugins.Miniqdb.auth.username()
        password = conf.supybot.plugins.Miniqdb.auth.password()
        return (username, password)
    urllib.FancyURLopener.prompt_user_passwd = _prompt_user_passwd

    def quote(self, irc, msg, args, id):
        """<id>

        Returns a link to and information about quote <id>."""
        root = conf.supybot.plugins.Miniqdb.miniqdbRoot()
        maxlines = conf.supybot.plugins.Miniqdb.maxLines()
        url = str(root) + '/api.php?method=rest&act=quote&id=' +str(id)
        opener = urllib.FancyURLopener()
        xml = opener.open(url).read()
        dom = minidom.parseString(xml)
        errors = dom.getElementsByTagName('miniqdb')[0].getElementsByTagName('error')
        if errors != []:
            reply = "There is no quote by that id."
        else:
            quote = dom.getElementsByTagName('miniqdb')[0].getElementsByTagName('quote')[0]
            lines = int(quote.getAttribute('lines'))
            if lines > maxlines:
                reply = root+'/quote.php?id='+str(id) + ', ' + str(lines) + ' lines'
            else:
                reply = quote.firstChild.data.replace('&lt;','<').replace('&gt;','>')
        for line in reply.split('\n'):
            irc.reply(line)
    quote = wrap(quote, ['id'])

    def stats(self, irc, msg, args):
        """takes no arguments

        Returns some statistics from the QDB."""
        root = conf.supybot.plugins.Miniqdb.miniqdbRoot()
        maxlines = conf.supybot.plugins.Miniqdb.maxLines()
        url = str(root) + '/api.php?method=rest&act=stats'
        opener = urllib.FancyURLopener()
        xml = opener.open(url).read()
        dom = minidom.parseString(xml)
        stats = dom.getElementsByTagName('miniqdb')[0].getElementsByTagName('stats')[0]
        count = stats.getAttribute('count')
        irc.reply(format("There are %s quotes in the database.", count))


Class = Miniqdb


# vim:set shiftwidth=4 tabstop=4 expandtab textwidth=79:
