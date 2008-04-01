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

import supybot.conf as conf
import supybot.registry as registry

def configure(advanced):
    # This will be called by supybot to configure this module.  advanced is
    # a bool that specifies whether the user identified himself as an advanced
    # user or not.  You should effect your configuration by manipulating the
    # registry as appropriate.
    from supybot.questions import expect, anything, something, yn
    output("""Where is your miniqdb instance located? Please don't put a slash
    at the end of the URL -- for example, http://example.com/miniqdb .""")
    root = something('root?')
    conf.registerPlugin('Miniqdb', True)
    conf.supybot.plugins.Miniqdb.miniqdbRoot.setValue(root)
    output("""This plugin has support to utilize HTTP Basic authentication.
    HTTP Digest is not supported just yet.""")
    if yn("Do you use HTTP Basic authentication on your miniqdb?"):
        conf.supybot.plugins.Miniqdb.auth.username.setValue(something('username?'))
        conf.supybot.plugins.Miniqdb.auth.username.setValue(something('password?'))
    output("""Thanks for using miniqdb! http://miniqdb.googlecode.com/""")


Miniqdb = conf.registerPlugin('Miniqdb')
# This is where your configuration variables (if any) should go.  For example:
# conf.registerGlobalValue(Miniqdb, 'someConfigVariableName',
#     registry.Boolean(False, """Help for someConfigVariableName."""))
conf.registerChannelValue(Miniqdb, 'miniqdbRoot', registry.String('', """The
    root of the miniqdb directory. For example,
    http://example.com/miniqdb -- don't put a slash at the end."""))
conf.registerChannelValue(Miniqdb, 'maxLines', registry.PositiveInteger(3,
    """The maximum number of lines that will be printed to a channel. If a
    quote is longer than this, a link and the number of lines will be printed
    to the channel. Set to 0 to disable quote printing."""))
conf.registerGroup(Miniqdb, 'auth')
conf.registerChannelValue(Miniqdb.auth, 'username', registry.String("", """The
    username for HTTP authentication."""))
conf.registerChannelValue(Miniqdb.auth, 'password', registry.String("", """The
    password for HTTP authentication."""))


# vim:set shiftwidth=4 tabstop=4 expandtab textwidth=79:
