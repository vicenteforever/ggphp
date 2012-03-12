<?php

return array(
    array('name' => 'id', 'label' => 'ID', 'field' => 'id'),
    array('name' => 'title', 'label' => '标题', 'field' => 'string', 'required' => true),
    array('name' => 'content', 'label' => '正文', 'field' => 'text', 'widget'=>'tinymce'),
);
