<?php
/**
 * Created by PhpStorm.
 * User: buniyad
 * Date: 7/29/2017
 * Time: 7:50 PM
 */

namespace App\Http\Model;

use File;
use DB;

class ChapterDAO
{

    public $chapter;
    public $chapterList;

    public function __construct()
    {
        $chapter = new Chapter();
        $chapterList = array();
    }

    public function getChapter($chapter)
    {

        $chapterContent = "";


       $chapterRecords =  DB::Select('select * 
                                    from tutorial_chapter 
                                    where     tutorial_id=?
                                          and tutorial_chapter_id=?
                                          and expiration_date is  null',
                                    [$chapter->tutorial_id,$chapter->tutorial_chapter_id]
                                   );

        $this->chapter = $chapterRecords[0];

        if($this->chapter->tutorial_chapter_id != '')
        {
         //  echo "hello";
           $chapter_file_name = $this->getFileName($this->chapter,"chapter");
           $chapterContent = File::get($chapter_file_name);
           //echo $chapterContent;

        }


       $chapterRecord['chapter_summary'] = $this->chapter;
       $chapterRecord['chapter_content'] = $chapterContent;


        //echo $chapterContent;
        return($chapterRecord);
    }



    public function insertChapter($chapter)
    {
        // 1. store chapter record in chapter table.
        // 2. write chapter to file
           // for each section perform the 3rd and 4th step.
        // 3. store section record in section tables.
        // 4.  write section to file


        DB::insert('insert into tutorial_chapter(tutorial_chapter_name,
                                                 tutorial_id,
                                                 tutorial_chapter_desc,
                                                 tutorial_chapter_group_name
                                                 ) values(?,?,?,?)',
                                                     [$chapter->tutorial_chapter_name,
                                                      $chapter->tutorial_id,
                                                      $chapter->tutorial_chapter_desc,
                                                      $chapter->tutorial_chapter_group_name
                                                     ]);
        $chapter->tutorial_chapter_id = DB::getPdo()->lastInsertId();


        $this->insertTags($chapter);

        $this->createChapter($chapter);

       // var_dump($chapter);
        foreach($chapter->chapter_sections as $section_name => $chapter_section_content)
        {

            DB::insert('insert into tutorial_chapter_section(tutorial_id,
                                                             tutorial_chapter_id,
                                                             section_name
                                                             ) values(?,?,?)',
                [   $chapter->tutorial_id,
                    $chapter->tutorial_chapter_id,
                    $section_name
                ]);



            $chapter->temp_section_id = DB::getPdo()->lastInsertId();

            $section = new ChapterSection();

            $section->tutorial_chaper_section_id = $chapter->temp_section_id;
            $section->section_name = $section_name;
            $section->section_desc = $chapter_section_content;

            $this->createSection($chapter,$section);
        }


    }



    public function updateChapter($chapter)
    {

        return $this->chapter;
    }


    public function deleteChapter($chapter)
    {

    }


    public function getChaptersList($tutorial_id)
    {
        $chapterRecords =  DB::Select('select * 
                                    from tutorial_chapter 
                                    where     tutorial_id=?
                                          and expiration_date is  null',
            [$tutorial_id]
        );


        return $chapterRecords;
    }


    public function getFileName($chapter,$fileType)
    {
        $file_name="";

        if($fileType == "chapter")
        {
            $default_chapter_path = "../storage/tutorials/chapters/";

            $file_name = $default_chapter_path.$chapter->tutorial_id."_".$chapter->tutorial_chapter_id.".chapter";

        }
        else if ($fileType == "section")
        {
            $default_chapter_path = "../storage/tutorials/sections/";

            $file_name = $default_chapter_path.$chapter->tutorial_id."_".$chapter->tutorial_chapter_id."_".$chapter->temp_section_id.".section";
        }

        return $file_name;

    }


    public function createChapter(Chapter $chapter)
    {

        $chapter_file_name = $this->getFileName($chapter,"chapter");
        $chapter_content = "";

        foreach($chapter->chapter_sections as $section_name => $chapter_section_content)
        {

            $section_name = str_replace("_"," ",$section_name);
            $section_heading = "<hr/><br/><b>$section_name</b><br/><br/>";

            $chapter_content = $chapter_content.$section_heading.$chapter_section_content;
        }

        $chapter->chapter_content = $chapter_content;

        $interlinking = new InterLinking();
        $chapter_content = $interlinking->generateLinks($chapter);

        File::put($chapter_file_name,$chapter_content);

       // echo File::get($chapter_file_name);





    }

    public function createSection(Chapter $chapter,ChapterSection $section)
    {


        echo $section_file_name = $this->getFileName($chapter,"section");

        $section_name = str_replace("_"," ",$section->section_name);

        $section_heading = "<hr/><br/><b> $chapter->tutorial_chapter_name - $section_name </b><br/><br/>";

        $section_content = $section_heading.$section->section_desc;

       // var_dump($section_content);

         File::put($section_file_name,$section_content);

        //echo File::get($chapter_file_name);

    }


    public function getChapterContent($chapter)
    {
        $chapterContent = "";

        if($chapter->tutorial_chapter_id != '')
        {
            $chapter_file_name = $this->getFileName($chapter,"chapter");
            $chapterContent = File::get($chapter_file_name);
        }

       // $chapterRecord['chapter_content'] = $chapterContent;

        return($chapterContent);

    }


    public function  insertTags(Chapter $chapter)
    {
        $url = "tutorialsb.in/".str_replace(" ","-",strtolower($chapter->category_name)).
               "/".str_replace(" ","-",strtolower($chapter->tutorial_name)).
               "-tutorial/".str_replace(" ","-",strtolower($chapter->tutorial_chapter_name)).
               "/".$chapter->tutorial_id."/".$chapter->tutorial_chapter_id;

        foreach($chapter->tagList as $tag)
        {
            DB::insert('insert into global_tags(tutorial_category_id,
                                                tutorial_id,
                                                chapter_id,
                                                tag_name,
                                                tag_url) values(?,?,?,?,?)',
                                           [   $chapter->category_id,
                                               $chapter->tutorial_id,
                                               $chapter->tutorial_chapter_id,
                                               strtolower($tag),
                                               $url
                                           ]);
        }
    }




}