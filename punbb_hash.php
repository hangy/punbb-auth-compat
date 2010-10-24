<?php
/**
 * Loads common functions used throughout the site.
 *
 * @copyright (C) 2008-2009 PunBB, partially based on code (C) 2008-2009 FluxBB.org
 * @license http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 * @package PunBB
 */

/**
 * Generates a salted, SHA-1 hash of $str
 *
 * @see forum_hash($str, $salt) of PunBB's functions.php
 */
function punbb_hash($str, $salt)
{
	return sha1($salt.sha1($str));
}