<?php

namespace XVR\Book_Review;

use XVR\Book_Review\Custom_Post\Book;
use XVR\Book_Review\Meta_Box\BookInfo;

class Book_Handler {

    /**
     * Book initialization
     */
    public function __construct() {
        new Book;
        new BookInfo;
    }
}