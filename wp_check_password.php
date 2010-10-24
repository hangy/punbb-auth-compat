<?php
/*  Copyright 2010 hangy
 Copyright 2003-2010 WordPress contributors

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License, version 2, as
 published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
if ( !function_exists('wp_check_password') ) :
/**
 * Checks the plaintext password against the encrypted Password.
 *
 * Maintains compatibility between PunBB and the new cookie authentication
 * protocol using PHPass library. The $hash parameter is the encrypted password
 * and the function compares the plain text password when encypted similarly
 * against the already encrypted password to see if they match.
 *
 * For integration with other applications, this function can be overwritten to
 * instead use the other package password checking algorithm.
 *
 * @since 2.5
 * @global object $wp_hasher PHPass object used for checking the password
 *	against the $hash + $password
 * @uses PasswordHash::CheckPassword
 *
 * @param string $password Plaintext user's password
 * @param string $hash Hash of the user's password to check against.
 * @return bool False, if the $password does not match the hashed password
 */
function wp_check_password($password, $hash, $user_id = '') {
	global $wp_hasher;

	$hash_length = strlen($hash);

	// If the hash is still md5 ...
	if ( 32 == $hash_length ) {
		$check = ( $hash == md5($password) );
		if ( $check && $user_id ) {
			// Rehash using new hash.
			wp_set_password($password, $user_id);
			$hash = wp_hash_password($password);

			// Delete the now irrelevant previous PunBB salt, if it exists.
			delete_punbb_salt($user_id);
		}

		return apply_filters('check_password', $check, $password, $hash, $user_id);
	}

	// If the hash has the length of SHA1, we assume it is PunBB's salted SHA1 version.
	if ( 40 == $hash_length && $user_id ) {
		$salt = get_punbb_salt($user_id);
		$check = ( $hash == punbb_hash($password, $punbb_salt) );
		if ( $check ) {
			// Rehash using new hash.
			wp_set_password($password, $user_id);
			$hash = wp_hash_password($password);

			// Delete the now irrelevant previous PunBB salt.
			delete_punbb_salt($user_id);
		}

		return apply_filters('check_password', $check, $password, $hash, $user_id);
	}

	// If the previous tests did not turn out to be right, presume the new style phpass portable hash.
	if ( empty($wp_hasher) ) {
		require_once( ABSPATH . 'wp-includes/class-phpass.php');
		// By default, use the portable hash from phpass
		$wp_hasher = new PasswordHash(8, TRUE);
	}

	$check = $wp_hasher->CheckPassword($password, $hash);

	return apply_filters('check_password', $check, $password, $hash, $user_id);
}
endif;