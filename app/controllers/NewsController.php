<?php

class NewsController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->beforeFilter('csrf', array('on', 'post'));
    }

    public function getIndex() {

        return View::make('news.index')
                        ->with('news', News::all());
    }

    public function getAdd() {
        return View::make('news.add');
    }

    public function postCreate() {

        $validator = Validator::make(Input::all(), News::$rules);

        if ($validator->passes()) {

            $news = new News;
            $news->title = Input::get('title');
            $news->meta = Input::get('meta');
            $news->description = Input::get('description');
            $news->start_date = Input::get('start_date');
            $news->end_date = Input::get('end_date');
            $image = Input::file('image');
            $filename = time('Y-d') . "." . $image->getClientOriginalExtension();
            $path = public_path('assets/admin/img/products/' . $filename);
            Image::make($image->getRealPath())->resize(468, 249)->save($path);
            $baner->images = 'assets/admin/img/products/' . $filename;
            $news->save();

            return Redirect::to('news/index')
                            ->with('message', 'article done adding');
        }

        return Redirect::back()
                        ->with('message', 'article done error pleas try again later')
                        ->withErrors($validator)
                        ->withInput();
    }

    public function getEdit($id) {
        return View::make('news.edit')
                        ->with('news', News::find($id));
    }

    public function postUpdate($id) {
        $validator = Validator::make(Input::all(), News::$rules);

        if ($validator->passes()) {

            $news = News::find($id);
            $news->title = Input::get('title');
            $news->meta = Input::get('meta');
            $news->description = Input::get('description');
            $news->start_date = Input::get('start_date');
            $news->end_date = Input::get('end_date');
            $image = Input::file('image');
            if ($image) {
                $filename = time('Y-d') . "." . $image->getClientOriginalExtension();
                $path = public_path('assets/admin/img/products/' . $filename);
                Image::make($image->getRealPath())->resize(468, 249)->save($path);

                ##########################
                if ($news->images and file_exists($news->images)) {

                    File::delete($news->images);
                }
                $news->images = 'assets/admin/img/products/' . $filename;
                ############################
            }
            $news->save();

            return Redirect::to('news/index')
                            ->with('message', 'article done editing');
        }

        return Redirect::back()
                        ->with('message', 'article done error pleas try again later')
                        ->withErrors($validator)
                        ->withInput();
    }

    public function getDelete($id) {

        $news = News::find($id);
        if ($news) {
            $news->delete();
            return Redirect::to('news/index')
                            ->with('message', 'article done deleted');
        }
    }

}
