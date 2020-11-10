<?php
/**
 * Halografix - MVC Framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2020 Halografix
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
defined('SYSPATH') OR exit('No direct script access allowed');

// Load the Google API PHP Client Library.
require_once ASSETPATH . 'vendor/google/autoload.php';


if ( ! function_exists('initialize_analytics')) {
    /**
     * Initialize Analytics
     * Creates and returns the Analytics Reporting service object
     *
     * @param   string $file_path
     * @return	object
     */

    function initialize_analytics($file_path) {

        // Create and configure a new client object.
        $client = new Google_Client();
        $client->setApplicationName("Analytics Reporting");
        $client->setAuthConfig($file_path);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $analytics = new Google_Service_Analytics($client);

        return $analytics;
    }
}

// --------------------------------------------------------------------

if ( ! function_exists('get_profile_id')) {
    /**
     * Get first profile id
     * Get the user's first view (profile) ID
     *
     * @param   object $analytics
     * @return	string
     */

    function get_profile_id($analytics) {

        // Get the list of accounts for the authorized user.
        $accounts = $analytics->management_accounts->listManagementAccounts();

        if (count($accounts->getItems()) > 0) {
            $items = $accounts->getItems();
            $firstAccountId = $items[0]->getId();

            // Get the list of properties for the authorized user.
            $properties = $analytics->management_webproperties->listManagementWebproperties($firstAccountId);

            if (count($properties->getItems()) > 0) {
                $items = $properties->getItems();
                $firstPropertyId = $items[0]->getId();

                // Get the list of views (profiles) for the authorized user.
                $profiles = $analytics->management_profiles->listManagementProfiles($firstAccountId, $firstPropertyId);

                if (count($profiles->getItems()) > 0) {
                    $items = $profiles->getItems();

                    // Return the first view (profile) ID.
                    return $items[0]->getId();

                }
                else {
                    throw new Exception('No views (profiles) found for this user.');
                }
            }
            else {
                throw new Exception('No properties found for this user.');
            }
        }
         else {
             throw new Exception('No accounts found for this user.');
        }
    }
}