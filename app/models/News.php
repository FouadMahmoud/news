<?php

class News extends Eloquent {

    protected $fillable = array('title', 'meta', 'description', 'images', 'start_date', 'end_date');
    protected $table = "news";
    public static $rules = array(
        'title' => 'required|min:3',
        'meta' => 'required|min:3',
        'description' => 'required|min:15',
        'images' => 'required',
        'start_date' => 'required',
        'end_date' => 'required'

    );

 

}

?>
