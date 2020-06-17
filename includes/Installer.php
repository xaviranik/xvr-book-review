<?php

namespace XVR\Book_Review;

use XVR\Book_Review\Custom_Post\Book;

/**
 * Installer Class
 */
class Installer
{
    /**
     * Plugin runner
     *
     * @return void
     */
    public function run()
    {
        $this->add_version();
        $this->add_book_category();
    }

    /**
     * Adds plugin version
     */
    public function add_version()
    {
        $installed = get_option('xvr_book_review_installed');

        if (!$installed) {
            update_option('xvr_book_review_installed', time());
        }

        update_option('xvr_book_review_version', XVR_BOOK_REVIEW_VERSION);
    }

    public function add_book_category()
    {
        wp_insert_term(
            Book::get_category(),
            'category',
            [
                'slug' => Book::get_category_slug()
            ]
        );
    }
}