<?php

/**
 * Plugin Name:       XVR Book Review
 * Plugin URI:        https://zabiranik.me
 * Description:       Basic plugin for Wordpress
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Zabir Anik
 * Author URI:        https://zabiranik.me
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       xvr-book-review
 */

if (!defined('ABSPATH')) exit;

require_once __DIR__ . '/vendor/autoload.php';

use XVR\Book_Review\Custom_Post\Book;
use XVR\Book_Review\Installer;



/**
 * Main plugin class
 */
final class XVR_Book_Review
{

    /**
     * Plugin Version
     * @var string
     */
    const version = '1.0.0';

    /**
     * Class Constructor
     */
    private function __construct()
    {
        $this->define_constants();

        register_activation_hook(__FILE__, [$this, 'activate']);

        add_action('plugins_loaded', [$this, 'init_plugin']);
    }

    /**
     * Initializes a Singleton
     * @return \XVR_Book_Review
     */
    public static function init()
    {

        static $instance = false;

        if (!$instance) {
            $instance = new Self();
        }

        return $instance;
    }

    /**
     * Defines plugin constants
     * @return void
     */
    public function define_constants()
    {
        define('XVR_BOOK_REVIEW_VERSION', self::version);
    }

    /**
     * Plugin init
     * @return void
     */
    public function init_plugin()
    {
        new Book;
    }

    /**
     * Executes on plugin activation
     * @return void
     */
    public function activate()
    {
        $installer = new Installer;
        $installer->run();
    }
}

/**
 * Plugin Instance init
 * @return \XVR_Book_Review
 */
function xvr_book_review_init()
{
    return XVR_Book_Review::init();
}

// Initialize the plugin
xvr_book_review_init();