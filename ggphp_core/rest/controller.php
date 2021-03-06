<?php

/**
 * 实现REST控制器
 * @package rest
 * @author goodzsq@gmail.com
 */
class rest_controller {

    /**
     * 资源
     * @var rest_interface 
     */
    private $resource = null;

    /**
     * REST控制器入口
     * @return string 
     */
    public function do_index() {       
        $paramsCount = count($_REQUEST['_arg']);
        if ($paramsCount == 0) {
            return error("参数错误不存在");
        } else if ($paramsCount == 1) {
            list($resourceName, $type) = $this->parseResource($_REQUEST['_arg'][0]);
        } else if ($paramsCount > 1) {
            $resourceName = $_REQUEST['_arg'][0];
        }

        $resourceClassName = 'rest_' . $resourceName;
        if (class_exists($resourceClassName)) {
            $this->resource = new $resourceClassName();
            if (!($this->resource instanceof rest_interface)) {
                return error("资源[$resourceName]未实现[rest_interface]接口");
            }
            if ($paramsCount == 1){
                $id = null;
            }
            else if ($paramsCount > 1){
                $arg = implode('/', array_slice($_REQUEST['_arg'], 1));
                list($id, $type) = $this->parseResource($arg);
            }
            return $this->dispatch($id, core_request::method(), $type, $_REQUEST);
        } else {
            return error("资源[$resourceName]不存在");
        }
    }

    private function parseResource($arg) {
        $p = strrpos($arg, '.');
        if ($p === false) {
            $name = $arg;
            $type = 'html';
        } else {
            $name = substr($arg, 0, $p);
            $type = substr($arg, $p + 1);
        }
        return array($name, $type);
    }

    /**
     * 调用目标资源对应的方法
     * @param string $id 请求资源id
     * @param string $method 请求资源方法
     * @param string $type 请求资源类型
     * @param Array $data 请求数据
     * @return mixed 
     */
    private function dispatch($id, $method, $type = null, $data = null) {
        $method = strtoupper($method);
        $type = strtolower($type);
        $result = null;
        //用隐藏字段_method来实现REST的PUT方法和DELETE方法
        if ($method == 'POST' && isset($data['_method'])) {
            $method = strtoupper($data['_method']);
        }
        unset($data['_arg']);
        unset($data['_method']);
        try {
            if ($method == 'GET') {
                if (!empty($id)) {
                    $result = $this->resource->get($id);
                } else {
                    $result = $this->resource->index();
                }
            } else if ($method == 'POST') {
                $result = $this->resource->post($id, $data);
            } else if ($method == 'PUT') {
                $result = $this->resource->put($id, $data);
            } else if ($method == 'DELETE') {
                if (!empty($id)) {
                    $result = $this->resource->delete($id);
                } else {
                    $result = $this->resource->deleteAll();
                }
            }
            $status = 200;
        }catch(exception_validate $exc){
            $result = $exc->getValidateError();
            $status = 500;
        } catch (Exception $exc) {
            $result = $exc->getMessage();
            $status = 500;
        }

        if ($type == 'json') {
            $package = array('status' => $status, 'data' => $result);
            return json_encode($package);
        } else {
            return trace($result);
        }
    }

}
