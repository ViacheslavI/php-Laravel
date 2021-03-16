<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/** репозиторий раоты с сущьностью. Может выдавать наборы данных. Не может создавать/изменять сущьности*/
abstract class CoreRepository
{
    /**
     *  @var Model
     */
    protected  $model;
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    abstract protected function getModelClass();

    protected function  startConditions()
    {
        return clone $this->model;
    }
}
