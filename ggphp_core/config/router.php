<?php
//�����е�n�ӱ��ʽ��ֵ��param(n)��ȡ, ��������actionʱ��,action�Զ���Ϊ������ʽ��һ�ӱ��ʽ��ֵ ��n�ӱ��ʽ��������param(n-1)��ȡ
return array(
	"/^test\/qq$/i" => array('controller'=>'test', 'action'=>'qq'),
	"/^test\/(\w+)\/(\d+)$/i" => array('controller'=>'test'),
);