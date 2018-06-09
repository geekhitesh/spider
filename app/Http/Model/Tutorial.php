<?php
/**
 * Created by PhpStorm.
 * User: hiteshah
 * Date: 7/26/2017
 * Time: 4:52 PM
 */

namespace App\Http\Model;


class Tutorial
{

    public $tutorial_id;
    public $tutorial_name;
    public $tutorial_desc;
    public $tutorial_parents;
    public $tutorial_category_id;
    public $tutorial_category_name;
    public $author_id;
    public $website_id;
    public $default_tutorial_sections;
    public $tutorial_chapter_groups;
    public $tagList = array();

    /**
     * @return mixed
     */
    public function getDefaultTutorialSections()
    {
        return $this->default_tutorial_sections;
    }

    /**
     * @param mixed $default_tutorial_sections
     */
    public function setDefaultTutorialSections($default_tutorial_sections)
    {
        $this->default_tutorial_sections = $default_tutorial_sections;
    }

    /**
     * @return mixed
     */
    public function getTutorialId()
    {
        return $this->tutorial_id;
    }

    /**
     * @param mixed $tutorial_id
     */
    public function setTutorialId($tutorial_id)
    {
        $this->tutorial_id = $tutorial_id;
    }

    /**
     * @return mixed
     */
    public function getTutorialName()
    {
        return $this->tutorial_name;
    }

    /**
     * @param mixed $tutorial_name
     */
    public function setTutorialName($tutorial_name)
    {
        $this->tutorial_name = $tutorial_name;
    }

    /**
     * @return mixed
     */
    public function getTutorialDesc()
    {
        return $this->tutorial_desc;
    }

    /**
     * @param mixed $tutorial_desc
     */
    public function setTutorialDesc($tutorial_desc)
    {
        $this->tutorial_desc = $tutorial_desc;
    }

    /**
     * @return mixed
     */
    public function getTutorialParents()
    {
        return $this->tutorial_parents;
    }

    /**
     * @param mixed $tutorial_parents
     */
    public function setTutorialParents($tutorial_parents)
    {
        $this->tutorial_parents = $tutorial_parents;
    }

    /**
     * @return mixed
     */
    public function getTutorialCategoryId()
    {
        return $this->tutorial_category_id;
    }

    /**
     * @param mixed $tutorial_category_id
     */
    public function setTutorialCategoryId($tutorial_category_id)
    {
        $this->tutorial_category_id = $tutorial_category_id;
    }

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

    /**
     * @param mixed $author_id
     */
    public function setAuthorId($author_id)
    {
        $this->author_id = $author_id;
    }

    /**
     * @return mixed
     */
    public function getWebsiteId()
    {
        return $this->website_id;
    }

    /**
     * @param mixed $website_id
     */
    public function setWebsiteId($website_id)
    {
        $this->website_id = $website_id;
    }




}