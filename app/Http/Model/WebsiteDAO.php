<?php
/**
 * Created by PhpStorm.
 * User: hiteshah
 * Date: 7/25/2017
 * Time: 2:09 PM
 */

namespace App\Http\Model;

use DB;

class WebsiteDAO
{

    public function getWebsite()
    {

    }

    public function getWebsiteList()
    {
        $websiteList = DB::select('select * from website where expiration_date is null');

        return $websiteList;
    }

    public function insertWebsite($website)
    {
        DB::insert('insert into website (website_name) values(?)',[$website->name]);
    }

    public function updateWebsite($website)
    {
        DB::update('update website 
                    set website_name = ?,
                        website_desc = ?,
                        expiration_date = ?
                    where website_id = ? ',[$website->name,$website->desc,$website->expiration_date,$website->website_id]);
    }


    public function deleteWebsite($website)
    {
        DB::delete('delete from website where website_id = ?',[$website->website_id]);
    }
}