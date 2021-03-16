<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BlogPost;

class DiggingDeeperController extends Controller
{
    public function  collections(){
        $result = [];
        $eloquentCollection =BlogPost::withTrashed()->get();
        //dd(__METHOD__, $eloquentCollection, $eloquentCollection->toArray());
        $collection = collect($eloquentCollection->toArray());
       /* dd(get_class($eloquentCollection),
           get_class($collection),
           $collection);*/
        $result['first'] = $collection->first();
        $result['last'] = $collection->last();

        $result['where']['data'] = $collection
            ->where('category_id', 10)
            ->values()
            ->keyBy('id');
        dd($result);
        $result['where']['count'] = $result['where']['data']->count();
        $result['where']['isEmpty'] = $result['where']['data']->isEmpty();
        $result['where']['isNotEmpty'] = $result['where']['data']->isNotEmpty();
        dd($result);
        $result['where_first'] = $collection
            ->firstWhere('created_at', '>', '2021-02-10 01:35:11');
        dd($result);
        //базовая переменная не изменится, просто вернется измененная версия
        $result['map']['all'] = $collection->map(function(array $item){
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item[deleted_at]);
            return $newItem;
        });
        dd($result);
        $result['map']['not_exists'] = $result['map']['all']->where('exists', '=', false);
        dd($result);
        //базовая переменная измениться (трансформируется)
        $collection->transform(function (array $item){
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);
            $newItem->created_at = Carbon::parse($item['created_at']);
            return $newItem;
        });
        dd($collection);

        $newItem = new \stdClass();
        $newItem->id = 9999;

        $newItem2 = new \stdClass();
        $newItem2->id = 8888;
        //Установить элемент в начало коллекции
        $newItemFirst = $collection->prepend($newItem)->first();
        $newItemLast = $collection->push($newItem2)->last();
        $pulledItem = $collection->pull(1);
        dd(compact('collection','newItemFirst','newItemLast','pulledItem'));

        //Фильтрация. Замена orWhere();
        $filtered = $collection->filter(function($item){
            $byDay = $item->ccreated_at->isFriday();
            $byDate = $item->created_at->day==13;
            $result = $byDay && $byDate;
            return $result;
        });
        dd(compact('filtered'));

        // сортировка
        $sortedsimpleCollection = collect([5,3,1,4,2])->sort()->values();
        $sortedAscCollection = $collection->sortBy('created_at');
        $sortedDescCollection = $collection->sorByDesc('item_id');

        dd(compact('sortedsimpleCollection','sortedAscCollection','sortedDescCollection'));


    }
}
