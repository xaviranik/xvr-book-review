<?php

namespace XVR\Book_Review\Custom_Post;

class Book {

    protected static $category = 'Book Reviews';
    protected static $category_slug = 'book-reviews';
    protected static $post_type = 'books';

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'init', [ $this, 'register_book_post_type' ] );
        add_action( 'init', [ $this, 'register_book_taxonomy' ] );
        add_action( 'save_post_books', [ $this, 'set_default_category' ], 10, 2 );
    }

    /**
     * Gets the category
     *
     * @return string
     */
    public static function get_category() {
        return self::$category;
    }

    /**
     * Gets the category slug
     *
     * @return string
     */
    public static function get_category_slug() {
        return self::$category_slug;
    }

    /**
     * Gets post type
     *
     * @return string
     */
    public static function get_post_type() {
        return self::$post_type;
    }

    /**
     * Registers post type
     *
     * @return void
     */
    public function register_book_post_type() {
        $labels = [
            'name'               => __('Books', 'xvr-book-review'),
            'add_new'            => __('Add New', 'xvr-book-review'),
            'add_new_item'       => __('Add New Book', 'xvr-book-review'),
            'edit_item'          => __('Edit Book', 'xvr-book-review'),
            'new_item'           => __('New Book', 'xvr-book-review'),
            'all_items'          => __('All Books', 'xvr-book-review'),
            'view_item'          => __('View Book', 'xvr-book-review'),
            'search_items'       => __('Search Books', 'xvr-book-review'),
            'not_found'          => __('No Books found', 'xvr-book-review'),
            'not_found_in_trash' => __('No Books found in the Trash', 'xvr-book-review'),
        ];

        $args = [
            'labels'        => $labels,
            'menu_position' => 5,
            'public'        => true,
            'taxonomies'  => array('category'),
            'supports'      => ['title', 'editor', 'thumbnail', 'excerpt', 'comments'],
        ];

        register_post_type( self::$post_type, $args );
    }

    public function register_book_taxonomy() {
        $labels = [
            'name'              => _x('Genres', 'taxonomy general name'),
            'singular_name'     => _x('Genre', 'taxonomy singular name'),
            'search_items'      => __('Search Genres'),
            'all_items'         => __('All Genres'),
            'parent_item'       => __('Parent Genre'),
            'parent_item_colon' => __('Parent Genre:'),
            'edit_item'         => __('Edit Genre'),
            'update_item'       => __('Update Genre'),
            'add_new_item'      => __('Add New Genre'),
            'new_item_name'     => __('New Genre Name'),
            'menu_name'         => __('Genre'),
        ];
        $args = [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'genre'],
        ];
        register_taxonomy( 'Genre', [ $this->get_post_type() ], $args);
    }

    /**
     * Sets the default category for a post
     *
     * @param integer $post_id
     * @param object $post
     * @return void
     */
    public function set_default_category($post_id, $post) {
        $taxonomy = 'category';
        $term = get_term_by('slug', self::$category_slug, $taxonomy);
        wp_set_object_terms(get_the_ID(), $term->term_id, $taxonomy);
    }
}