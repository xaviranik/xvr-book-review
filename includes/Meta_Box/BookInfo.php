<?php

namespace XVR\Book_Review\Meta_Box;

use XVR\Book_Review\Custom_Post\Book;

class BookInfo
{
    /**
     * post meta key
     *
     * @var string
     */
    protected $keys = [
        'author' => 'book_author',
        'price' => 'book_price',
        'description' => 'book_description',
        'info' => 'book_info',
    ];

    /**
     * Post type
     *
     * @var string
     */
    protected $post_type;

    /**
     * Constructor
     */
    public function __construct() {
        $this->post_type = Book::get_post_type();
        $this->register_excerpt_meta_box();
    }
    
    /**
     * Registers meta box
     *
     * @return void
     */
    public function register_excerpt_meta_box() {
        add_action( 'add_meta_boxes', [ $this, 'add_book_info_meta_box'] );
        add_action( "save_post_{$this->post_type}", [ $this, 'save_metabox_data' ], 10, 2 );
    }

    /**
     * Adds meta box
     *
     * @return void
     */
    public function add_book_info_meta_box() {
        add_meta_box( 'xvr_book_info_fields', __( 'Book Information', 'xvr-book-info' ), [ $this, 'render' ], $this->post_type , 'side', 'high');
    }

    /**
     * Saves meta box to DB
     *
     * @param integer $post_id
     * @param object $post
     * @return void
     */
    public function save_metabox_data( $post_id, $post ) {
        if ( ! isset( $_POST['xvr_br_nonce'] ) || ! wp_verify_nonce( $_POST[ 'xvr_br_nonce' ], basename( __FILE__ ) ) ) {
            return;
        }

        $data[ $this->keys['author'] ]      = isset( $_POST['xvr-book-author'] ) ? sanitize_text_field( $_POST['xvr-book-author'] ): '';
        $data[ $this->keys['price'] ]       = isset( $_POST['xvr-book-price'] ) ? sanitize_text_field( $_POST['xvr-book-price'] )  : '';
        $data[ $this->keys['description'] ] = isset( $_POST['xvr-book-description'] ) ? sanitize_text_field( $_POST['xvr-book-description'] ) : '';

        update_post_meta( $post_id, $this->keys['info'], $data);
    }

    /**
     * Renders the meta box
     *
     * @param object $post
     * @return void
     */
    public function render( $post ) {
        wp_nonce_field( basename( __FILE__ ), 'xvr_br_nonce' );
        $data        = get_post_meta( $post->ID, $this->keys['info'], true );
        $author      = '';
        $price       = '';
        $description = '';
        
        if( ! empty($data) ) {
            $author      = $data[ $this->keys['author'] ];
            $price       = $data[ $this->keys['price'] ];
            $description = $data[ $this->keys['description'] ];
        }
        ?>
        <input class="form-table" name="xvr-book-author" id="xvr-book-author" value="<?php echo $author ?>" placeholder="Book Author">
        <input class="form-table" name="xvr-book-price" id="xvr-book-price" value="<?php echo $price ?>" placeholder="Book Price">
        <input class="form-table" name="xvr-book-description" id="xvr-book-description" value="<?php echo $description ?>" placeholder="Book Description">
        <?php
    }
}