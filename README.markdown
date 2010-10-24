punbb-auth-compat
=================

This WordPress plugin provides compatibility with PunBB hashes from PunBB 1.2.x
and 1.3.x.

How does it work?
-----------------

This plugin overrides the `wp_check_password` method and tries to match the
password hash in this order:

1. Simple MD5
2. PunBB salted SHA1
3. WordPress hash

If the given password matches one of the former hashes, the user is
authenticated and the user's password hash is updated using
the `wp_hash_password` function (which is not overridden by
this plugin).

Installation
------------

This plugin does not need any special configuration. However,
it assumes that you converted the PunBB userbase to the WordPress
database beforehand and copied the `salt` column from the PunBB
`user` table to the `punbb_salt` `usermeta` column in WordPress.