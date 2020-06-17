<?php

namespace XVR\Book_Review\Custom_Post;

class Book {

    protected static $category = 'Book Reviews';
    protected static $category_slug = 'book-reviews';

    public function __construct() {
        add_action( 'init', [ $this, 'register_book_post_type' ] );
        add_action( 'save_post_books', [ $this, 'set_default_category' ], 10, 2 );
    }

    public static function get_category() {
        return self::$category;
    }

    public static function get_category_slug() {
        return self::$category_slug;
    }

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

        register_post_type( 'books', $args );
    }

    public function set_default_category($post_id, $post) {
        $taxonomy = 'category';
        $term = get_term_by('slug', self::$category_slug, $taxonomy);
        wp_set_object_terms(get_the_ID(), $term->term_id, $taxonomy);
    }
}