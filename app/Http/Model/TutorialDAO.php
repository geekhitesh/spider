<?php
/**
 * Created by PhpStorm.
 * User: hiteshah
 * Date: 7/26/2017
 * Time: 4:52 PM
 */

namespace App\Http\Model;

use \DB;

use \Cache;


class TutorialDAO
{
    public $tutorial;
    public $categoryList;


    public function __construct()
    {

        $this->tutorial = new Tutorial();
        $this->categoryList = Cache::get('categoryList');

    }

    public function getTutorial($tutorial_id)
    {

        $tutorial = DB::select('select * 
                                from  tutorial 
                                where expiration_date is null 
                                     and tutorial_id = ?'
                               ,[$tutorial_id]
                              );

        return $tutorial;
    }

    public function getTutorialList()
    {
        $tutorialList = DB::select('select * from tutorial where expiration_date is null');

        return $tutorialList;
    }

    public function insertTutorial(Tutorial $tutorial)
    {

        var_dump($tutorial);

        DB::insert('insert into tutorial(tutorial_name,
                                         tutorial_desc,
                                         tutorial_parents,
                                         tutorial_category_id,
                                         author_id,
                                         website_id,
                                         default_tutorial_sections,
                                         tutorial_chapter_groups) values(?,?,?,?,?,?,?,?)',
                                         [
                                             $tutorial->tutorial_name,
                                             $tutorial->tutorial_desc,
                                             $tutorial->tutorial_parents,
                                             $tutorial->tutorial_category_id,
                                             $tutorial->author_id,
                                             $tutorial->website_id,
                                             $tutorial->default_tutorial_sections,
                                             $tutorial->tutorial_chapter_groups
                                         ]);


        $last_insert_id = DB::getPdo()->lastInsertId();
        $tutorial->tutorial_id = $last_insert_id;

        foreach($this->categoryList as $category)
        {
            if($category->tutorial_category_id == $tutorial->tutorial_category_id)
            {
                $tutorial->tutorial_category_name = $category->tutorial_category_name;
                break;
            }
        }

        $this->insertTags($tutorial);



    }


    public function  insertTags(Tutorial $tutorial)
    {

        $url = "tutorialsb.in/".
                str_replace(" ","-",strtolower($tutorial->tutorial_category_name)).
                "/".
                str_replace(" ","-",strtolower($tutorial->tutorial_name)).
                "-tutorial".
                "/".
                $tutorial->tutorial_id;

        foreach($tutorial->tagList as $tag)
        {
            DB::insert('insert into global_tags(tutorial_category_id,
                                                tutorial_id,
                                                tag_name,
                                                tag_url) values(?,?,?,?)',
                [   $tutorial->tutorial_category_id,
                    $tutorial->tutorial_id,
                    strtolower($tag),
                    $url
                ]);
        }
    }

}