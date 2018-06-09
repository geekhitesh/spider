<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Http\Model;
use \Cache;

class TutorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $categoryList;
    public $websiteList;
    public $tutorialList;
    public $categoryModelDAO;
    public $websiteListDAO;
    public $tutorialDAO;




    public  function __construct() {

        $this->middleware('validateApiKey');
        $this->categoryModelDAO = new Model\CategoryDAO();
        $this->websiteListDAO = new Model\WebsiteDAO();
        $this->tutorialDAO = new Model\TutorialDAO();

        $this->categoryList = Cache::get('categoryList');
        $this->websiteList = Cache::get('websiteList');
        $this->tutorialList = Cache::get('tutorialList');
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
        //Build Arrays needed to be sent to View

        $websiteArray = array();
        foreach($this->websiteList as $website)
        {
            $websiteArray[$website->website_id] = $website->website_name;
        }


        // $this->categoryList = $this->categoryModelDAO->getCategoryList();
        $tutorialArray = array('0001'=>'');
        foreach ($this->tutorialList as $tutorial)
        {
           $tutorialArray[$tutorial->tutorial_parents."@".$tutorial->tutorial_id] = $tutorial->tutorial_name;
            //print_r($categoryArray);
        }
        $categoryArray = array('0001'=>'');
        foreach ($this->categoryList as $category)
        {
            $categoryArray[$category->tutorial_category_parents."@".$category->tutorial_category_id] = $category->tutorial_category_name;
        }

        $tutorialData = array($websiteArray,$categoryArray,$tutorialArray);
        return view("tutorial_add")->with(compact('tutorialData'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $tutorial = new Model\Tutorial();

        $tutorial->tutorial_name =  $request->input('tutorial_name');
        $tutorial->tutorial_desc =  $request->input('tutorial_desc');
        $tutorial->tutorial_parents =  $request->input('tutorial_parents');
       // $tutorial->tutorial_category_id =  $request->input('tutorial_category_id');

        $tutorialCategories = explode("@",$request->input('tutorial_category_id'));
        $tutorial->tutorial_category_id  = end($tutorialCategories);


        $tutorial->default_tutorial_sections =  $request->input('default_tutorial_sections');
        $tutorial->website_id =  $request->input('website_id');
        $tutorial->author_id =  $request->input('author_id');
        $tutorial->tutorial_chapter_groups = $request->input('tutorial_chapter_groups');
        $tutorial->tagList = explode(",",$request->input('tags_cloud'));
        $this->tutorialDAO->insertTutorial($tutorial);

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


    public function getTutorial($category_name,$tutorial_name,$tutorial_id)
    {

        $tutorial['records'] = $this->tutorialDAO->getTutorial($tutorial_id);
        return(json_encode($tutorial));
    }

    public function getTutorialList()
    {

        $tutorials['records'] = $this->tutorialList;

        return(json_encode($this->tutorialList));
    }
}
