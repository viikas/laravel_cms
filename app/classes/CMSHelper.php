<?php
use App\Models\Article;
use App\Models\Category;
use App\Models\Contacts;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Photos;
class CMSHelper {
    public static function SideColumnData()
    {
        $sado = Page::where('code', 'message-from-sado')->first();
        $cat=Category::where('code','video')->first();
        $video = Article::where('category_id', $cat->id)->where('is_published','1')->orderBy('id','desc')->first();
        $cat=Category::where('code','news')->first();
        $news = Article::where('category_id', $cat->id)->where('is_published','1')->orderBy('id','desc')->take(3)->get();
        //dd($news);
        $data['sado'] = $sado;
        $data['video'] = $video;
        $data['news']=$news;
        //dd($data['news']);
        return $data;
    }
}
