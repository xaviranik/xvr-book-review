<?php

namespace XVR\Book_Review;

use XVR\Book_Review\Custom_Post\Book;
use XVR\Book_Review\Meta_Box\BookInfo;

class Admin_Handler {

    /**
     * Admin initialization
     */
    public function __construct() {
        new Book;
        new BookInfo;
    }
}