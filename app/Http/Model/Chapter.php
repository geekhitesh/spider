<?php
/**
 * Created by PhpStorm.
 * User: buniyad
 * Date: 7/29/2017
 * Time: 7:49 PM
 */

namespace App\Http\Model;


class Chapter
{
    public $tutorial_chapter_id;
    public $tutorial_chapter_name;
    public $tutorial_chapter_sequence_no;
    public $tutorial_id;
    public $tutorial_name;
    public $category_id;
    public $category_name;
    public $tutorial_chapter_desc;
    public $tutorial_chapter_file_name;
    public $chapter_sections;
    public $tutorial_chapter_group_name;
    public $temp_section_id;
    public $chapter_content;
    public $tagList = array();


    public function __construct()
    {

        $this->chapter_sections = array();
    }

}