<?php

class test_controller {

    function doIndex() {
        return html('ggphp examples');
    }

    function doPhpinfo() {
        phpinfo();
    }

    function test() {
        $mem = memcache();

        $mem->a = array('a', 'b', 'c');
        $mem->b = 'bbbbb';
        $mem->c = 'ccccc';
        $mem->d = 'ddddd';
        $mem->e = 'eeeee';
    }

    function doTest() {
        app()->log('a');
        $mem = memcache();
        app()->log('b');
        $mem->weewrre = 'sdfsdfsdf';
        $mem->__set('sdf werwr sdf', 'qqqqqqqq');
        //$this->test();
        app()->log('c');
        echo $mem->a;
        echo $mem->b;
        echo $mem->c;
        echo $mem->d;
        echo $mem->e;
        app()->log('d');
        echo trace($mem->keys());
        app()->log('e');
        return html('ok');
    }

    function doNosql() {
        $test = array('a' => 'aaa', 'b' => array('bbb', 'ccc'));
        $a = nosql('session', 'test1');
        //$a->test = $test;
        //$a->save();
        $b = nosql('database', 'test1');
        //$b->test = $test;
        //$b->save();
        $c = nosql('file', 'test2');
        //$c->test = $test;
        //$c->save();
        $d = nosql('memcache', 'test4');
        //$d->test = $test;
        //$d->save();
        $trace['session'] = trace($a->data());
        $trace['database'] = trace($b->data());
        $trace['file'] = trace($c->data());
        $trace['memcache'] = trace($d->data());
        return html(trace($trace));
    }

    function doDoc() {
        $doc = reflect('core_app')->doc('start');
        return html("[$doc]");
    }

    function doFilter() {
        $str = 'h1. hello <a href=javascript:alert(123)>world</a>';
        return html(output($str, array('xss', 'textile')));
    }

    function doConfig() {
        $appname = 'read from config file <br> app_name is:' . config('app', 'app_name');
        return html($appname, 'read config file test');
    }

    function doTranslate() {
        return html(t('hello world'), 'translate test');
    }

    function doSmarty() {
        $smarty = core_view::smarty();
        $smarty->assign('name', 'hello world');
        $smarty->display('index.tpl');
    }

    function doTextile() {
        $in = <<<EOF
h2. textile filter sample
    
A *simple* example.

EOF;
        return html(util_filter::textile($in));
    }

    function doMarkdown() {
        $str = <<<EOF
# this is h1
## this is h2
[google](http://www.google.com)

###markdown###

1. aaaaa
2. bbbbb
3. ccccc

* sdfsdf
* wrew
 ** werwr
 ** werwr
* sdfds
---

| Program   | Path to Markdown
| -------   | ----------------
| [Pivot][] | `(site home)/pivot/includes/markdown/`

    echo util_filter::markdown(\$str);
	    echo util_filter::markdown(\$str);
		


EOF;
        return html(util_filter::markdown($str));
    }

}