<?php
/*  Copyright 2010  hangy
 This program is free software. It comes without any warranty, to
 the extent permitted by applicable law. You can redistribute it
 and/or modify it under the terms of the Do What The Fuck You Want
 To Public License, Version 2, as published by Sam Hocevar. See
 http://sam.zoy.org/wtfpl/COPYING for more details.
 */
/**
 * Tries to find the salt that PunBB originally used for hashing a
 * user's password.
 *
 * @since 0.1
 * @uses get_user_meta()
 *
 * @param integer $user_id The key uniquely identifying a user.
 * @return mixed NULL if no salt was found, otherwise a string containing the salt.
 */
function get_punbb_salt($user_id) {
	return get_user_meta($user_id, 'punbb_salt', true);
}

/**
 * Deletes a user's PunBB salt
 *
 * To be used when updating a user's password to PunBB's supposedly
 * more secure user data storage.
 *
 * @since 0.1
 * @uses delete_user_meta()
 *
 * @param integer $user_id The key uniquely identifying a user.
 * @return mixed NULL if no salt was found, otherwise a string containing the salt.
 */
function delete_punbb_salt($user_id) {
	return delete_user_meta($user_id, 'punbb_salt');
}