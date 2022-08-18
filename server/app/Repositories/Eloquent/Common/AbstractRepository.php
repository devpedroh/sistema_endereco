<?php

namespace App\Repositories\Eloquent\Common;

class AbstractRepository {

    protected $model;

    public function __construct () {
        $this->model = $this->resolveModel();
    }

    public function resolveModel () {
        return app($this->model);
    }

    public function get ($id, $column) {
        return $this->model->find($id)->$column;
    }

    public function where ($where) {
        return $this->model->where($where)->first();
    }

    public function find ($id) {
        return $this->model->find($id);
    }

    public function findAll () {
        return $this->model->all();
    }

    public function create(array $data) {
        return $this->model->create($data);
    }

    public function update(array $data, $id, $where = null) {
        if (!empty($where)) {
            return $this->model->where($where)->update($data);
        }
        return $this->model->find($id)->update($data);
    }

    public function delete($id) {
        return $this->model->destroy($id);
    }

}
