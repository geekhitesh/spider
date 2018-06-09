<?php
/**
 * Created by PhpStorm.
 * User: buniyad
 * Date: 8/20/2017
 * Time: 4:30 PM
 */

namespace App\Http\Model;

use App;

use File;
use DB;
use \Cache;

class GenericGlobalTagsDAO
{

    public $genericGlobalTags;
    public function __construct()
    {
        $this->genericGlobalTags = new GenericGlobalTags();


    }

    public function insertAllTags($file_name)
    {
        $excel = App::make('excel');

        $website_name = "";

        $file_path = "public/generic_global_tags/";
        $excel->load($file_path.$file_name, function($reader) {

            $excelArray = $reader->toArray();
            if(is_array($excelArray))
            {
               $excelArray = $excelArray[0]; 
            }
            
            $row_counter = 0;

            foreach($excelArray as $row)
            {
                $row_counter++;

                $this->genericGlobalTags->website_name = strtolower($row['websitename']);
                $this->genericGlobalTags->page_name = strtolower($row['pagename']);
                $this->genericGlobalTags->page_url = $row['url'];
                $this->genericGlobalTags->tags = $row['metatags'];



                if(trim($this->genericGlobalTags->page_url) !="" && isset($this->genericGlobalTags->page_url))
				{					
					$status = $this->insertPage($this->genericGlobalTags);
					if($status == 1)
					{
					   echo "<br/> Record <b>".$this->genericGlobalTags->page_name."</b> is successfully inserted";

					}
					else if($status == 0)
					{
						echo "<br/> Record <b>".$this->genericGlobalTags->page_name."</b> is failed.";
						$row_counter--;
					}
				}
				else
				{
                     $row_counter--;
				}	
                

            }

            echo "<hr/><b align='center'>Total $row_counter pages are successfully inserted.</b>";
            


        });


        $this->buildWebsiteTagsCache($website_name);

    }


    public function insertPage(GenericGlobalTags $page)
    {
        $status = 0;


        try
        {
            DB::insert('insert into generic_global_tags(website_name,
                                                        page_name,
                                                        page_url,
                                                        tags) values(?,?,?,?)',[$page->website_name,
                                                                                $page->page_name,
                                                                                $page->page_url,
                                                                                $page->tags]
                        );

            $status = 1;

        }
        catch(\Illuminate\Database\QueryException $e)
        {
            $status = 0;
        }

        return $status;

    }

    public function getWebsiteTags($website_name)
    {

        $websiteTags = DB::select('select * from generic_global_tags where website_name = ?',[$website_name]);

        return($websiteTags);
    }

	
	private static function sortByLength($tag1,$tag2)
	{
		
       	$len1 = strlen($tag1);
	    $len2 = strlen($tag2)."<br/>";
		
		if($len1 == $len2) return 0;
		
		if($len1 > $len2)
			return -1;
		return 1;
	}
	
    public function buildWebsiteTagsCache($website_name)
    {
        $websitePages = DB::select('select * from generic_global_tags where website_name = ?',[$website_name]);
        $websiteTags = array();

        foreach($websitePages as $page)
        {

            $tags = explode(",",$page->tags);
            foreach($tags as $tag)
            {
                if(trim($tag)!='')
                    $websiteTags[trim($tag)] = $page->page_url;
            }
        }

       // var_dump($websiteTags);

	    uksort($websiteTags,array('App\Http\Model\GenericGlobalTagsDAO','sortByLength'));
		//var_dump($websiteTags);
        $cache_name = $website_name.'_websiteTags';
		
        Cache::put($cache_name,$websiteTags,365*24*60);
    }
	
	
	




    public function createLinkedContent($website_name,$content)
    {
        echo "<hr/><b>Original Content is:</b>"; 
        echo "<hr/>".$content;
        $linked_content = "";

        $urlMap = array();
        $regex = "~(\\<a href\\=[\\'\"][\\:a-zA-Z0-9\\-\\/\\.\\'\\ \">]+\\<\\/a\\>)~";

        //$regex = "~(\<a href\=\'[a-zA-Z0-9\-\/\.\'\ >]+\<\/a\>)~";
        $tagMap = $this->getAllTags($website_name);

        //var_dump($tagMap);
        $counter=0;
        foreach ($tagMap as $tag_name => $tag_url)
        {
            // echo "<br/>$tag_name - $tag_url";
            $tag_href = "<a href='".$tag_url."'>$tag_name</a>";

            //fetch all URLs, replace them in main content.

            preg_match_all($regex,$content,$matches);

            //var_dump($matches);

            foreach($matches[0] as $match)
            {
                if(!array_key_exists($match,$urlMap) && trim($match) != '')
                    $urlMap[$match] = 'URL_'.$counter ;
                $content = str_replace($match,$urlMap[$match],$content);
                $counter++;
            }

            $tag_name = strtolower(trim($tag_name));
            $tag = "~\b$tag_name\b~";
            $content = preg_replace( $tag,
                $tag_href,
                strtolower($content)
            );

        }

        $linked_content = $content;

                //var_dump($urlMap);
       // echo "<hr/><b>Intermediate Content is:</b>";
       // echo "<hr/>".$linked_content;

        echo "<hr/><b><u>Total Tags replaced: </u>". count($urlMap)."</b>";

        foreach($urlMap as $url=>$url_data)
        {
           // $linked_content = str_replace(strtolower($url_data),$url,$linked_content);
            $tag_name = strtolower(trim($url_data));
            $tag = "~\b$tag_name\b~";
            $linked_content = preg_replace( $tag,
                                            $url,
                                            $linked_content
                                           );

        }

        //var_dump($urlMap);
        echo "<hr/><b>Linked Content is:</b>";
        echo "<hr/>".$linked_content;
        return $linked_content;
    }


    public function getAllTags($website_name)
    {

        return Cache::get($website_name."_websiteTags");

    }

    public function deletePage($website_name,$page_id)
    {
        DB::delete("delete from generic_global_tags where page_id=?",[$page_id]);
        echo "Page - $page_id of website $website_name successfully deleted";

        $this->buildWebsiteTagsCache(trim($website_name));

    }

    public function deleteAllWebsitePage($website_name)
    {
        DB::delete("delete from generic_global_tags where website_name=?",[$website_name]);
        echo "All pages of $website_name successfully deleted";

        $this->buildWebsiteTagsCache(trim($website_name));

    }

}