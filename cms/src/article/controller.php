<?php

/**
 * 文章
 * @package article
 * @author goodzsq@gmail.com
 */
class article_controller {

    /**
     * 主页
     * @return string 
     */
    function do_index() {
        $buf = block('menu', 'main');
        $buf .= block('menu', 'tree');
        return $buf;
    }

    /**
     * 新闻
     */
    function do_news() {
        $sql = 'select * from ecs_admin_log limit 0, 5';
        $list = mydb()->sqlQueryCache($sql);
        foreach ($list as $row) {
            print_r($row);
        }
    }

    /**
     * 测试
     */
    function do_test() {
        $css = new script_css();
        $css->blueprint();
        $buf = <<<EOF
<div class='container '>
<h1>title</h1>
<hr />
<div class='span-7 colborder'>aaaaaaaaaaa aaaaaaaaaaa aaaaaaaaaaaaaaaa aaaaaaaaaaaa aaaaaaaaa</div>
<div class='span-8 colborder'>b</div>
<div class='span-7 last'>c</div>
<hr />
<div class='span-15 colborder prepend-1'>b</div>
<div class='span-7 last'>c</div>
<hr />
<div class='span-12 border '>12</div>
<div class='span-12 last'>12</div>
<hr />
<div class='span-12 '>12</div>
<div class='span-12 last'>12</div>
<hr />
<div class='span-4 colborder prepend-1 ' >b</div>
<div class='span-4 colborder prepend-1' ><div>1234567<div style="position:absolute;top:50px">hello world</div></div></div>
<div class='span-4 colborder prepend-1' >b</div>
<div class='span-5 prepend-1 last' >b</div>
<hr />
<div class='span-4 prepend-1 colborder' >b</div>
<div class='span-5 colborder' >b</div>
<div class='span-5 colborder' >b</div>
<div class='span-5 prepend-1 last ' >b</div>
<hr />
</div>
EOF;
        return $buf;
    }

    //private function //
}

