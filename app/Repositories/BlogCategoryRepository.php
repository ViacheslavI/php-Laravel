<?php


namespace Repositories;

namespace App\Repositories;
use App\Models\BlogCategory as Model;

class BlogCategoryRepository extends CoreRepository
{

    /** получить  модель для редактирования в админке */
    public function getEdit($id){
        return $this->startConditions()->find($id);
    }
    /** получить списсок категорий для вывода в выпадающее меню */
    public function getForComboBox()
    {
        //return $this->startConditions()->all();
        $columns = implode(',',['id','CONCAT(id,". ", title) AS id_title',]);
        /* $result[] = $this->startConditions()->all();
           $result[] = $this
             ->startConditions()
             ->select('blog_categories.*', \DB::raw('CONCAT(id,". ", title) AS id_title'))
             ->toBase()
             ->get();*/
        $result = $this
            ->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();

        return $result;
    }
    /** получить категории для вывода пагинатором */

    protected function getModelClass()
    {
        return Model::class;
    }
    public function getAllWithPaginate($perPage = null)
    {
        $columns = ['id', 'title', 'parent_id'];
        $result = $this
            ->startConditions()
            ->select($columns)
            ->with(['parentCategory:id,title',])
            ->paginate($perPage);
        return $result;
    }
}
