<?php
/**
 * Created by PhpStorm.
 * User: buniyad
 * Date: 7/25/2017
 * Time: 7:54 AM
 */

namespace App\Http\Model;


class Category
{
   public $tutorialCategoryId;
   public $tutorialCategoryName;
   public $tutorialCategoryDesc;
   public $effectiveDate;
   public $expirationDate;
   public $tutorialCategoryParents;
   public $tutorialCategoryDefaultSections;
   public $categoryWebsiteList = array();
    public $tagList = array();


   public function __construct()
   {
       $categoryWebsiteList = array();

   }

    /**
     * @return mixed
     */
    public function getTutorialCategoryId()
    {
        return $this->tutorialCategoryId;
    }

    /**
     * @param mixed $tutorialCategoryId
     */
    public function setTutorialCategoryId($tutorialCategoryId)
    {
        $this->tutorialCategoryId = $tutorialCategoryId;
    }

    /**
     * @return mixed
     */
    public function getTutorialCategoryName()
    {
        return $this->tutorialCategoryName;
    }

    /**
     * @param mixed $tutorialCategoryName
     */
    public function setTutorialCategoryName($tutorialCategoryName)
    {
        $this->tutorialCategoryName = $tutorialCategoryName;
    }

    /**
     * @return mixed
     */
    public function getTutorialCategoryDesc()
    {
        return $this->tutorialCategoryDesc;
    }

    /**
     * @param mixed $tutorialCategoryDesc
     */
    public function setTutorialCategoryDesc($tutorialCategoryDesc)
    {
        $this->tutorialCategoryDesc = $tutorialCategoryDesc;
    }

    /**
     * @return mixed
     */
    public function getEffectiveDate()
    {
        return $this->effectiveDate;
    }

    /**
     * @param mixed $effectiveDate
     */
    public function setEffectiveDate($effectiveDate)
    {
        $this->effectiveDate = $effectiveDate;
    }

    /**
     * @return mixed
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param mixed $expirationDate
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
    }

    /**
     * @return mixed
     */
    public function getTutorialCategoryParents()
    {
        return $this->tutorialCategoryParents;
    }

    /**
     * @param mixed $tutorialCategoryParents
     */
    public function setTutorialCategoryParents($tutorialCategoryParents)
    {
        $this->tutorialCategoryParents = $tutorialCategoryParents;
    }

    /**
     * @return mixed
     */
    public function getTutorialCategoryDefaultSections()
    {
        return $this->tutorialCategoryDefaultSections;
    }

    /**
     * @param mixed $tutorialCategoryDefaultSections
     */
    public function setTutorialCategoryDefaultSections($tutorialCategoryDefaultSections)
    {
        $this->tutorialCategoryDefaultSections = $tutorialCategoryDefaultSections;
    }


}