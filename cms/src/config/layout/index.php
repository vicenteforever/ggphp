<?php

return array(
    array('name' => 'header', 'label' => '页眉', 'span' => 24, 'content' => array('block::menu::main')),
    array('name' => 'left', 'label' => '内容', 'span' => 8, 'content' => 'sidebar'),
    array('name' => 'content', 'label' => '内容', 'span' => 16, 'last' => true, 'content' => '[content]'),
    array('name' => 'a1', 'label' => 'a1', 'span' => 8, 'border' => true, 'content' => 'sidebar'),
    array('name' => 'a2', 'label' => 'a2', 'span' => 8, 'last' => true, 'content' => 'sidebar'),
    array('name' => 'footer', 'label' => '页脚', 'span' => 24, 'content' => array('block::menu::second')),
);

