<?php
/**
 * Created by PhpStorm.
 * User: buniyad
 * Date: 8/20/2017
 * Time: 12:34 AM
 */


echo Form::open(array('url' => '/admin/generic-global-tags','files'=>'true'));
echo 'Select the file to upload.';
echo Form::file('global_tags_excel');
echo Form::submit('Upload File');
echo Form::close();