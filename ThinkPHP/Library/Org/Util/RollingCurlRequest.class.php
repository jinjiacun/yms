<?php
   /*
   Authored by Josh Fraser (www.joshfraser.com)
   Released under Apache License 2.0
 
   Maintained by Alexander Makarov, http://rmcreative.ru/
 
   $Id$
   */
 
   /**
   * Class that represent a single curl request
   */
   namespace Org\Util;
   class RollingCurlRequest {
      public $url = false;
      public $method = 'GET';
      public $post_data = null;
      public $headers = null;
      public $options = null;
      public $info = null;
      public $callback;
      public $recursion = false;
 
      /**
      * @param string $url
      * @param string $method
      * @param  $post_data
      * @param  $headers
      * @param  $options
      * @return void
      */
      function __construct($url, $options = null, $info = null, $method = "GET", $post_data = null, $headers = null  ) {
         $this->url = $url;
         $this->method = $method;
         $this->post_data = $post_data;
         $this->headers = $headers;
         $this->options = $options;
         $this->info = $info;
      }
 
      /**
      * @return void
      */
      public function __destruct() {
         unset($this->url, $this->method, $this->post_data, $this->headers, $this->options);
      }
   }
 
   /**
   * RollingCurl custom exception
   */
   /*
   class RollingCurlException extends Exception {
   }
 */
 ?> 