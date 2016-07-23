<?php if (!defined('TFUSE')) exit('Direct access forbidden.');

/**
 * Util functions
 */
{
    function tf_bigintval($value) {
        $value = trim($value);
        if (ctype_digit($value)) {
            return $value;
        }
        $value = preg_replace("/[^0-9](.*)$/", '', $value);
        if (ctype_digit($value)) {
            return $value;
        }
        return 0;
    }

    function tfuse_since($date)
    {
        $timestamp = strtotime($date);
        $seconds = time() - $timestamp;

        $units = array(
            'second' => 1,
            'minute' => 60,
            'hour' 	 => 3600,
            'day'	 => 86400,
            'month'  => 2629743,
            'year'   => 31556926
        );

        foreach($units as $k => $v)
        {
            if($seconds >= $v)
            {
                $results = floor($seconds/$v);
                if($k == 'day' | $k == 'month' | $k == 'year')
                    $timeago = date('D, d M, Y h:ia', $timestamp);
                else
                    $timeago = ($results >= 2) ? 'about '.$results.' '.$k.'s ago' : 'about '.$results.' '.$k.' ago';
            }
        }

        return ( isset($timeago) ? $timeago : NULL);
    }

    function tfuse_get_tweets($username, $count=20){

        $tweets_cache_path = TEMPLATEPATH.'/cache/twitter_json_'.$username.'_rpp_'.$count.'.cache';

        if(file_exists($tweets_cache_path))
        {
            $tweets_cache_timer = intval((time()-filemtime($tweets_cache_path))/60);
        }
        else
        {
            $tweets_cache_timer = 0;
        }

        if ( (!file_exists($tweets_cache_path) OR $tweets_cache_timer > 15) && function_exists('curl_init') )
        {
            require_once dirname( __FILE__ ) . '/libs/twitter/tmhOAuth.php';
            require_once dirname( __FILE__ ) . '/libs/twitter/tmhUtilities.php';

            $tmhOAuth = new tmhOAuth(array(
                'consumer_key'    => tfuse_options('twitter_consumer_key', ''),
                'consumer_secret' => tfuse_options('twitter_consumer_secret', ''),
                'user_token'      => tfuse_options('twitter_user_token', ''),
                'user_secret'     => tfuse_options('twitter_user_secret', '')
            ));

            $code = $tmhOAuth->request('GET', $tmhOAuth->url('1.1/statuses/user_timeline'), array('screen_name' => $username));
            $response = $tmhOAuth->response;

            $JsonTweets = json_decode($response['response']);

            if(is_array($JsonTweets))
            {
                $JsonTweets = array_slice($JsonTweets, 0, $count);
                foreach ($JsonTweets as $JsonKey=>$JsonVal)
                {
                    // Some reformatting
                    $pattern = array(
                        '/[^(:\/\/)](www\.[^ \n\r]+)/',
                        '/(https?:\/\/[^ \n\r]+)/',
                        '/@(\w+)/',
                        '/^'.$username.':\s*/i'
                    );
                    $replace = array(
                        '<a href="http://$1" rel="nofollow"  target="_blank">$1</a>',
                        '<a href="$1" rel="nofollow" target="_blank">$1</a>',
                        '<a href="http://twitter.com/$1" rel="nofollow"  target="_blank">@$1</a>'.
                            ''
                    );

                    $JsonTweets[$JsonKey]->text       = preg_replace($pattern, $replace, $JsonTweets[$JsonKey]->text);
                    $JsonTweets[$JsonKey]->created_at = tfuse_since($JsonTweets[$JsonKey]->created_at);
                }
            }
            else
            {
                return array();
            }

            // Some error? Return an empty array
            // You may want to extend this to know the exact error
            // echo curl_error($curl_handle);
            // or know the http status
            // echo curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);

            if(file_exists($tweets_cache_path))
            {
                unlink($tweets_cache_path);
            }

            $myFile = $tweets_cache_path;
            $fh = fopen($myFile, 'w') or die("can't open file");
            $stringData = json_encode($JsonTweets);
            fwrite($fh, $stringData);
            fclose($fh);
        }
        else
        {
            error_reporting(0);
            $file = file_get_contents($tweets_cache_path, true);


            if(!empty($file))
            {
                $JsonTweets = json_decode($file);

                if(!is_array($JsonTweets))
                {
                    $JsonTweets = array();
                }
            }
        }

        return $JsonTweets;
    }

    /**
     * Remove TF_THEME_PREFIX.'_' from option name
     **
     * @param string $option_id TF_THEME_PREFIX.'_some_id'
     * @return string           'some_id'
     */
    function tf_option_id_without_prefix($option_id) {
        static $preg_safe_theme_prefix = null;
        if ($preg_safe_theme_prefix === null) {
            $preg_safe_theme_prefix = preg_quote(TF_THEME_PREFIX, '/');
        }

        return preg_replace('/^'.$preg_safe_theme_prefix.'_/i', '', $option_id);
    }

    /**
     * @return string Current url
     */
    function tf_current_page_url() {
        static $cache = null;
        if ($cache !== null)
            return $cache;

        $pageURL = 'http';
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
            $pageURL .= 's';
        $pageURL .= '://';
        if ($_SERVER['SERVER_PORT'] != '80')
            $pageURL .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
        else
            $pageURL .= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

        $cache = $pageURL;
        return $cache;
    }


    function is_tf_front_page() {
        global $is_tf_front_page;
        return (bool)$is_tf_front_page;
    }

    function tf_cdata_decode($value) {
        return preg_replace('/<!\[CDATA\[\s*|\s*\]\]>/uis', '', $value);
    }
    function tf_is_cdata($value){
        return preg_match('/^<!\[CDATA\[/uis', trim($value));
    }

    function tf_mb_unserialize($serial_str) {
        $result = unserialize( $serial_str );

        if($result === false){ // if failed, try this
            $serial_str = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen(stripcslashes('$2')).':\"'.stripcslashes('$2').'\";'", $serial_str );
            $serial_str = str_replace("\r", "", $serial_str);
            //$serial_str= str_replace("\n", "", $serial_str);

            $result = unserialize($serial_str);
        }

        return $result;
    }

    /**
     * Find recursively keys value in array
     * $keys can be explode('.', 'a.b') or 'a.b'
     *
     * Initial array(a=>array(b=>foo))
     * $keys=[a,b] -> return array[a][b] -> value
     * $keys=[a.c] -> return array[a][ UNDEFINED ] -> NULL
     *
     * TEST:
        $temp = array('a' => array('b'=>'val1') );
        var_dump( array(
        tf_akg('a', $temp),
        tf_akg('a.b', $temp),
        tf_akg('a.b.c', $temp),
        tf_akg('a.c', $temp),
        ));
     */
    function tf_akg($keys, &$array, $defaultValue = NULL) {
        if (is_string($keys) || is_int($keys))
            $keys = explode('.', (string)$keys );

        $key = array_shift($keys);
        if ($key === NULL) return $defaultValue;

        if (!isset($array[$key])) return $defaultValue;

        if (isset($keys[0])) { // not used count() for performance reasons
            return tf_akg($keys, $array[$key], $defaultValue);
        } else {
            return $array[$key];
        }
    }

    /**
     * Set (or create if not exists) value for specified key in some keys level
     *
     * TEST:
        $test = array();
        tf_aks('a.b', 2, $test);
        tf_aks('a.b.c', 3, $test);
        tf_aks('a.c', array('test'), $test);
        tf_print($test);
        tf_print( tf_akg('a.b', $test) );
     */
    function tf_aks($keys, $value, &$array) {
        if (is_string($keys) || is_int($keys))
            $keys = explode('.', (string)$keys );

        $key = array_shift($keys);
        if ($key === NULL) return;

        if (!isset($array[$key])) $array[$key] = array();

        if (isset($keys[0])) { // not used count() for performance reasons
            if (!is_array($array[$key])) $array[$key] = array();

            tf_aks($keys, $value, $array[$key]);
        } else {
            $array[$key] = $value;
            return;
        }
    }

    /**
     * Generate random unique md5
     */
    function tf_md5rand() {
        return md5( time() .'-'. uniqid(rand(), true) .'-'. mt_rand(1, 1000) );
    }

    /**
     * Strip slashes from values, and from keys if magic_quotes_gpc = On
     */
    function tf_stripslashes_deep_keys($value) {
        static $magic_quotes = null;
        if ($magic_quotes === null) {
            $magic_quotes = get_magic_quotes_gpc();
        }

        if ( is_array($value) ) {
            if ($magic_quotes) {
                $new_value = array();
                foreach ($value as $key=>$value) {
                    $new_value[ is_string($key) ? stripslashes($key) : $key ] = tf_stripslashes_deep_keys($value);
                }
                $value = $new_value;
                unset($new_value);
            } else {
                $value = array_map('tf_stripslashes_deep_keys', $value);
            }
        } elseif ( is_object($value) ) {
            $vars = get_object_vars( $value );
            foreach ($vars as $key=>$data) {
                $value->{$key} = tf_stripslashes_deep_keys( $data );
            }
        } elseif ( is_string( $value ) ) {
            $value = stripslashes($value);
        }

        return $value;
    }

    /**
     * Add slashes to values, and to keys if magic_quotes_gpc = On
     */
    function tf_addslashes_deep_keys($value) {
        static $magic_quotes = null;
        if ($magic_quotes === null) {
            $magic_quotes = get_magic_quotes_gpc();
        }

        if ( is_array($value) ) {
            if ($magic_quotes) {
                $new_value = array();
                foreach ($value as $key=>$value) {
                    $new_value[ is_string($key) ? addslashes($key) : $key ] = tf_addslashes_deep_keys($value);
                }
                $value = $new_value;
                unset($new_value);
            } else {
                $value = array_map('tf_addslashes_deep_keys', $value);
            }
        } elseif ( is_object($value) ) {
            $vars = get_object_vars( $value );
            foreach ($vars as $key=>$data) {
                $value->{$key} = tf_addslashes_deep_keys( $data );
            }
        } elseif ( is_string( $value ) ) {
            $value = addslashes($value);
        }

        return $value;
    }

    /**
     * JSON encodes the array, echoes it and dies.
     * Mainly used in AJAX returns
     **
     * @param array $array
     */
    function tfjecho($array) {
        die(json_encode($array));
    }

    function tfuse_pk($data) {
        return urlencode(serialize($data));
    }

    function tfuse_unpk($data) {
        return tfuse_mb_unserialize(urldecode($data));
    }

    function tfuse_mb_unserialize($serial_str) {
        static $adds_slashes = -1;
        if ($adds_slashes === -1) // Check if preg replace adds slashes
            $adds_slashes = (false !== strpos( preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", 's:1:""";'), '\"' ));

        $result = @unserialize( preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str) );
        return ( $adds_slashes ? stripslashes_deep( $result ) : $result );
    }

    function thumb_link($url) {
        if (is_multisite()) {
            global $blog_id;
            if (isset($blog_id) && $blog_id > 0) {
                $imageParts = explode('/files/', $url);
                if (isset($imageParts[1]))
                    $url = network_site_url() . '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
            }
        }

        return $url;
    }

    function tf_can_ajax() {
        if (!current_user_can('publish_pages'))
            tfjecho(array(
                'status'  => -1,
                'message' => 'You do not have the required privileges for this action.'
            ));
    }

    /**
     * Check if current user has one capability from given list
     **
     * It returns first capability from list if user has no capabilities from list and default value is null (used inside current_user_can(), search for examples)
     * It returns default value if has no capabilities (with default value false, used to check if user has one of capabilities)
     **
     * @param array $capabilities list of capabilities to check
     * @param mixed $defaultValue
     * @return string|bool|mixed
     */
    function tf_current_user_can($capabilities, $defaultValue = NULL)
    {
        if (is_user_logged_in()) {
            foreach ($capabilities as $capability) {
                if (current_user_can($capability))
                    return $capability;
            }
        }

        return ($defaultValue !== NULL ? $defaultValue : array_shift($capabilities));
    }
    
    /**
     * Extract form options array for optigen/interface, only id=>value
     */
    function tf_only_options(&$options, $without_types = array(), $only_types = array(), &$__recursionData = NULL) {
        global $TFUSE;
        if (gettype(@$TFUSE->optigen) != 'object') die( user_error('$TFUSE is not loaded', E_USER_ERROR) );
    
        if ($__recursionData === NULL) {
            $__recursionData['without_types']   = (array)$without_types;
            $__recursionData['only_types']      = (array)$only_types;
            $__recursionData['check_without']   = count($without_types);
            $__recursionData['check_only']      = count($only_types);
        }
    
        $collectedOptions = array();
    
        if (is_array($options) && count($options)) {
            foreach ($options as $key=>$option) {
                if (!is_array($option))
                    continue;
    
                // Check if option has correct structure
                if (isset($option['type'])
                    && substr($option['type'], 0, 1) != '_'
                    && method_exists($TFUSE->optigen, $option['type'])
                    && isset($option['id'])
                ){
                    if ($__recursionData['check_only'])
                        if (!in_array($option['type'], $__recursionData['only_types']))
                            continue;
                    if ($__recursionData['check_without'])
                        if (in_array($option['type'], $__recursionData['without_types']))
                            continue;
    
                    $collectedOptions[$option['id']] = $option;
                } else {
                    $collectedOptions = array_merge(
                        $collectedOptions,
                        tf_only_options( $option, array(), array(), $__recursionData)
                    );
                }
            }
        }
    
        return $collectedOptions;
    }
    
    if (!function_exists('tfuse_qtranslate')):
        // qTranslate for custom fields
        function tfuse_qtranslate($text) {
            $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

            if (function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage'))
                $text = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($text);
    
            return $text;
        }
    endif;

    /**
     * print_r alternatives
     */
    {
        // original source: https://code.google.com/p/prado3/source/browse/trunk/framework/Util/TVarDumper.php

        /**
         * TVarDumper class.
         *
         * TVarDumper is intended to replace the buggy PHP function var_dump and print_r.
         * It can correctly identify the recursively referenced objects in a complex
         * object structure. It also has a recursive depth control to avoid indefinite
         * recursive display of some peculiar variables.
         *
         * TVarDumper can be used as follows,
         * <code>
         *   echo TVarDumper::dump($var);
         * </code>
         *
         * @author Qiang Xue <qiang.xue@gmail.com>
         * @version $Id$
         * @package System.Util
         * @since 3.0
         */
        class TF_Dumper
        {
            private static $_objects;
            private static $_output;
            private static $_depth;

            /**
             * Converts a variable into a string representation.
             * This method achieves the similar functionality as var_dump and print_r
             * but is more robust when handling complex objects such as PRADO controls.
             * @param mixed $var     Variable to be dumped
             * @param integer $depth Maximum depth that the dumper should go into the variable. Defaults to 10.
             * @return string the string representation of the variable
             */
            public static function dump($var,$depth=10)
            {
                self::resetInternals();

                self::$_depth=$depth;
                self::dumpInternal($var,0);

                $output = self::$_output;

                self::resetInternals();

                return $output;
            }

            private static function resetInternals()
            {
                self::$_output='';
                self::$_objects=array();
                self::$_depth=10;
            }

            private static function dumpInternal($var,$level)
            {
                switch(gettype($var)) {
                    case 'boolean':
                        self::$_output.=$var?'true':'false';
                        break;
                    case 'integer':
                        self::$_output.="$var";
                        break;
                    case 'double':
                        self::$_output.="$var";
                        break;
                    case 'string':
                        self::$_output.="'$var'";
                        break;
                    case 'resource':
                        self::$_output.='{resource}';
                        break;
                    case 'NULL':
                        self::$_output.="null";
                        break;
                    case 'unknown type':
                        self::$_output.='{unknown}';
                        break;
                    case 'array':
                        if(self::$_depth<=$level)
                            self::$_output.='array(...)';
                        else if(empty($var))
                            self::$_output.='array()';
                        else
                        {
                            $keys=array_keys($var);
                            $spaces=str_repeat(' ',$level*4);
                            self::$_output.="array\n".$spaces.'(';
                            foreach($keys as $key)
                            {
                                self::$_output.="\n".$spaces."    [$key] => ";
                                self::$_output.=self::dumpInternal($var[$key],$level+1);
                            }
                            self::$_output.="\n".$spaces.')';
                        }
                        break;
                    case 'object':
                        if(($id=array_search($var,self::$_objects,true))!==false)
                            self::$_output.=get_class($var).'(...)';
                        else if(self::$_depth<=$level)
                            self::$_output.=get_class($var).'(...)';
                        else
                        {
                            $id=array_push(self::$_objects,$var);
                            $className=get_class($var);
                            $members=(array)$var;
                            $keys=array_keys($members);
                            $spaces=str_repeat(' ',$level*4);
                            self::$_output.="$className\n".$spaces.'(';
                            foreach($keys as $key)
                            {
                                $keyDisplay=strtr(trim($key),array("\0"=>':'));
                                self::$_output.="\n".$spaces."    [$keyDisplay] => ";
                                self::$_output.=self::dumpInternal($members[$key],$level+1);
                            }
                            self::$_output.="\n".$spaces.')';
                        }
                        break;
                }
            }
        }

        /**
         * Nice displayed print_r alternative
         **
         * @param mixed $value Value to debug
         * @param bool  $die   Stop script after print
         */
        function tf_print($value, $die = false) {
            static $first_time = true;

            if ($first_time) {
                ob_start();
                ?><style type="text/css">
                div.tf_print_r {
                    max-height: 500px;
                    overflow-y: scroll;
                    background: #111;
                    margin: 10px 30px;
                    padding: 0;
                    border: 1px solid #F5F5F5;
                }

                div.tf_print_r pre {
                    color: #47EE47;
                    text-shadow: 1px 1px 0 #000;
                    font-family: Consolas, monospace;
                    font-size: 12px;
                    margin: 0;
                    padding: 5px;
                    display: block;
                    line-height: 16px;
                }
                </style><?php
                echo str_replace(array('  ', "\n"), '', ob_get_clean());
            }

            ?><div class="tf_print_r"><pre><?php print htmlspecialchars(tf_print_r($value, true), null, 'UTF-8'); ?></pre></div><?php

            $first_time = false;

            if ($die) die();
        }

        /**
         * print_r alternative
         **
         * the biggest plus of this - does not make recursions on references
         */
        function tf_print_r($var, $return = false, $depth = 10) {
            if ($return)
                return TF_Dumper::dump($var, $depth);
            else
                echo TF_Dumper::dump($var, $depth);
        }
    }
    
    function tfuse_parse_boolean($option) {
        return filter_var($option, FILTER_VALIDATE_BOOLEAN);
    }
    
    function tfuse_options($option_name, $default = NULL, $cat_id = NULL) {
        global $tfuse_options;
    
        // optiunile sunt slavate cu PREFIX in fata, dar extragem scrim fara PREFIX
        // pentru a obtine PREFIX_logo vom folosi tfuse_options('logo')
        $option_name = TF_THEME_PREFIX . '_' . $option_name;
    
        if ($cat_id !== NULL) {
            if (!isset($tfuse_options['taxonomy']))
                $tfuse_options['taxonomy'] = decode_tfuse_options(get_option(TF_THEME_PREFIX . '_tfuse_taxonomy_options'));

            if (@isset($tfuse_options['taxonomy'][$cat_id][$option_name]))
                $value = $tfuse_options['taxonomy'][$cat_id][$option_name];
        } else {
            if (!isset($tfuse_options['framework']))
                $tfuse_options['framework'] = decode_tfuse_options(get_option(TF_THEME_PREFIX . '_tfuse_framework_options'));
    
            if (isset($tfuse_options['framework'][$option_name]))
                $value = $tfuse_options['framework'][$option_name];
        }
    
        if (isset($value) && $value !== '')
            return $value;
        else
            return $default;
    }
    
    function tfuse_set_option($option_name, $value, $cat_id = NULL) {
        static $static_tfuse_options = array();
        global $tfuse_options;
    
        // optiunile sunt slavate cu PREFIX in fata, dar cind le setam scriem fara PREFIX
        // pentru a seta PREFIX_logo vom folosi tfuse_set_option('logo','http://themefuse.com/images/logo.png')
        $option_name = TF_THEME_PREFIX . '_' . $option_name;
    
        if ($cat_id !== NULL) {
            if (!isset($static_tfuse_options['taxonomy']))
                $static_tfuse_options['taxonomy'] = decode_tfuse_options(get_option(TF_THEME_PREFIX . '_tfuse_taxonomy_options'), false);

            @$static_tfuse_options['taxonomy'][$cat_id][$option_name] = $value;

            $tfuse_options['taxonomy'] = $static_tfuse_options['taxonomy'];

            return update_option(TF_THEME_PREFIX . '_tfuse_taxonomy_options', encode_tfuse_options($static_tfuse_options['taxonomy']));
        } else {
            if (!isset($static_tfuse_options['framework']))
                $static_tfuse_options['framework'] = decode_tfuse_options(get_option(TF_THEME_PREFIX . '_tfuse_framework_options'), false);

            $static_tfuse_options['framework'][$option_name] = $value;

            $tfuse_options['framework'] = $static_tfuse_options['framework'];
    
            return update_option(TF_THEME_PREFIX . '_tfuse_framework_options', encode_tfuse_options($static_tfuse_options['framework']) );
        }
    }
    
    /**
     * Get post tfuse options
     **
     * @param null|string $option_name Specific option name without TF_THEME_PREFIX.'_' , or null to get all post options
     * @param null $default returned if option value is empty
     * @param null $post_id Specify post_id or will be used global $post
     * @return mixed
     */
    function tfuse_page_options($option_name = null, $default = null, $post_id = null) {
        global $post, $tfuse_options;
        $max_cache_size = 100;
    
        if (!isset($post_id) && isset($post))
            $post_id = $post->ID;
        if (!isset($post_id))
            return;
    
        if (!isset($tfuse_options['post'][$post_id])) {
            if (!empty($tfuse_options['post']) && count($tfuse_options['post']) > $max_cache_size) // if cache limit exceeded, remove first element from cache
                array_shift($tfuse_options['post']);
    
            $tfuse_options['post'][$post_id] = decode_tfuse_options(get_post_meta($post_id, TF_THEME_PREFIX .'_tfuse_post_options', true));
        }
    
        if ($option_name === null) {
            return $tfuse_options['post'][$post_id];
        } else {
            // optiunile sunt slavate cu PREFIX in fata, dar extragem scrim fara PREFIX
            // pentru a obtine PREFIX_logo vom folosi tfuse_page_options('logo')
            $option_name = TF_THEME_PREFIX . '_' . $option_name;
    
            if (isset($tfuse_options['post'][$post_id][$option_name]))
                $value = $tfuse_options['post'][$post_id][$option_name];
        }
    
        if (isset($value) && $value !== '')
            return $value;
        else
            return $default;
    }
    
    /**
     * Set post tfuse option
     **
     * @param string $option_name Without prefix
     * @param mixed $value
     * @param null $post_id
     */
    function tfuse_set_page_option($option_name, $value, $post_id = null) {
        global $post, $tfuse_options;
        $max_cache_size = 100;
    
        if (!isset($post_id) && isset($post))
            $post_id = $post->ID;
        if (!isset($post_id))
            return;
    
        // optiunile sunt slavate cu PREFIX in fata, dar extragem scrim fara PREFIX
        // pentru a obtine PREFIX_logo vom folosi tfuse_page_options('logo')
        $option_name = TF_THEME_PREFIX .'_'. $option_name;
    
        if (!isset($tfuse_options['post'][$post_id])) {
            if (!empty($tfuse_options['post']) && count($tfuse_options['post']) > $max_cache_size) // if cache limit exceeded, remove first element from cache
                array_shift($tfuse_options['post']);
    
            $tfuse_options['post'][$post_id] = decode_tfuse_options( get_post_meta($post_id, TF_THEME_PREFIX .'_tfuse_post_options', true) );
        }
    
        $tfuse_options['post'][$post_id][$option_name] = $value;
    
        tf_update_post_meta($post_id, TF_THEME_PREFIX .'_tfuse_post_options', encode_tfuse_options($tfuse_options['post'][$post_id]));
    }
    
    /**
     * Prepare after unserialized from database
     */
    function decode_tfuse_options($tfuse_options, $translate = true) {
        if (!is_array($tfuse_options))
            return;
        array_walk_recursive($tfuse_options, $translate ? 'tfuse_apply_qtranslate' : 'tfuse_apply_decode');
        return $tfuse_options;
    }

    function tfuse_apply_decode(&$item) {
        if (strtolower($item) === 'true')
            $item = TRUE;
        elseif (strtolower($item) === 'false')
            $item = FALSE;
        else {
            $item = html_entity_decode($item, ENT_QUOTES, 'UTF-8');
        }
    }
    
    function tfuse_apply_qtranslate(&$item) {
        if (strtolower($item) === 'true')
            $item = TRUE;
        elseif (strtolower($item) === 'false')
            $item = FALSE;
        else {
            $item = tfuse_qtranslate($item);
        }
    }
    
    /**
     * Prepare for database insert
     */
    function encode_tfuse_options($tfuse_options) {
        if (!is_array($tfuse_options)) {
            tfuse_unapply_qtranslate($tfuse_options);
            return $tfuse_options;
        }
    
        array_walk_recursive($tfuse_options, 'tfuse_unapply_qtranslate');
        return $tfuse_options;
    }
    
    function tfuse_unapply_qtranslate(&$item) {
        if ($item === true)
            $item = 'true';
        elseif ($item === false)
            $item = 'false';
        else
            $item = htmlentities($item, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Obtine o parte specifica din string
     **
     * @param string $str Stringul di ncare vrem sa opbtinem prescurtata ...
     * @param string $more Stringul di ncare vrem sa opbtinem prescurtata ...
     * @param int $length Stringul di ncare vrem sa opbtinem prescurtata ...
     * @param int $minword Stringul di ncare vrem sa opbtinem prescurtata ...
     * @return string The image link if one is located.
     */
    function tfuse_substr($str, $length, $more = '...', $minword = 3) {
        $sub = '';
        $len = 0;
    
        foreach (explode(' ', $str) as $word) {
            $part = (($sub != '') ? ' ' : '') . $word;
            $sub .= $part;
            $len += strlen($part);
    
            if (strlen($word) > $minword && strlen($sub) >= $length)
                break;
        }
    
        return (($len < strlen($str)) ? $sub . ' ' . $more : $sub);
    }
    
    /**
     * Retrieve the uri of the highest priority file that exists.
     * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
     * inherit from a parent theme can just overload one file.
     **
     * @param string $file File to search for, in order.
     * @return string The file link if one is located.
     */
    function tfuse_get_file_uri($file) {
        $file = ltrim($file, '/');
        if (file_exists(STYLESHEETPATH . '/' . $file))
            return get_stylesheet_directory_uri() . '/' . $file;
        else if (file_exists(TEMPLATEPATH . '/' . $file))
            return get_template_directory_uri() . '/' . $file;
        else
            return $file;
    }
    
    function tfuse_logo($echo = FALSE) {
        $logo = tfuse_get_file_uri('/images/logo.png');
        return tfuse_options('logo', $logo);
    }
    
    function tfuse_logo_footer($echo = FALSE) {
        $logo_footer = tfuse_get_file_uri('/images/logo_footer.png');
        return tfuse_options('logo_footer', $logo_footer);
    }
    
    function tf_extimage($extension_name, $image_name) {
        $extension_name = strtolower($extension_name);
        return TFUSE_EXT_URI . '/' . $extension_name . '/static/images/' . $image_name;
    }
    
    function tf_config_extimage($extension_name, $image_name) {
        $extension_name = strtolower($extension_name);
        return tfuse_get_file_uri('theme_config/extensions/' . $extension_name . '/static/images/' . $image_name);
    }

    function tfuse_get_gallery_images($post_id,$input_id) {
        $_token = $input_id . '_' . $post_id;
        global $wpdb;
        $_args = array('post_type' => 'tfuse_gallery_group', 'post_name' => 'tf_gallery_' . $_token, 'post_status' => 'draft', 'comment_status' => 'closed', 'ping_status' => 'closed');
        $query = 'SELECT ID FROM ' . $wpdb->posts . ' WHERE post_parent = 0';

        foreach ($_args as $k => $v) {
            $query .= ' AND ' . $k . ' = "' . $v . '"';
        }
        $query .= ' LIMIT 1';

        $_posts = $wpdb->get_row($query);
        $images = array();
        if ($_posts) $images = get_children('post_type=attachment&post_parent='.$_posts->ID);
        foreach($images as $key=>$image) {
            $images[$key]->image_options = get_post_meta($image->ID,'image_options',true);
        }
        return $images;
    }

    /**
     * Call this function in different places in your script to see/debug latency between that calls
     */
    function tf_latency($message)
    {
        static $lastTime = 0;

        $currentTime = microtime(true);

        echo 'latency(';
        echo $lastTime == 0 ? '~' : $currentTime - $lastTime;
        echo ')(';
        echo htmlspecialchars($message, null, 'UTF-8');
        echo ')<br/>';

        $lastTime = $currentTime;
    }

    # tf_first_set()
    # tf_first_set($foo, 100)
    # tf_first_set($foo, $bar, $baz, 100)
    function tf_first_set()
    {
        $args = func_get_args();
        foreach ($args as $v) {
            if (isset($v)) {
                return $v;
            }
        }
        return null;
    }

    # tf_array_first_set($array, $default)
    # tf_array_first_set($array, $key1, $default)
    # tf_array_first_set($array, $key1, $key2, $default)
    # tf_array_first_set($array, $key1, $key2, $key3, $default)
    function tf_array_first_set()
    {
        $key_list = func_get_args();
        $array    = array_shift($key_list);
        $default  = array_pop($key_list);
        
        foreach ($key_list as $key)
            if (isset($array[$key]))
                return $array[$key];

        return $default;
    }

    # list($first, $last, $middle) = parse('Janet Cruz');
    # list($first, $last, $middle) = parse('Janet J. Cruz');
    function tf_parse_name($name)
    {
        # guessing
        $part = explode(' ', $name);
        switch (count($part)) {
            case 1:
                $ret = array();
                $ret['first'] = null;
                $ret['last'] = $part[0];
                $ret['middle'] = null;
                break;
            case 2:
                $ret = array();
                $ret['first'] = $part[0];
                $ret['last'] = $part[1];
                $ret['middle']= null;
                break;
            default:
                $ret = array();
                $ret['first'] = $part[0];
                $ret['last'] = $part[count($part)-1];
                $ret['middle'] = implode(' ', array_slice($part, 1, -1));
                break;
        }
        $ret[0] = $ret['first'];
        $ret[1] = $ret['last'];
        $ret[2] = $ret['middle'];
        return $ret;
    }

    # Strong cryptography in PHP
    # http://www.zimuel.it/en/strong-cryptography-in-php/
    # > Don't use rand() or mt_rand()
    function tf_secure_rand($length)
    {
        if (function_exists('openssl_random_pseudo_bytes')) {
            $rnd = openssl_random_pseudo_bytes($length, $strong);
            if ($strong) {
                return $rnd;
            }
        }

        $sha ='';
        $rnd ='';

        if (file_exists('/dev/urandom')) {
            $fp = fopen('/dev/urandom', 'rb');
            if ($fp) {
                if (function_exists('stream_set_read_buffer')) {
                    stream_set_read_buffer($fp, 0);
                }
                $sha = fread($fp, $length);
                fclose($fp);
            }
        }

        for ($i = 0; $i < $length; $i++) {
            $sha = hash('sha256', $sha.mt_rand());
            $char = mt_rand(0, 62);
            $rnd .= chr(hexdec($sha[$char].$sha[$char+1]));
        }

        return $rnd;
    }

    # Authorize.Net Server Integration Method (SIM)
    function tf_script_redirect($location)
    {
        echo '<script>location = ', json_encode($location), ';</script>';
    }

    # PayPal Payments Advanced
    function tf_iframe_redirect($location)
    {
        echo '<script>top.location = ', json_encode($location), ';</script>';
    }

    # tf_currency_list('code', 'name')
    function tf_currency_list($key, $value)
    {
        static $currency = null;
        if ($currency === null) {
            $currency = array(
                array('code' => 'USD', 'name' => __('US Dollars', 'tfuse'), 'symbol' => '$'),
                array('code' => 'EUR', 'name' => __('Euro', 'tfuse'), 'symbol' => '\u20ac'),
                array('code' => 'GBP', 'name' => __('British Pounds Sterling', 'tfuse'), 'symbol' => '\u00a3'),
                array('code' => 'CAD', 'name' => __('Canadian Dollars', 'tfuse'), 'symbol' => '$'),
                array('code' => 'CHF', 'name' => __('Swiss Francs', 'tfuse'), 'symbol' => 'Fr'),
                array('code' => 'JPY', 'name' => __('Japanese yen', 'tfuse'), 'symbol' => '\u00a5'),
                array('code' => 'AFA', 'name' => __('Afghan Afghani', 'tfuse'), 'symbol' => 'AFA'),
                array('code' => 'AWG', 'name' => __('Aruban Florin', 'tfuse'), 'symbol' => '\u0192'),
                array('code' => 'AUD', 'name' => __('Australian Dollars', 'tfuse'), 'symbol' => '$'),
                array('code' => 'ARS', 'name' => __('Argentine Pes', 'tfuse'), 'symbol' => '$'),
                array('code' => 'AZN', 'name' => __('Azerbaijanian Manat', 'tfuse'), 'symbol' => 'AZN'),
                array('code' => 'BSD', 'name' => __('Bahamian Dollar', 'tfuse'), 'symbol' => '$'),
                array('code' => 'BDT', 'name' => __('Bangladeshi Taka', 'tfuse'), 'symbol' => '\u09f3'),
                array('code' => 'BBD', 'name' => __('Barbados Dollar', 'tfuse'), 'symbol' => '$'),
                array('code' => 'BYR', 'name' => __('Belarussian Rouble', 'tfuse'), 'symbol' => 'Br'),
                array('code' => 'BOB', 'name' => __('Bolivian Boliviano', 'tfuse'), 'symbol' => 'Bs.'),
                array('code' => 'BRL', 'name' => __('Brazilian Real', 'tfuse'), 'symbol' => 'R$ '),
                array('code' => 'BGN', 'name' => __('Bulgarian Lev', 'tfuse'), 'symbol' => '\u043b\u0432'),
                array('code' => 'KHR', 'name' => __('Cambodia Riel', 'tfuse'), 'symbol' => '\u17db'),
                array('code' => 'KYD', 'name' => __('Cayman Islands Dollar', 'tfuse'), 'symbol' => '$'),
                array('code' => 'CLP', 'name' => __('Chilean Peso', 'tfuse'), 'symbol' => '$'),
                array('code' => 'CNY', 'name' => __('Chinese Renminbi Yuan', 'tfuse'), 'symbol' => '\u00a5'),
                array('code' => 'COP', 'name' => __('Colombian Peso', 'tfuse'), 'symbol' => '$'),
                array('code' => 'CRC', 'name' => __('Costa Rican Colon', 'tfuse'), 'symbol' => '\u20a1'),
                array('code' => 'HRK', 'name' => __('Croatia Kuna', 'tfuse'), 'symbol' => 'kn'),
                array('code' => 'CPY', 'name' => __('Cypriot Pounds', 'tfuse'), 'symbol' => 'CPY'),
                array('code' => 'CZK', 'name' => __('Czech Koruna', 'tfuse'), 'symbol' => 'K\u010d'),
                array('code' => 'DKK', 'name' => __('Danish Krone', 'tfuse'), 'symbol' => 'kr'),
                array('code' => 'DOP', 'name' => __('Dominican Republic Peso', 'tfuse'), 'symbol' => '$'),
                array('code' => 'XCD', 'name' => __('East Caribbean Dollar', 'tfuse'), 'symbol' => '$'),
                array('code' => 'EGP', 'name' => __('Egyptian Pound', 'tfuse'), 'symbol' => '\u062c.\u0645'),
                array('code' => 'ERN', 'name' => __('Eritrean Nakfa', 'tfuse'), 'symbol' => 'Nfk'),
                array('code' => 'EEK', 'name' => __('Estonia Kroon', 'tfuse'), 'symbol' => 'EEK'),
                array('code' => 'GEL', 'name' => __('Georgian Lari', 'tfuse'), 'symbol' => '\u10da'),
                array('code' => 'GHC', 'name' => __('Ghana Cedi', 'tfuse'), 'symbol' => 'GHC'),
                array('code' => 'GIP', 'name' => __('Gibraltar Pound', 'tfuse'), 'symbol' => '\u00a3'),
                array('code' => 'GTQ', 'name' => __('Guatemala Quetzal', 'tfuse'), 'symbol' => 'Q'),
                array('code' => 'HNL', 'name' => __('Honduras Lempira', 'tfuse'), 'symbol' => 'L'),
                array('code' => 'HKD', 'name' => __('Hong Kong Dollars', 'tfuse'), 'symbol' => '$'),
                array('code' => 'HUF', 'name' => __('Hungary Forint', 'tfuse'), 'symbol' => 'Ft'),
                array('code' => 'ISK', 'name' => __('Icelandic Krona', 'tfuse'), 'symbol' => 'kr'),
                array('code' => 'INR', 'name' => __('Indian Rupee', 'tfuse'), 'symbol' => '\u20b9'),
                array('code' => 'IDR', 'name' => __('Indonesia Rupiah', 'tfuse'), 'symbol' => 'Rp'),
                array('code' => 'ILS', 'name' => __('Israel Shekel', 'tfuse'), 'symbol' => '\u20aa'),
                array('code' => 'JMD', 'name' => __('Jamaican Dollar', 'tfuse'), 'symbol' => '$'),
                array('code' => 'KZT', 'name' => __('Kazakhstan Tenge', 'tfuse'), 'symbol' => '\u3012'),
                array('code' => 'KES', 'name' => __('Kenyan Shilling', 'tfuse'), 'symbol' => 'KSh'),
                array('code' => 'KWD', 'name' => __('Kuwaiti Dinar', 'tfuse'), 'symbol' => '\u062f.\u0643'),
                array('code' => 'LVL', 'name' => __('Latvia Lat', 'tfuse'), 'symbol' => 'Ls'),
                array('code' => 'LBP', 'name' => __('Lebanese Pound', 'tfuse'), 'symbol' => '\u0644.\u0644'),
                array('code' => 'LTL', 'name' => __('Lithuania Litas', 'tfuse'), 'symbol' => 'Lt'),
                array('code' => 'MOP', 'name' => __('Macau Pataca', 'tfuse'), 'symbol' => 'P'),
                array('code' => 'MKD', 'name' => __('Macedonian Denar', 'tfuse'), 'symbol' => '\u0434\u0435\u043d'),
                array('code' => 'MGA', 'name' => __('Malagascy Ariary', 'tfuse'), 'symbol' => 'Ar'),
                array('code' => 'MYR', 'name' => __('Malaysian Ringgit', 'tfuse'), 'symbol' => 'RM'),
                array('code' => 'MTL', 'name' => __('Maltese Lira', 'tfuse'), 'symbol' => 'MTL'),
                array('code' => 'BAM', 'name' => __('Marka', 'tfuse'), 'symbol' => '\u041a\u041c'),
                array('code' => 'MUR', 'name' => __('Mauritius Rupee', 'tfuse'), 'symbol' => '\u20a8'),
                array('code' => 'MXN', 'name' => __('Mexican Pesos', 'tfuse'), 'symbol' => '$'),
                array('code' => 'MDL', 'name' => __('Moldovan Leu', 'tfuse'), 'symbol' => 'L'),
                array('code' => 'MZM', 'name' => __('Mozambique Metical', 'tfuse'), 'symbol' => 'MZM'),
                array('code' => 'NPR', 'name' => __('Nepalese Rupee', 'tfuse'), 'symbol' => '\u20a8'),
                array('code' => 'ANG', 'name' => __('Netherlands Antilles Guilder', 'tfuse'), 'symbol' => '\u0192'),
                array('code' => 'TWD', 'name' => __('New Taiwanese Dollars', 'tfuse'), 'symbol' => '$'),
                array('code' => 'NZD', 'name' => __('New Zealand Dollars', 'tfuse'), 'symbol' => '$'),
                array('code' => 'NIO', 'name' => __('Nicaragua Cordoba', 'tfuse'), 'symbol' => 'C$'),
                array('code' => 'NGN', 'name' => __('Nigeria Naira', 'tfuse'), 'symbol' => '\u20a6'),
                array('code' => 'KPW', 'name' => __('North Korean Won', 'tfuse'), 'symbol' => '\u20a9'),
                array('code' => 'NOK', 'name' => __('Norwegian Krone', 'tfuse'), 'symbol' => 'kr'),
                array('code' => 'OMR', 'name' => __('Omani Riyal', 'tfuse'), 'symbol' => '\u0631.\u0639.'),
                array('code' => 'PKR', 'name' => __('Pakistani Rupee', 'tfuse'), 'symbol' => '\u20a8'),
                array('code' => 'PYG', 'name' => __('Paraguay Guarani', 'tfuse'), 'symbol' => '\u20b2'),
                array('code' => 'PEN', 'name' => __('Peru New Sol', 'tfuse'), 'symbol' => 'S/.'),
                array('code' => 'PHP', 'name' => __('Philippine Pesos', 'tfuse'), 'symbol' => '\u20b1'),
                array('code' => 'QAR', 'name' => __('Qatari Riyal', 'tfuse'), 'symbol' => '\u0631.\u0642'),
                array('code' => 'RON', 'name' => __('Romanian New Leu', 'tfuse'), 'symbol' => 'L'),
                array('code' => 'RUB', 'name' => __('Russian Federation Ruble', 'tfuse'), 'symbol' => '\u0440.'),
                array('code' => 'SAR', 'name' => __('Saudi Riyal', 'tfuse'), 'symbol' => '\u0631.\u0633'),
                array('code' => 'CSD', 'name' => __('Serbian Dinar', 'tfuse'), 'symbol' => 'CSD'),
                array('code' => 'SCR', 'name' => __('Seychelles Rupee', 'tfuse'), 'symbol' => '\u20a8'),
                array('code' => 'SGD', 'name' => __('Singapore Dollars', 'tfuse'), 'symbol' => '$'),
                array('code' => 'SKK', 'name' => __('Slovak Koruna', 'tfuse'), 'symbol' => 'Sk'),
                array('code' => 'SIT', 'name' => __('Slovenia Tolar', 'tfuse'), 'symbol' => 'SIT'),
                array('code' => 'ZAR', 'name' => __('South African Rand', 'tfuse'), 'symbol' => 'R'),
                array('code' => 'KRW', 'name' => __('South Korean Won', 'tfuse'), 'symbol' => '\u20a9'),
                array('code' => 'LKR', 'name' => __('Sri Lankan Rupee', 'tfuse'), 'symbol' => '\u20a8'),
                array('code' => 'SRD', 'name' => __('Surinam Dollar', 'tfuse'), 'symbol' => '$'),
                array('code' => 'SEK', 'name' => __('Swedish Krona', 'tfuse'), 'symbol' => 'kr'),
                array('code' => 'TZS', 'name' => __('Tanzanian Shilling', 'tfuse'), 'symbol' => 'Sh'),
                array('code' => 'THB', 'name' => __('Thai Baht', 'tfuse'), 'symbol' => '\u0e3f'),
                array('code' => 'TTD', 'name' => __('Trinidad and Tobago Dollar', 'tfuse'), 'symbol' => '$'),
                array('code' => 'TRY', 'name' => __('Turkish New Lira', 'tfuse'), 'symbol' => 'TL'),
                array('code' => 'AED', 'name' => __('UAE Dirham', 'tfuse'), 'symbol' => '\u062f.\u0625'),
                array('code' => 'UGX', 'name' => __('Ugandian Shilling', 'tfuse'), 'symbol' => 'USh'),
                array('code' => 'UAH', 'name' => __('Ukraine Hryvna', 'tfuse'), 'symbol' => '\u20b4'),
                array('code' => 'UYU', 'name' => __('Uruguayan Peso', 'tfuse'), 'symbol' => '$'),
                array('code' => 'UZS', 'name' => __('Uzbekistani Som', 'tfuse'), 'symbol' => 'UZS'),
                array('code' => 'VEB', 'name' => __('Venezuela Bolivar', 'tfuse'), 'symbol' => 'VEB'),
                array('code' => 'VND', 'name' => __('Vietnam Dong', 'tfuse'), 'symbol' => '\u20ab'),
                array('code' => 'AMK', 'name' => __('Zambian Kwacha', 'tfuse'), 'symbol' => 'AMK'),
                array('code' => 'ZWD', 'name' => __('Zimbabwe Dollar', 'tfuse'), 'symbol' => 'ZWD'),
                array('code' => 'AFN', 'name' => __('Namibian Dollar', 'tfuse'), 'symbol' => '\u060b'),
                array('code' => 'ALL', 'name' => __('Albanian Lek', 'tfuse'), 'symbol' => 'L'),
                array('code' => 'AMD', 'name' => __('Armenian dram', 'tfuse'), 'symbol' => '\u0564\u0580.'),
                array('code' => 'AOA', 'name' => __('Angolan Kwanza', 'tfuse'), 'symbol' => 'Kz'),
                array('code' => 'BHD', 'name' => __('Bahraini Dinar', 'tfuse'), 'symbol' => '\u0628.\u062f'),
                array('code' => 'BIF', 'name' => __('Burundian Franc', 'tfuse'), 'symbol' => 'Fr'),
                array('code' => 'BMD', 'name' => __('Bermudian Dollar', 'tfuse'), 'symbol' => '$'),
                array('code' => 'BND', 'name' => __('Brunei Dollar', 'tfuse'), 'symbol' => '$'),
                array('code' => 'BTN', 'name' => __('Bhutanese Ngultrum', 'tfuse'), 'symbol' => 'Nu.'),
                array('code' => 'BWP', 'name' => __('Botswana Pula', 'tfuse'), 'symbol' => 'P'),
                array('code' => 'BZD', 'name' => __('Belize Dollar', 'tfuse'), 'symbol' => '$'),
                array('code' => 'CDF', 'name' => __('Congolese Franc', 'tfuse'), 'symbol' => 'Fr'),
                array('code' => 'CUC', 'name' => __('Cuban convertible Peso', 'tfuse'), 'symbol' => '$'),
                array('code' => 'CUP', 'name' => __('Cuban Peso', 'tfuse'), 'symbol' => '$'),
                array('code' => 'CVE', 'name' => __('Cape Verdean Escudo', 'tfuse'), 'symbol' => '$'),
                array('code' => 'DJF', 'name' => __('Djiboutian Franc', 'tfuse'), 'symbol' => 'Fdj'),
                array('code' => 'DZD', 'name' => __('Algerian Dinar', 'tfuse'), 'symbol' => '\u062f.\u062c'),
                array('code' => 'ETB', 'name' => __('Ethiopian Birr', 'tfuse'), 'symbol' => 'Br'),
                array('code' => 'FJD', 'name' => __('Fijian Dollar', 'tfuse'), 'symbol' => '$'),
                array('code' => 'FKP', 'name' => __('Falkland Islands Pound', 'tfuse'), 'symbol' => '\u00a3'),
                array('code' => 'GHS', 'name' => __('Ghana Cedi', 'tfuse'), 'symbol' => '\u20b5'),
                array('code' => 'GMD', 'name' => __('Gambian Dalasi', 'tfuse'), 'symbol' => 'D'),
                array('code' => 'GNF', 'name' => __('Guinean Franc', 'tfuse'), 'symbol' => 'Fr'),
                array('code' => 'GYD', 'name' => __('Guyanese Dollar', 'tfuse'), 'symbol' => '$'),
                array('code' => 'HTG', 'name' => __('Haitian Gourde', 'tfuse'), 'symbol' => 'G'),
                array('code' => 'IQD', 'name' => __('Iraqi Dinar', 'tfuse'), 'symbol' => '\u0639.\u062f'),
                array('code' => 'IRR', 'name' => __('Iranian Rial', 'tfuse'), 'symbol' => '\ufdfc'),
                array('code' => 'JOD', 'name' => __('Jordanian dinar', 'tfuse'), 'symbol' => '\u062f.\u0627'),
                array('code' => 'KGS', 'name' => __('Kyrgyzstani Som', 'tfuse'), 'symbol' => 'som'),
                array('code' => 'KMF', 'name' => __('Comorian Franc', 'tfuse'), 'symbol' => 'Fr'),
                array('code' => 'LAK', 'name' => __('Lao kip', 'tfuse'), 'symbol' => '\u20ad'),
                array('code' => 'LRD', 'name' => __('Liberian Dollar', 'tfuse'), 'symbol' => '$'),
                array('code' => 'LSL', 'name' => __('Lesotho Loti', 'tfuse'), 'symbol' => 'L'),
                array('code' => 'LYD', 'name' => __('Libyan Dinar', 'tfuse'), 'symbol' => '\u0644.\u062f'),
                array('code' => 'MAD', 'name' => __('Moroccan Dirham', 'tfuse'), 'symbol' => '\u062f.\u0645.'),
                array('code' => 'MMK', 'name' => __('Burmese Kyat', 'tfuse'), 'symbol' => 'K'),
                array('code' => 'MNT', 'name' => __('Mongolian Togrog', 'tfuse'), 'symbol' => '\u20ae'),
                array('code' => 'MRO', 'name' => __('Mauritanian Ouguiya', 'tfuse'), 'symbol' => 'UM'),
                array('code' => 'MVR', 'name' => __('Maldivian Rufiyaa', 'tfuse'), 'symbol' => 'MVR'),
                array('code' => 'MWK', 'name' => __('Malawian Kwacha', 'tfuse'), 'symbol' => 'MK'),
                array('code' => 'MZN', 'name' => __('Mozambican Metical', 'tfuse'), 'symbol' => 'MTn'),
                array('code' => 'NAD', 'name' => __('Namibian Dollar', 'tfuse'), 'symbol' => '$'),
                array('code' => 'PAB', 'name' => __('Panamanian Balboa', 'tfuse'), 'symbol' => 'B/.'),
                array('code' => 'PGK', 'name' => __('Papua New Guinean Kina', 'tfuse'), 'symbol' => 'K'),
                array('code' => 'PLN', 'name' => __('Polish zloty', 'tfuse'), 'symbol' => 'z\u0142'),
                array('code' => 'RSD', 'name' => __('Serbian Dinar', 'tfuse'), 'symbol' => '\u0420\u0421\u0414'),
                array('code' => 'RWF', 'name' => __('Rwandan Franc', 'tfuse'), 'symbol' => 'FRw'),
                array('code' => 'SBD', 'name' => __('Solomon Islands Dollar', 'tfuse'), 'symbol' => '$'),
                array('code' => 'SDG', 'name' => __('Sudanese Pound', 'tfuse'), 'symbol' => '\u00a3'),
                array('code' => 'SHP', 'name' => __('Saint Helena Pound', 'tfuse'), 'symbol' => '\u00a3'),
                array('code' => 'SLL', 'name' => __('Sierra Leonean Leone', 'tfuse'), 'symbol' => 'Le'),
                array('code' => 'SOS', 'name' => __('Somali Shilling', 'tfuse'), 'symbol' => 'Sh'),
                array('code' => 'STD', 'name' => __('Sao Tome and Principe Dobra', 'tfuse'), 'symbol' => 'Db'),
                array('code' => 'SVC', 'name' => __('Salvadoran Colon', 'tfuse'), 'symbol' => '\u20a1'),
                array('code' => 'SYP', 'name' => __('Syrian Pound', 'tfuse'), 'symbol' => '\u00a3S'),
                array('code' => 'SZL', 'name' => __('Swazi Lilangeni', 'tfuse'), 'symbol' => 'L'),
                array('code' => 'TJS', 'name' => __('Tajikistani Somoni', 'tfuse'), 'symbol' => '\u0405\u041c'),
                array('code' => 'TND', 'name' => __('Tunisian Dinar', 'tfuse'), 'symbol' => '\u062f.\u062a'),
                array('code' => 'TOP', 'name' => __('Tongan pa\'anga', 'tfuse'), 'symbol' => 'T$'),
                array('code' => 'VEF', 'name' => __('Venezuelan bolivar', 'tfuse'), 'symbol' => 'Bs F'),
                array('code' => 'VUV', 'name' => __('Vanuatu Vatu', 'tfuse'), 'symbol' => 'Vt'),
                array('code' => 'WST', 'name' => __('Samoan tala', 'tfuse'), 'symbol' => 'T'),
                array('code' => 'XAF', 'name' => __('Central African Franc', 'tfuse'), 'symbol' => 'Fr'),
                array('code' => 'XOF', 'name' => __('West African Franc', 'tfuse'), 'symbol' => 'Fr'),
                array('code' => 'XPF', 'name' => __('CFP Franc', 'tfuse'), 'symbol' => 'Fr'),
                array('code' => 'YER', 'name' => __('Yemeni Rial', 'tfuse'), 'symbol' => '\ufdfc'),
            );
        }

        $ret = array();

        foreach ($currency as $a) {
            $ret[$a[$key]] = $a[$value];
        }

        return $ret;
    }
}

/**
 * Filters/Actions
 */
{
    add_action('wp_ajax_change_gallery_id', 'change_gallery_id');
    function change_gallery_id() {
        global $TFUSE;

        $post_id   = $TFUSE->request->REQUEST('post_id');
        if(!tfuse_parse_boolean($TFUSE->request->REQUEST('change'))) {echo json_encode(array('id'=> $post_id));die;}
        $id        = $TFUSE->request->REQUEST('input_id');
        $media     = $TFUSE->request->REQUEST('media');

        $_token    = (trim($id) != '') ? $id . '_' . $post_id : $post_id;
        $post_fnc  = ($media == 'image') ? 'tfuse_gallery_group_post' : 'tfuse_download_group_post';
        $post_type = str_replace('_post', '', $post_fnc);
        $post      = get_post($post_id);
        if ($post->post_type != $post_type)
            $post_id = $post_fnc($_token);
        echo json_encode(array('id'=> $post_id));
        die;
    }

    add_filter('attachment_fields_to_edit', 'media_galery_image_edit', 11, 2);
    function media_galery_image_edit($form_fields, $post) {
        $content = get_post_meta($post->ID,'image_options',true);
        $form_fields['tfseek_exclude_slider'] = array(
            'label' => __('Exclude from slider', 'tfuse'),
            'input' => 'html',
            'html'  => '<label for="imgexcludefromslider_check"><input id="imgexcludefromslider_check" type="checkbox" ' . (@$content['imgexcludefromslider_check'] ? 'checked' : '') . ' value="yes" name="imgexcludefromslider_check_'.$post->ID.'"/> <span>' . __('Yes', 'tfuse') . '</span></label>'
        );

        $form_fields['tfseek_main'] = array(
            'label' => __('Set as main', 'tfuse'),
            'input' => 'html',
            'html'  => '<label for="imgmain_check"><input id="imgmain_check" type="checkbox" ' . (@$content['imgmain_check']== 'yes'? 'checked' : '') . ' value="yes" name="imgmain_check_'.$post->ID.'"/> <span>' . __('Yes', 'tfuse') . '</span></label>'
        );

        return $form_fields;
    }

    add_filter('attachment_fields_to_save', 'media_galery_image_save', 11, 2);
    function media_galery_image_save($post, $attachment) {
        global $TFUSE;

        $a = array();
        if($TFUSE->request->isset_POST('imgexcludefromslider_check_'.$post['ID']))
            $a['imgexcludefromslider_check'] = $TFUSE->request->POST('imgexcludefromslider_check_'.$post['ID']);
        if($TFUSE->request->isset_POST('imgmain_check_'.$post['ID']))
            $a['imgmain_check'] = $TFUSE->request->POST('imgmain_check_'.$post['ID']);
        tf_update_post_meta($post['ID'],'image_options',$a);

        return $post;
    }

    add_filter('media_upload_tabs', 'remove_media_tabs');
    function remove_media_tabs($tabs) {
        global $TFUSE;

        if ($TFUSE->request->isset_REQUEST('no_tabs')) {
            unset($tabs['library']);
            unset($tabs['type_url']);
        }

        return $tabs;
    }

    remove_filter('the_content', 'wpautop');
    remove_filter('the_content', 'wptexturize');

    add_filter('the_content', 'tfuse_formatter', 99);
    add_filter('themefuse_shortcodes', 'tfuse_formatter', 99);
    function tfuse_formatter($content) {
        $new_content      = '';
        $pattern_full     = '{(\[raw\].*?\[/raw\])}is';
        $pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
        $pieces           = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

        foreach ($pieces as $piece) {
            if (preg_match($pattern_contents, $piece, $matches)) {
                $new_content .= $matches[1];
            } else {
                $new_content .= wptexturize(wpautop($piece));
            }
        }
        return $new_content;
    }

    add_action('wp_head', 'tfuse_favicon_and_css');
    function tfuse_favicon_and_css() {
        // Favicon
        $favicon = tfuse_options('favicon');
        if (!empty($favicon))
            echo '<link rel="shortcut icon" href="' . $favicon . '"/>' . PHP_EOL;

        // Custom CSS block in header
        $custom_css = tfuse_options('custom_css');
        if (!empty($custom_css)) {
            $output = '<style type="text/css">' . PHP_EOL;
            $output .= html_entity_decode($custom_css);
            $output .= '</style>' . PHP_EOL;
            echo $output;
        }
    }

    add_action('wp_footer', 'tfuse_analytics', 100);
    function tfuse_analytics() {
        echo tfuse_options('google_analytics');
    }
}

/**
 * Wordpress alternatives
 */
{
    /**
     * update_post_meta() stripslashes https://core.trac.wordpress.org/ticket/21767 this function not
     */
    function tf_update_post_meta($post_id, $meta_key, $meta_value, $prev_value = '') {
        // make sure meta is added to the post, not a revision
        if ( $the_post = wp_is_post_revision($post_id) )
            $post_id = $the_post;

        $meta_type  = 'post';
        $object_id  = $post_id;

        if ( !$meta_type || !$meta_key )
            return false;

        if ( !$object_id = absint($object_id) )
            return false;

        if ( ! $table = _get_meta_table($meta_type) )
            return false;

        global $wpdb;

        $column = esc_sql($meta_type . '_id');
        $id_column = 'user' == $meta_type ? 'umeta_id' : 'meta_id';

        // expected_slashed ($meta_key)
        // $meta_key = stripslashes($meta_key); // this was the trouble !
        $passed_value = $meta_value;
        // $meta_value = stripslashes_deep($meta_value); // this was the trouble !
        $meta_value = sanitize_meta( $meta_key, $meta_value, $meta_type );

        $check = apply_filters( "update_{$meta_type}_metadata", null, $object_id, $meta_key, $meta_value, $prev_value );
        if ( null !== $check )
            return (bool) $check;

        // Compare existing value to new value if no prev value given and the key exists only once.
        if ( empty($prev_value) ) {
            $old_value = get_metadata($meta_type, $object_id, $meta_key);
            if ( count($old_value) == 1 ) {
                if ( $old_value[0] === $meta_value )
                    return false;
            }
        }

        if ( ! $meta_id = $wpdb->get_var( $wpdb->prepare( "SELECT $id_column FROM $table WHERE meta_key = %s AND $column = %d", $meta_key, $object_id ) ) )
            return tf_add_post_meta($object_id, $meta_key, $passed_value);

        $_meta_value = $meta_value;
        $meta_value = maybe_serialize( $meta_value );

        $data  = compact( 'meta_value' );
        $where = array( $column => $object_id, 'meta_key' => $meta_key );

        if ( !empty( $prev_value ) ) {
            $prev_value = maybe_serialize($prev_value);
            $where['meta_value'] = $prev_value;
        }

        do_action( "update_{$meta_type}_meta", $meta_id, $object_id, $meta_key, $_meta_value );

        if ( 'post' == $meta_type )
            do_action( 'update_postmeta', $meta_id, $object_id, $meta_key, $meta_value );

        $wpdb->update( $table, $data, $where );

        wp_cache_delete($object_id, $meta_type . '_meta');

        do_action( "updated_{$meta_type}_meta", $meta_id, $object_id, $meta_key, $_meta_value );

        if ( 'post' == $meta_type )
            do_action( 'updated_postmeta', $meta_id, $object_id, $meta_key, $meta_value );

        return true;
    }

    /**
     * add_post_meta() stripslashes https://core.trac.wordpress.org/ticket/21767 this function not
     */
    function tf_add_post_meta($post_id, $meta_key, $meta_value, $unique = false) {
        // make sure meta is added to the post, not a revision
        if ( $the_post = wp_is_post_revision($post_id) )
            $post_id = $the_post;

        $meta_type  = 'post';
        $object_id  = $post_id;

        if ( !$meta_type || !$meta_key )
            return false;

        if ( !$object_id = absint($object_id) )
            return false;

        if ( ! $table = _get_meta_table($meta_type) )
            return false;

        global $wpdb;

        $column = esc_sql($meta_type . '_id');

        // expected_slashed ($meta_key)
        // $meta_key = stripslashes($meta_key); // this was the trouble !
        // $meta_value = stripslashes_deep($meta_value); // this was the trouble !
        $meta_value = sanitize_meta( $meta_key, $meta_value, $meta_type );

        $check = apply_filters( "add_{$meta_type}_metadata", null, $object_id, $meta_key, $meta_value, $unique );
        if ( null !== $check )
            return $check;

        if ( $unique && $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM $table WHERE meta_key = %s AND $column = %d",
            $meta_key, $object_id ) ) )
            return false;

        $_meta_value = $meta_value;
        $meta_value = maybe_serialize( $meta_value );

        do_action( "add_{$meta_type}_meta", $object_id, $meta_key, $_meta_value );

        $result = $wpdb->insert( $table, array(
            $column => $object_id,
            'meta_key' => $meta_key,
            'meta_value' => $meta_value
        ) );

        if ( ! $result )
            return false;

        $mid = (int) $wpdb->insert_id;

        wp_cache_delete($object_id, $meta_type . '_meta');

        do_action( "added_{$meta_type}_meta", $mid, $object_id, $meta_key, $_meta_value );

        return $mid;
    }

    /**
     * delete_post_meta() stripslashes https://core.trac.wordpress.org/ticket/21767 this function not
     */
    function tf_delete_post_meta($post_id, $meta_key, $meta_value = '') {
        // make sure meta is added to the post, not a revision
        if ( $the_post = wp_is_post_revision($post_id) )
            $post_id = $the_post;

        $meta_type  = 'post';
        $object_id  = $post_id;
        $delete_all = false;

        if ( !$meta_type || !$meta_key )
            return false;

        if ( (!$object_id = absint($object_id)) && !$delete_all )
            return false;

        if ( ! $table = _get_meta_table($meta_type) )
            return false;

        global $wpdb;

        $type_column = esc_sql($meta_type . '_id');
        $id_column = 'user' == $meta_type ? 'umeta_id' : 'meta_id';
        // expected_slashed ($meta_key)
        // $meta_key = stripslashes($meta_key); // this was the trouble !
        // $meta_value = stripslashes_deep($meta_value); // this was the trouble !

        $check = apply_filters( "delete_{$meta_type}_metadata", null, $object_id, $meta_key, $meta_value, $delete_all );
        if ( null !== $check )
            return (bool) $check;

        $_meta_value = $meta_value;
        $meta_value = maybe_serialize( $meta_value );

        $query = $wpdb->prepare( "SELECT $id_column FROM $table WHERE meta_key = %s", $meta_key );

        if ( !$delete_all )
            $query .= $wpdb->prepare(" AND $type_column = %d", $object_id );

        if ( $meta_value )
            $query .= $wpdb->prepare(" AND meta_value = %s", $meta_value );

        $meta_ids = $wpdb->get_col( $query );
        if ( !count( $meta_ids ) )
            return false;

        if ( $delete_all )
            $object_ids = $wpdb->get_col( $wpdb->prepare( "SELECT $type_column FROM $table WHERE meta_key = %s", $meta_key ) );

        do_action( "delete_{$meta_type}_meta", $meta_ids, $object_id, $meta_key, $_meta_value );

        // Old-style action.
        if ( 'post' == $meta_type )
            do_action( 'delete_postmeta', $meta_ids );

        $query = "DELETE FROM $table WHERE $id_column IN( " . implode( ',', $meta_ids ) . " )";

        $count = $wpdb->query($query);

        if ( !$count )
            return false;

        if ( $delete_all ) {
            foreach ( (array) $object_ids as $o_id ) {
                wp_cache_delete($o_id, $meta_type . '_meta');
            }
        } else {
            wp_cache_delete($object_id, $meta_type . '_meta');
        }

        do_action( "deleted_{$meta_type}_meta", $meta_ids, $object_id, $meta_key, $_meta_value );

        // Old-style action.
        if ( 'post' == $meta_type )
            do_action( 'deleted_postmeta', $meta_ids );

        return true;
    }
}