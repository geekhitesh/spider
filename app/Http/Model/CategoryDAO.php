<?php
/**
 * Created by PhpStorm.
 * User: buniyad
 * Date: 7/25/2017
 * Time: 8:06 AM
 */

namespace App\Http\Model;

use DB;
use \Cache;


class CategoryDAO
{

    public $categoryList;


    /**
     * CategoryDAO constructor.
     * @param $CategoryList
     */
    public function __construct()
    {
        $this->categoryList = Cache::get('categoryList');;
    }


    public function getCategoryList()
    {

        $categoryList = DB::select('select 	*	from tutorial_category where expiration_date is null');
        $this->categoryList = $categoryList;
        return $this->categoryList;
    }

    public function insertCategory(Category $category)
    {

       var_dump($category);
      /* $parent = "";

        foreach ($category->tutorialCategoryParents as $categoryParent)
        {
            $parent =$parent."@".$categoryParent;
        }

        $parent = substr($parent,0,strlen($parent)-1); */

        DB::insert('insert into tutorial_category(tutorial_category_name,
                                                  tutorial_category_desc,
                                                  tutorial_category_parents) values(?,?,?)',
                                                  [   $category->tutorialCategoryName,
                                                      $category->tutorialCategoryDesc,
                                                      $category->tutorialCategoryParents
                                                  ]);

       $last_insert_id = DB::getPdo()->lastInsertId();

       $category->tutorialCategoryId = $last_insert_id;
       $this->insertTags($category);

       if(isset($last_insert_id))
       {
           foreach($category->categoryWebsiteList as $websiteId)
           {
               DB::insert('insert into website_tutorial_category(website_id,
                                                                 tutorial_category_id) values(?,?)',
                                                                 [$websiteId,$last_insert_id]);
           }
       }

    }

    public function updateCategory($category)
    {

    }

    public function getCategory($category_id)
    {
        foreach($this->categoryList as $category)
        {
           // var_dump($category);
            if($category->tutorial_category_id == $category_id)
            {
                return $category;
            }
        }

        return 0;

    }

    public function deleteCategory($category_id)
    {

    }


    public function  insertTags(Category $category)
    {

        $url = "tutorialsb.in/tutorials/".
               str_replace(" ","-",strtolower($category->tutorialCategoryName)).
               "/".
               $category->tutorialCategoryId;

        foreach($category->tagList as $tag)
        {
            DB::insert('insert into global_tags(tutorial_category_id,
                                                tag_name,
                                                tag_url) values(?,?,?)',
                [   $category->tutorialCategoryId,
                    strtolower($tag),
                    $url
                ]);
        }
    }



}