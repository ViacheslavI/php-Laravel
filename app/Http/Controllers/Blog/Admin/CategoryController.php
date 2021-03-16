<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Illuminate\Support\Str;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /** @var BlogCategoryRepository  */
    private  $blogCategoryRepository;
    public function __construct()
    {
        parent:: __construct();
        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }
    public function index()
    {
        //$paginator = BlogCategory::paginate(15);
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(25);
        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = BlogCategory::make();
       /* $categoryList = BlogCategory::all();*/
        $categoryList =
            $this->blogCategoryRepository->getForComboBox();
        return view('blog.admin.categories.edit',compact('item','categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data =$request->input();
        /*
         * //Ушло в обсервер
         * if(empty($data['slug'])){
             $data['slug'] = Str::slug($data['title']);
           }*/

        //  Создаст объект но не добавит в бд
        /* $item = new BlogCategory($data);
         dd($item);
         $item->save();*/

        // Создаст объект и добавит в БД
        $item = BlogCategory::create($data);

        if ($item){
            return redirect()->route('blog.admin.categories.edit',[$item->id])
                ->with(['success' => 'Успешно сохранено']);
        }else{
            return back()->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  BlogCategoryRepository $categoryRepository
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$item = BlogCategory::findOrFail($id);
        //$categoryList = BlogCategory::all();
        $item = $this->blogCategoryRepository->getEdit($id);
      /**
       *  $v['title_before'] = $item->title;
        $item->title = 'ASDasdAsd asdASD 1221';
        $v['title_after'] = $item->title;
        $v['getAttribute'] = $item->getAttribute('title');
        $v['attributesToArray'] = $item->attributesToArray();
        $v['attributes'] = $item->attributes['title'];
        $v['getAttributeValue'] = $item->getAttributeValue('title');
        $v['getMutatedAttributes'] = $item->getMutatedAttributes();
        $v['hasGetMutator for title'] = $item->hasGetMutator('title');
        $v['toArray'] = $item->toArray();
        dd($v, $item);
       *
       */
        if(empty($item)){
            abort(404);
        }
        $categoryList = $this->blogCategoryRepository->getForComboBox();
        return view ('blog.admin.categories.edit', compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);
        /*  $rules = [
              'title'         => 'required|min:5|max:200',
              'slug'          => 'max:200',
              'description'   => 'string|max:500|min:3',
              'parent_id'     => 'required|integer|exists:blog_categories,id',
          ];*/

        //$validatedData = $this->validate($request,$rules);

        //$validatedData = $request->validate($rules);

        // $validator = \Validator::make($request->all(),$rules);
        /*$validatedData[] = $validator->passes();
        $validatedData[] = $validator->validate();
        $validatedData[] = $validator->valid();
        $validatedData[] = $validator->failed();
        $validatedData[] = $validator->errors();
        $validatedData[] = $validator->fails();

        dd($validatedData);*/

        //$item = BlogCategory::find($id);
        if(empty($item)){
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
        }
        $data = $request->all();

        /* ушло в обсервер*/
        /*  if(empty($data['slug'])){
              $data['slug'] = Str::slug ($data['title']);

          }*/
        /*  $result = $item
              ->fill($data)
              ->save();*/
        //Тоже самое что и  ->fill($data)->save();
        $result = $item ->update($data);
        if($result){
            return redirect()
                ->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
