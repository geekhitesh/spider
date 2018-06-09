<?php
/**
 * Created by PhpStorm.
 * User: buniyad
 * Date: 7/29/2017
 * Time: 7:54 PM
 */

namespace App\Http\Model;


class ChapterSectionDAO
{

    public $section;
    public $sectionList;

    public function __construct()
    {
        $section = new ChapterSection();
        $sectionList = array();
    }

    public function getSection($section)
    {

        return($this->section);
    }



    public function insertSection($section)
    {

    }



    public function updateSection($section)
    {

        return $this->section;
    }


    public function deleteSection($section)
    {

    }


    public function getSectionList($chapter)
    {

        return $this->sectionList;
    }

}