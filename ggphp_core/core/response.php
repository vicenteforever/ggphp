<?php

/**
 * 设置向浏览器的输出格式
 * @package core
 */
class core_response {

    static function script($addfile = null) {
        static $script;
        if (isset($addfile)) {
            $script[$addfile] = $addfile;
        } else {
            return $script;
        }
    }

    static function css($addfile = null) {
        static $css;
        if (isset($addfile)) {
            $css[$addfile] = $addfile;
        } else {
            return $css;
        }
    }

    static function html($title, $content) {
        if (!isset($title)) {
            $controller = app()->getController() . '_controller';
            $action = config('app', 'action_prefix') . ucfirst(app()->getAction());
            $title = reflect($controller)->doc();
            $subtitle = reflect($controller)->doc($action);
            if (!empty($subtitle)) {
                $title .= " - {$subtitle}";
            }
        }
        return view('html', array('title' => $title, 'content' => $content));
    }

    static function download($filename, $content) {
        return view('download', array('filename' => $filename, 'content' => $content));
    }

    static function error($errorMessage) {
        return view('error', array('errorMessage' => $errorMessage));
    }

    static function json($data) {
        return view('json', $data);
    }

    static function jsonp($data, $callback) {
        return $callback . '(' . view('json', $data) . ')';
    }

    static function redirect($url) {
        return view('redirect', array('url' => $url));
    }

    static function rss($data) {
        return view('rss', $data);
    }

    static function xml($data) {
        return view('xml', $data);
    }

    static function mail($address, $title, $content) {
        return view('mail', array(
                    'address' => $address,
                    'title' => $title,
                    'content' => $content,
                ));
    }

    static function gzip($data, $contenttype) {
        if (strstr($_SERVER["HTTP_ACCEPT_ENCODING"], "gzip")) {
            header("Content-Type: {$data['Content-Type']}");
            header("Content-Encoding: gzip");
            header("Vary: Accept-Encoding");
            header("Content-Length: " . strlen($data['content']));
            echo $data['content'];
        }
    }

}