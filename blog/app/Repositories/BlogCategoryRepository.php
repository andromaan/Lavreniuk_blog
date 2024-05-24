<?php

namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BlogСategoryRepository.
 */
class BlogCategoryRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class; //абстрагування моделі BlogCategory, для легшого створення іншого репозиторія
    }
    /**
     *  Отримати модель для редагування в адмінці
     *  @param int $id
     *  @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     *  Отримати список категорій для виводу в випадаючий список
     *  @return Collection
     */
    public function getForComboBox()
    {
        //return $this->startConditions()->all();
        $columns = implode(', ', [
            'id',
            'CONCAT (id, ". ", title) AS id_title',  //додаємо поле id_title
        ]);

        //$result = $this->startConditions()->all();
        /*$result = $this                           //1 варіант
            ->startConditions()
            ->select('blog_categories.*',
                \DB::raw('CONCAT (id, ". ", title) AS id_title'))
            ->toBase()                              //не робити колекцію(масив) BlogCategory, отримати дані у вигляді класу
            ->get();*/

        $result = $this                           //2 варіант
        ->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();

        //dd($result);

        return $result;
    }

}
