<?php

namespace App\Http\Controllers;

use App\Http\Model\GenericGlobalTags;
use App\Http\Model\GenericGlobalTagsDAO;
use Illuminate\Http\Request;

use App\Http\Requests;
use \Cache;

class GenericGlobalTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     *
     *
     */

    public $genericGlobalTag;
    public $genericGlobalTagsDao;


    public function __construct()
    {
        $this->genericGlobalTag = new GenericGlobalTags();
        $this->genericGlobalTagsDao = new GenericGlobalTagsDAO();
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
        //

        return view("generic_global_tags");
    }

    /**
     * Store a newly created resource in storage.
     * Function to store excel file and send the file_name to DAO to process it further.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $file = $request->file('global_tags_excel');

        $destinationPath = 'generic_global_tags';
        $file_name = $file->getClientOriginalName();

        $file_name = explode(".",$file_name);
        $file_name = $file_name[0]."_".time().".".$file_name[1];
        $file->move($destinationPath,$file_name);

       // echo $file->getFilename();

        $this->genericGlobalTagsDao->insertAllTags($file_name);


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

    public function getWebsiteTags($website_name)
    {

        $genericGlobalTags = $this->genericGlobalTagsDao->getWebsiteTags(strtolower($website_name));

        return view('generic_global_tags_show')->with(compact('genericGlobalTags'));

    }

    public function buildWebsiteTagsCache($website_name)
    {
        $this->genericGlobalTagsDao->buildWebsiteTagsCache(strtolower($website_name));

       // var_dump(Cache::get(strtolower($website_name)."_websiteTags"));

        echo "Build Process for Tags Cache of <b>$website_name </b>is finished.";
    }

    public function getLinkedContent(Request $request)
    {
        $website_name = $request->input('website_name');
        $content = $request->input('content');
        $this->genericGlobalTagsDao->createLinkedContent($website_name,$content);
    }


    public function createLinkedContent($website_name)
    {
        return view('generic_global_tags_linked')->with( compact('website_name'));

    }

    public function deletePage($website_name,$page_name)
    {

        $this->genericGlobalTagsDao->deletePage($website_name,$page_name);

    }


    public function deleteAllWebsitePage($website_name)
    {
        $this->genericGlobalTagsDao->deleteAllWebsitePage(strtolower($website_name));

    }

}
