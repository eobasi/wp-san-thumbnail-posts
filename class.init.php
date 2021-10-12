<?php

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

CLASS SAN_THUMBNAIL_POSTS
{
    const VAR_NAME = 'san_thumbnail_posts';

    /**
     * @var WP_Screen|null
     */
    protected $screen;

    public function __construct( )
    {
        $this->screen = get_current_screen();
    }

    public function init()
    {
        $post_types = ['post'];
        $post_type = (isset($_GET['post_type'])) ? sanitize_text_field($_GET['post_type']) : 'post';

        if( $this->screen && in_array($post_type, $post_types) )
        {
            add_filter( "views_{$this->screen->id}", [$this, 'addViewItem'] );
            add_filter( 'parse_query', [$this, 'parseQuery']);
        }
    }

    public function addViewItem( $views )
    {
        $url = esc_url( admin_url('edit.php') . '?' . build_query([
            self::VAR_NAME => true,
            'post_type' => 'post',
        ]));
        
        $label = __('No Thumbnail', 'san-thumbnail-posts');
        $class = $this->isActive() ? 'current' : '';

        $views['nothumbnail'] = "<a href='{$url}' class='{$class}'>{$label} <span class='count'>({$this->countPosts()})</span></a>";
    
        return $views;
    }

    public function parseQuery( $query )
    {
        if( $this->isActive( ) ) {
            $query->query_vars['meta_query'][] = array(
                'key' => '_thumbnail_id',
                'compare' => 'NOT EXISTS'
            );
        }
    }

    public function countPosts( )
    {
        $query = new WP_Query(
            array(
                'post_type'=>'post',
                'posts_per_page' => 1,
                'meta_query' => array(
                    array(
                        'key' => '_thumbnail_id',
                        'compare' => 'NOT EXISTS'
                    )
                )
            )
        );
    
        return (int) $query->found_posts;
    }

    public function isActive()
    {
        if (isset($_GET[self::VAR_NAME]) && ((bool) sanitize_text_field($_GET[self::VAR_NAME])) )
        {
            return true;
        }

        return false;
    }
}