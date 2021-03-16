<?php

namespace App\Repositories;
use App\Models\BlogPost as Model;
use Illuminate\Database\Eloquent\Collection;

class BlogPostRepositori extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }
    /** получить список статтей для вывода всписке (Админка)*/
   public function getAllWithPaginate()
    {
        $columns = [
            'id',
            'title',
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id',
        ];
        $result = $this->startConditions()
            ->select($columns)
            ->orderBy('id','DESC')->with(['category' => function ($query)
            {
                $query->select(['id','title',]);
            },'user:id,name',])->paginate(25);
//dd($result);
        return $result;

    }

    /**
     * Получить модель для редактирования в админке
     * @param int $id
    * return Model
    */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

}
