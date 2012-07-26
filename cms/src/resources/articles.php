<?php

/**
 *  resources_articles
 * @package resources
 * @author goodzsq@gmail.com
 */
class resources_articles implements rest_interface {

    /** 
     *
     * @var orm_model
     */
    public $model;
    
    public function __construct() {
        $model = orm('article');
    }
    
    public function create($data) {
        $entity = $this->model->load();
        foreach($data as $key=>$value){
            $entity->$key = $value;
        }
        return $entity->save();
    }

    public function delete($id) {
        $entity = $this->model->load($id);
        return $entity->delete();
    }

    public function deleteAll() {
        
    }

    public function show($id) {
        $entity = $this->model->load($id);
        return $entity;
    }

    public function showAll() {
        
    }

    public function update($id, $data) {
        
    }

    public function updateAll($data) {
        
    }

}
