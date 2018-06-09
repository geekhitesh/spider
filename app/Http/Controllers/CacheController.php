<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \Cache;

use App\Http\Requests;

use DB;

use App\Http\Model;

class CacheController extends Controller
{
    //This will create Cache

    public $categoryList;
    public $categoryModelDAO;
    public $websiteListDAO;
    public $websiteList;
    public $tutorialList;
    public $tutorialDAO;
    public $tutorialParents;

    public function index()
    {

        $this->middleware('validateApiKey');

        echo "<hr/><br/>Cache Building Process Started!!<br/>";

        $this->categoryModelDAO = new Model\CategoryDAO();
        $this->websiteListDAO = new Model\WebsiteDAO();
        $this->tutorialDAO = new Model\TutorialDAO();
        $this->categoryList = $this->categoryModelDAO->getCategoryList();
        $this->websiteList = $this->websiteListDAO->getWebsiteList();
        $this->tutorialList = $this->tutorialDAO->getTutorialList();
        $this->tutorialParents = $this->buildTutorialParent();


      //   var_dump($this->tutorialParents);

        Cache::put('categoryList',$this->categoryList,10*24*60);
        Cache::put('websiteList',$this->websiteList,10*24*60);
        Cache::put('tutorialList',$this->tutorialList,10*24*60);
        Cache::put('tutorialParents',$this->tutorialParents, 10 * 24 * 60);
        echo "<hr/><br/>Cache Building Process Ended!!<br/>";

        echo "<hr/><br/> <h1>Current Cache!!</h1><br/>";
        $this->getCache();

    }

    public function getCache()
    {

        echo "<br/><b>Category Cache</b><hr/>";
        $categoryList = Cache::get('categoryList');
        var_dump($categoryList);

        echo "<hr/> <b>Website Cache</b> <hr/>";
        $websiteList = Cache::get('websiteList');
        var_dump($websiteList);

        echo "<hr/> <b>Tutorials Cache </b><hr/>";
        $tutorialList = Cache::get('tutorialList');
        var_dump($tutorialList);

        echo "<hr/> <b>Tutorials Parents Cache </b><hr/>";
        $this->tutorialParents = Cache::get('tutorialParents');
        var_dump($this->tutorialParents);
    }


    public function buildTutorialParent()
    {
        $this->tutorialList = Cache::get('tutorialList');
        $tutorial_parents = array();
        foreach ($this->tutorialList as $tutorial) {

            $parents = array();
            $tutorial_parent_id = "";
            $parent = "";
            $node = "";
            $completed = false;
            $tutorial_id = $tutorial->tutorial_id;
            $original_tutorial_id = $tutorial_id;

            //   var_dump($this->tutorialList);


            while ($completed != true) {

                foreach ($this->tutorialList as $tutorial) {
                    if ($tutorial->tutorial_id == $tutorial_id) {
                        if ($tutorial->tutorial_parents !== "0001") {
                            array_push($parents, $tutorial->tutorial_parents);
                            $tutorial_id = $tutorial->tutorial_parents;
                            break;
                        }

                        if ($tutorial->tutorial_parents = "0001") {
                            $completed = true;
                            break;
                        }
                    }
                }
            }

            $tutorial_parents[$original_tutorial_id] = $parents;



           // var_dump(Cache::get('tutorialParents-' . $original_tutorial_id));
        }

       // var_dump($tutorial_parents);

        return $tutorial_parents;
    }



}
