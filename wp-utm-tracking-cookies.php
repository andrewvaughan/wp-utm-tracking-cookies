<?php
/**
 * WordPress UTM Tracking Cookies Plugin
 *
 * This is the main file for the UTM Tracking Cookies Plugin.  It manages activation, deactivation, uninstallation,
 * and basic functionality of the plugin.
 *
 * @link      https://github.com/andrewvaughan/wp-utm-tracking-cookies
 * @since     1.0.0
 * @package   WP_UTM_Tracking_Cookies_Plugin
 * @author    Andrew Vaughan <hello@andrewvaughan.io>
 *
 * @wordpress-plugin
 *
 * Plugin Name: WP UTM Tracking Cookies
 * Plugin URI:  https://github.com/andrewvaughan/wp-utm-tracking-cookies
 * Description: Stores UTM tracking variables and referrer information into cookies for later use.
 * Version:     1.0.0
 * Author:      Andrew Vaughan
 * Author URI:  https://andrewvaughan.io
 * License:     GPL3
 * License URI: https://github.com/andrewvaughan/wp-utm-tracking-cookies/blob/master/wp-utm-tracking-cookies/LICENSE.txt
 *
 * wp-utm-tracking-cookies WordPress Plugin for Tracking Cookies
 * Copyright (C) 2018 Andrew Vaughan
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */


// If this file is called directly, abort.
if (!defined('WPINC')) {

    die;

}


class WP_UTM_Tracking_Cookies_Plugin {

    /**
     * @var     string $version the version of the UTM Tracking Cookies Plugin
     * @since   1.0.0
     * @static
     */
    public static $version = '1.0.0';

    /**
     * @var     WP_UTM_Tracking_Cookies_Plugin $instance the instance of this class, used for the Singleton pattern
     * @since   1.0.0
     * @static
     */
    protected static $instance;


    /**
     * Constructs the WP_UTM_Tracking_Cookies_Plugin
     *
     * @since   1.0.0
     */
    private function __construct() {

        //add_action('init', [$this, 'captureData']);

        // Load cookies with JavaScript to get around cache problems
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);

    }


    /**
	 * Implements a singleton pattern for the plugin.
	 *
	 * @return WP_Comment_Notes
	 */
    public static function getInstance() {

        if (!self::$instance) {

            self::$instance = new self;

        }

        return self::$instance;

    }


    /**
     * Captures targeted data regarding UTM variables and referral information and stores it as cookies for the
     * domain.
     *
     * @since   1.0.0
     */
    public function captureData() {

        /*
        $domain = (isset($_SERVER["HTTPS"]) ? 'https://' : 'http://') . $_SERVER["SERVER_NAME"];

        foreach ($_REQUEST as $key => $value) {

            if (trim($value) === "") {
                break;
            }

            // Set any utm_* query parameters as cookies
            if (substr(strtolower($key), 0, 4) == "utm_") {
                $this->storeData($key, $value, true);
            }

        }

        // If not already set, store the landing-page information cookies
        $this->storeData('ref_landing', $domain . $_SERVER["REQUEST_URI"]);
        $this->storeData('ref_referrer', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'organic');

        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && $_SERVER["HTTP_X_FORWARDED_FOR"] != "") {
            $this->storeData('ref_ip_address', $_SERVER["HTTP_X_FORWARDED_FOR"], true);
        } else {
            $this->storeData('ref_ip_address', $_SERVER['REMOTE_ADDR'], true);
        }
        */

    }


    /**
     * Adds a JavaScript backup to ensure cookies are stored, in case WordPress is cached.
     *
     * @since   1.0.0
     */
    public function enqueueScripts() {

        wp_enqueue_script(
            'js.cookie',
            plugins_url('/js/js.cookie.js' , __FILE__)
        );

        wp_enqueue_script(
            'wp-utm-tracking-cookies',
            plugins_url('/js/wp-utm-tracking-cookies.js' , __FILE__),
            [
                'js.cookie'
            ],
            $this->version
        );

    }


    /**
     * Stores the specified data into a cookie, to be available immediately by the script and on future page loads.
     *
     * @param   string $name     the name to store as
     * @param   string $value    the value of the cookie to store
     * @param   string $override whether to override the value if already set (default: false)
     *
     * @since   1.0.0
     */
    protected function storeData($name, $value, $override = false) {

        /*
        $value = str_replace('+', ' ', $value);

        if (!isset($_COOKIE[$name]) || $override) {

            // Store the cookie value
            setcookie($name, $value, 0, "/", "." . $_SERVER["SERVER_NAME"]);
            $_COOKIE[$name] = $value;

        }
        */

    }

}


// Load the instance of this plugin
$WP_UTM_Tracking_Cookies = WP_UTM_Tracking_Cookies_Plugin::getInstance();
