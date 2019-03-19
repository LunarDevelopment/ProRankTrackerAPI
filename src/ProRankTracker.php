<?php

namespace LunarDevelopment\ProRankTracker;

/**
 * Class ProRankTracker
 * @package LunarDevelopment\ProRankTracker
 */
class ProRankTracker {

    private $_email;
    private $_password;
    private $_url;

    /**
     * ProRankTracker constructor.
     * @param       $email
     * @param       $password
     * @param array $params
     */
    function __construct($email, $password, $params=array()) {
        $this->_email = $email;
        $this->_password = $password;
        $this->_url = 'https://proranktracker.com/api/';
    }

    /**
     * @param       $cmd
     * @param array $args
     * @return mixed|object
     */
    function call($cmd, $args=array()) {
        $args['cmd'] = $cmd;
        return $this->__x_call($args);
    }

    private function __x_call($args) {
        $ch = curl_init($this->_url);

        curl_setopt($ch, CURLOPT_USERPWD, $this->_email . ":" . $this->_password);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->__http_build_multi_query($args));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_USERAGENT, "ProRankTracker API PHP-Client");
        // curl_setopt($ch, CURLOPT_VERBOSE, true);
        $response = curl_exec($ch);

        if (curl_errno($ch) != CURLE_OK) {
            return (object) array(
                'result' => 'error',
                'error_message' => "Failed to call remote server: " . curl_error($ch)
            );
        } else {
            $info = curl_getinfo($ch);
            if ($info['http_code'] !== 200) {
                return (object) array(
                    'result' => 'error',
                    'error_message' => "Remote Server Error: " . $info['http_code']
                );
            }

            curl_close($ch);
            return json_decode($response);
        }
    }

    public function __call($function, $args) {
        $function = str_replace('_', '.', $function);
        if ($function === 'urls.look.up.by.url') $function = 'urls.look_up_by_url';
        if (! in_array($function, array('urls.get', 'urls.look_up_by_url', 'urls.new', 'url.get', 'url.delete', 'url.edit', 'terms.get', 'terms.new', 'term.get', 'term.delete', 'term.enable', 'term.disable', 'term.run', 'se.get', 'groups.get', 'groups.new', 'group.edit', 'group.get', 'group.delete', 'url.group.add', 'url.group.delete', 'tags.get', 'tags.new', 'tag.get', 'tag.delete', 'term.tag.add', 'term.tag.delete'))) {
            return (object) array(
                'result' => 'error',
                'error_message' => 'Unknown command'
            );
        }
        if (is_array($args) && count($args) == 1 && is_array($args[0])) $args = $args[0]; // Hack
        return $this->call($function, $args);
    }

    private function __http_build_multi_query($data, $key=NULL) {
        $query = array();
        foreach ($data as $k => $value) {
            if (is_array($value)) {
                $query[] = $this->__http_build_multi_query($value, $k . '[]');
            } else {
                $query[] = urlencode(is_null($key) ? $k : $key) . '=' . rawurlencode($value);
            }
        }
        return implode('&', $query);
    }
}

