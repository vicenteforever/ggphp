<?php

return array(
    array('name' => 'header', 'label' => '页眉', 'span' => 24, 'content' => array('block::menu::main')),
    array('name' => 'left', 'label' => '内容', 'span' => 8, 'content' => 'sidebar', 'border'=>true),
    array('name' => 'content', 'label' => '内容', 'span' => 16, 'last' => true, 'content' => '[content]'),
    array('name' => 'footer', 'label' => '页脚', 'span' => 24, 'content' => array('block::menu::second')),
);

