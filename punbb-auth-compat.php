<?php
/*
 Plugin Name: PunBB to WordPress Adapter
 Plugin URI: http://github.com/hangy/punbb_to_wordpress
 Description: Tries to migrate PunBB passwords to WordPress and Simple:Press.
 Version: 0.1
 Author: hangy
 Author URI: http://hangy.de/
 License: WTFPL
 */
/*  Copyright 2010  hangy
 This program is free software. It comes without any warranty, to
 the extent permitted by applicable law. You can redistribute it
 and/or modify it under the terms of the Do What The Fuck You Want
 To Public License, Version 2, as published by Sam Hocevar. See
 http://sam.zoy.org/wtfpl/COPYING for more details.
 */

require 'punbb_salt.php';
require 'punbb_hash.php';
require 'wp_check_password.php';