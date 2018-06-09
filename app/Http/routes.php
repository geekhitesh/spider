<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});



//Route::get('/post/{id}','PostsController@index');

//Route::resource('/admin','PostsController');

Route::auth();

//Route::get('/home', 'HomeController@index');

//Route::get('/admin','ValidateApiKeyController@index');

/*Route::get('/admin/{id}',[
    'middleware' => 'validateApiKey',
    'uses' => 'ValidateApiKeyController@index'
]);*/



Route::resource('test','TestController');


Route::group(['as' => 'admin::', 'prefix' => 'admin'], function () {
    Route::get('/cache/build', 'CacheController@index');
    Route::get('/cache/status', 'CacheController@getCache');
    Route::get('/cache/tutorial/parent/', 'CacheController@buildTutorialParent');
    Route::get('/generic-global-tags/website/{website_name}','GenericGlobalTagsController@getWebsiteTags');
    Route::post('/generic-global-tags/website/get-content','GenericGlobalTagsController@getLinkedContent');
    Route::get('/generic-global-tags/website/{website_name}/content','GenericGlobalTagsController@createLinkedContent');
    Route::get('/generic-global-tags/website/{website_name}/cache','GenericGlobalTagsController@buildWebsiteTagsCache');
    Route::get('/generic-global-tags/website/{website_name}/delete/{page_id}','GenericGlobalTagsController@deletePage');
    Route::get('/generic-global-tags/website/{website_name}/delete-all-pages/AZDPA7354B','GenericGlobalTagsController@deleteAllWebsitePage');

    // Category Controller
    Route::get('/category/all', 'CategoryController@getCategories'); //Fetch all categories
    //Fetch category on the basis of category_id
    Route::get('/tutorials/{category_name}/{category_id}','CategoryController@getCategory');



    // Tutorial Controller
    Route::get('/tutorial/get/{tutorial_id}', 'TutorialController@getTutorial');
    Route::get('/tutorial/list', 'TutorialController@getTutorialList');



    Route::get('/{category_name}/{tutorial_name}-tutorial/{tutorial_id}', 'TutorialController@getTutorial');



    // Chapter Controller

    Route::get('/{category_name}/{tutorial_name}/tutorial/{chapter_name}/{tutorial_id}/{chapter_id}','ChapterController@getChapter');

    Route::get('/chapter/create/{tutorial_id}', 'ChapterController@create');
    Route::get('/chapter/get/{tutorial_id}/{tutorial_chapter_id}', 'ChapterController@getChapter');
    Route::get('/chapter/get-content/{tutorial_id}/{tutorial_chapter_id}', 'ChapterController@getChapterContent');
    Route::get('/chapter/list/{tutorial_id}/', 'ChapterController@getChaptersList');




    Route::resource('category','CategoryController');
    Route::resource('section','SectionController');
    Route::resource('tutorial','TutorialController');
    Route::resource('chapter','ChapterController');
    Route::resource('generic-global-tags','GenericGlobalTagsController');



    Route::get('/excel','TestExcelController@index');

});