<?php
/**
 * Created by PhpStorm.
 * User: buniyad
 * Date: 8/5/2017
 * Time: 11:33 PM
 */

namespace App\Http\Model;

use DB;

class InterLinking
{


    public function generateLinks(Chapter $chapter)
    {
        echo "Original Content is:". $chapter->chapter_content;
        $linked_content = "";

        $urlMap = array();
        //$regex = "~(\\<a href\\=\\'[a-zA-Z0-9\\-\\/\\.\\'\\ >]+\\<\\/a\\>)~";

        $regex = "~(\<a href\=\'[a-zA-Z0-9\-\/\.\'\ >]+\<\/a\>)~";
        $tagList = $this->getAllTags($chapter->category_id);

        //var_dump($tagList);
        $tagMap = array();

        //prepare tag map and remove repetitive entries.
        foreach ($tagList as $tag)
        {
            $tagMap[trim($tag->tag_name)] = $tag->tag_url;
        }

        var_dump($tagMap);


        $content = $chapter->chapter_content;
        $counter=0;
        foreach ($tagMap as $tag_name => $tag_url)
        {
           // echo "$tag_name - $tag_url";
            $tag_href = "<a href='".$tag_url."'>$tag_name</a>";

            //fetch all URLs, replace them in main content.

            preg_match_all($regex,$content,$matches);

            var_dump($matches);

            foreach($matches[0] as $match)
            {
                 if(!array_key_exists($match,$urlMap))
                 $urlMap[$match] = 'URL_'.$counter ;
                 $content = str_replace($match,$urlMap[$match],$content);
               // $content = preg_replace($match,$urlMap[$match],$content);
                 $counter++;
            }

           // $tag = ""
           /* $content = str_replace(strtolower(trim($tag_name)),
                                                     $tag_href,
                                                     strtolower($content)
                                                    ); */

            $tag_name = strtolower(trim($tag_name));
            $tag = "~\b$tag_name\b~";
            $content = preg_replace( $tag,
                                    $tag_href,
                                    strtolower($content)
                                   );

        }

        $linked_content = $content;

        echo "Content after interlinking".$linked_content;

        foreach($urlMap as $url=>$url_data)
        {
            $linked_content = str_replace(strtolower($url_data),$url,$linked_content);
        }

        var_dump($urlMap);
        echo $linked_content;
        return $linked_content;
    }


    public function getAllTags($category_id)
    {
        $tagList = DB::select('select tag_name,tag_url from global_tags where tutorial_category_id=?',[$category_id]);

        return ($tagList);

    }

}