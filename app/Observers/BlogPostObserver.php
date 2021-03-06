<?php

namespace App\Observers;

use App\Models\BlogPost;
use Carbon\Carbon;

class BlogPostObserver
{
    /**
     * Handle the blog post "created" event.
     * отработка перед созданием записи
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function creating(BlogPost $blogPost)
    {
        //dd($blogPost);
        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);
        $this->setHtml($blogPost);
        $this->setUser($blogPost);
    }

    /**
     * Handle the blog post "updated" event.
     * сработка перед обновлением записи
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function updating(BlogPost $blogPost)
    {
        /*$test[] = $blogPost->isDirty();
       $test[] = $blogPost->isDirty('is_published');
       $test[] = $blogPost->isDirty('user_id');
       $test[] = $blogPost->getAttribute('is_published');
       $test[] = $blogPost->is_published;
       $test[] = $blogPost->getOriginal('is_published');
       dd($test);*/
        $this->setPublishedAt($blogPost);

        $this->setSlug($blogPost);
    }
    /**
     * если дата публиации не установлена и происходит установка флага - опубликовано то устанавливаем дату публикацыы на текушую
     *
     */
    public function setPublishedAt(BlogPost $blogPost){
        $needSetPublished = empty($blogPost->published_at)&& $blogPost->is_published;

        if($needSetPublished){
            $blogPost->published_at = Carbon::now();
    }
}
    /**
     * если поле слага пустое  то заполняем его конвертацией заголовка
     */
    public function setSlug(BlogPost $blogPost){
        if(empty($blogPost->slug)){
            $blogPost->slug =\Str::slug($blogPost->title);
        }
    }
    /** Установка значения  полю content_html относительно поля   content_raw*/
    protected function setHtml(BlogPost $blogPost)
    {
        if($blogPost->isDirty('content_raw')){
            //TODO: генерация markdown->html
            $blogPost->content_html =$blogPost->content_raw;
        }
    }
    /**Если не указан user_id то устанавливать пользователя по умолчанию */
    protected function setUser(BlogPost $blogPost)
    {
        $blogPost->user_id = auth()->id() ?? BlogPost::UNKNOWN_USER;
    }
    public function deleting(BlogPost $blogPost){
       // dd(__METHOD__, $blogPost);
        //return false;
    }
    /**
     * Handle the blog post "deleted" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function deleted(BlogPost $blogPost)
    {
        // dd(__METHOD__, $blogPost);
    }

    /**
     * Handle the blog post "restored" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function restored(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "force deleted" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function forceDeleted(BlogPost $blogPost)
    {
        //
    }
}
