<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;
use App\Http\Model;
use \Cache;

class ChapterController extends Controller
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
    public $chapterDAO;




    public  function __construct() {

        $this->middleware('validateApiKey');
        $this->categoryModelDAO = new Model\CategoryDAO();
        $this->websiteListDAO = new Model\WebsiteDAO();
        $this->tutorialDAO = new Model\TutorialDAO();
        $this->chapterDAO = new Model\ChapterDAO();

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
    public function create($tutorial_id)
    {
        //$tutorial_id = $request->tutorial_id;
        $default_tutorial_sections = "";
        foreach ($this->tutorialList as $tutorial) {
            if ($tutorial->tutorial_id == $tutorial_id) {
                $default_tutorial_sections = $tutorial->default_tutorial_sections;
                $tutorial_chapter_groups = $tutorial->tutorial_chapter_groups;
                $tutorial_name = $tutorial->tutorial_name;
                $tutorial_desc = $tutorial->tutorial_desc;
            }
        }

        $chapterGroups = explode(",",$tutorial_chapter_groups);

        $chapterGroupsArray = array();
        foreach($chapterGroups as $chapterGroup)
        {

            $chapterGroupsArray[$chapterGroup] = $chapterGroup;
        }


        $sectionArray = explode(",",str_replace(" ","_",$default_tutorial_sections));
        $chapterData    = array($sectionArray);
        $chapterData[1] = $tutorial_name;
        $chapterData[2] = $tutorial_desc;
        $chapterData[3] = $default_tutorial_sections;
        $chapterData[4] = $tutorial_id;
        $chapterData[5] = $chapterGroupsArray;
        return view("chapter_add")->with(compact('chapterData'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chapterSectionsName = array();
        $chapter = new Model\Chapter();
        $chapter->tutorial_chapter_name = $request->input('tutorial_chapter_name');
        $chapter->tutorial_chapter_desc = $request->input('tutorial_chapter_desc');
        $chapter->tutorial_id = $request->input('tutorial_id');
        $chapter->tutorial_chapter_group_name = $request->input('tutorial_chapter_group_name');
        $chapter->tagList = explode(",",$request->input('tags_cloud'));
        $chapterSectionsName = $request->input('chapterSectionsName');


        foreach ($this->tutorialList as $tutorial)
        {

            if($tutorial->tutorial_id == $chapter->tutorial_id)
            {
                $chapter->category_id = $tutorial->tutorial_category_id;
                $chapter->tutorial_name = $tutorial->tutorial_name;
                break;
            }
        }

        foreach ($this->categoryList as $category)
        {
            if($category->tutorial_category_id = $chapter->category_id)
            {
                $chapter->category_name = $category->tutorial_category_name;
                break;
            }
        }

      //  var_dump($chapter);
      //  var_dump($chapterSectionsName);

        $chapterSectionArray = explode(',',str_replace(" ","_",$chapterSectionsName));

        foreach ($chapterSectionArray as $chapterSection)
        {
            echo $request->input("trim($chapterSection)");
         $chapter->chapter_sections[$chapterSection] = $request->input($chapterSection);
        }


      //  var_dump($chapter);

        $this->chapterDAO->insertChapter($chapter);


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


    public function getChapter($category_name,$tutorial_name,$chapter_name,$tutorial_id, $tutorial_chapter_id)
    {
        echo "hello";

        echo "$tutorial_id";
        echo "<br/> $tutorial_chapter_id";

        $chapter = new Model\Chapter();
        $chapter->tutorial_id = $tutorial_id;
        $chapter->tutorial_chapter_id = $tutorial_chapter_id;

        var_dump($chapter);

        $chapterRecord = $this->chapterDAO->getChapter($chapter);


        return(json_encode($chapterRecord));

    }

    public function getChapterContent($tutorial_id, $tutorial_chapter_id)
    {
        $chapter = new Model\Chapter();
        $chapter->tutorial_id = $tutorial_id;
        $chapter->tutorial_chapter_id = $tutorial_chapter_id;
        $chapterContent = $this->chapterDAO->getChapterContent($chapter);
        return($chapterContent);

    }


    public function getChaptersList($tutorial_id)
    {

        return(json_encode($this->chapterDAO->getChaptersList($tutorial_id)));
    }
}
