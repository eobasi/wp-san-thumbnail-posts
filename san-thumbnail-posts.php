<?php
/* 
	Plugin Name: San-Thumbnail Posts
	Plugin URI: http://eobasi.com/san-thumbnail-posts
	Description: A simple Wordpress plugin to list posts without a featured image in the admin posts page.
	Author: Ebenezer Obasi
	Version: 1
	Author URI: http://eobasi.com
*/

/**
 * This software is intended for use with Wordpress Software http://www.wordpress.org/ and is a proprietary licensed product.
 * For more information see License.txt in the plugin folder.

 * ---
 * Copyright (c) 2020, Ebenezer Obasi
 * All rights reserved.
 * eobasilive@gmail.com.

 * Redistribution and use in source and binary forms, with or without modification, are not permitted provided.

 * This plugin should be bought from the developer. For details contact info@eobasi.com.

 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * Initialize San-Thumbnail Posts item
 */
add_action( 'current_screen', function() {
	if ( !is_admin() ) {
		return;
	}

	require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'class.init.php';

	$_handler = new SAN_THUMBNAIL_POSTS();
	$_handler->init();
} );