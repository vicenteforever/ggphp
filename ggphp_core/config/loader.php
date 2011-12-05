<?php

class config_loader{

	/**
	 * ��ȡϵͳ������Ϣ
	 * ��Ӧ��Ŀ¼�µ������ļ����ܵ����úϲ� Ӧ��Ŀ¼�����������ڿ�ܵ����� �����������ݻ���
	 * @param string $file ��������
	 * @param string $id ���÷���
	 * @return array
	 * @example $config = config('database', 'default')//��ȡdatabase�����ļ��е�default����
	 */
	static function load($file, $key=''){
		static $data;
		if(!isset($data[$file])){
			$appConfigFile = APP_DIR.DS.'src'.DS.'config'.DS.$file.'.php';
			if(file_exists($appConfigFile)){
				$appConfig = include($appConfigFile);
			}
			else{
				$appConfig = array();
			}
			$ggConfigFile =GG_DIR.DS.'config'.DS.$file.'.php';
			if(file_exists($ggConfigFile)){
				$ggConfig = include($ggConfigFile);
			}
			else{
				$ggConfig = array();
			}
			$data[$file] = array_merge($ggConfig, $appConfig);
		}
		if(empty($key)){
			return $data[$file];
		}
		else{
			if(isset($data[$file][$key]))
				return $data[$file][$key];
			else
				return null;
		}
	}

}