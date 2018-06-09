<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\Http\Model;

use \Cache;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $categoryList;
    public $categoryModelDAO;
    public $websiteListDAO;
    public $websiteList;

    public  function __construct() {

        $this->middleware('validateApiKey');
        $this->categoryModelDAO = new Model\CategoryDAO();
        $this->websiteListDAO = new Model\WebsiteDAO();

        $this->categoryList = Cache::get('categoryList');
        $this->websiteList = Cache::get('websiteList');
    }


    public function isValidApiKey(Request $request)
    {
        if($request->validationDone == false)
        {
            return false;
        }

        return true;
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // later on pass it in the global cache
        // Remove all these codes from here and pass it on to global cache.


        $websiteArray = array();
        foreach($this->websiteList as $website)
        {
            $websiteRecord = array();
            $websiteRecord['website_id'] = $website->website_id;
            $websiteRecord['website_name'] = $website->website_name;
            array_push($websiteArray,$websiteRecord);
        }
        $categoryArray = array('0001'=>'');
        foreach ($this->categoryList as $category)
        {
            $categoryArray[$category->tutorial_category_parents."@".$category->tutorial_category_id] = $category->tutorial_category_name;

        }
        $categoryData = array($websiteArray,$categoryArray);
        return view("category_add")->with(compact('categoryData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       /* if($this->isValidApiKey($request))
        {
            var_dump($request->all());
        }*/

       // print_r($request->input('websites'));
         $category = new Model\Category();

         $category->tutorialCategoryName = $request->input('category_name');
         $category->tutorialCategoryParents = $request->input('category_parents');
         $category->tutorialCategoryDesc = $request->input('category_description');
         $category->categoryWebsiteList = $request->input('websites');
         $category->tagList = explode(",",$request->input('tags_cloud'));


        // Store the category data in database and update the websites table
        $this->categoryModelDAO->insertCategory($category);


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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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


    public function getCategories()
    {
       //echo "CategoryController";
      //  print_r($this->categoryList);

        $records['records'] = $this->categoryList;
         return(json_encode($records));
    }

    public function getCategory($category_name,$category_id)
    {
        $category = $this->categoryModelDAO->getCategory($category_id);

        $records['records'] = $category;
        return(json_encode($records));

    }


}
