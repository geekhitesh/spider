@extends('layouts.app')

@section('content')
    <h1>Create Tutorial</h1>

    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>



    {!! Form::open(array('url' => 'admin/tutorial', 'method' => 'post')) !!}

    <div class="form-group">
        {!! Form::label('Tutorial Name') !!}
        {!! Form::text('tutorial_name', null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'tutorial Name')) !!}
    </div>



    <div class="form-group">
        {!! Form::label('Parent Tutorial') !!}
        {!! Form::select('tutorial_parents',$tutorialData[2], null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Parent tutorial')) !!}
    </div>


    <div class="form-group">
        {!! Form::label('Tutorial Category') !!}
        {!! Form::select('tutorial_category_id',$tutorialData[1], null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Tutorial Category')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Tutorial Description') !!}
        {!! Form::text('tutorial_desc', null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Category Description')) !!}
    </div>


    <div class="form-group">
        {!! Form::label('Author Id') !!}
        {!! Form::text('author_id', '01054T',
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Author Id')) !!}
    </div>



    <div class="form-group">
        {!! Form::label('Default Sections') !!}
        {!! Form::text('default_tutorial_sections', null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Default Tutorial Sections (comma Seperated)')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Chapter Groups') !!}
        {!! Form::text('tutorial_chapter_groups', null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Chapter Groups (comma seperated)')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Share To Website') !!}
        {!! Form::select('share_to_website',array('true' => 'Yes', 'false' => 'No'), null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Share To Website')) !!}
    </div>





    <div class="form-group">
        {!! Form::label('Select Website') !!}
        {!! Form::select('website_id',$tutorialData[0], null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Select Website')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Enter Tags') !!}
        {!! Form::text('tags_cloud', null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Enter Tags (comma Seperated)')) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Create!',
          array('class'=>'btn btn-primary')) !!}
    </div>
    {!! Form::close() !!}
@endsection
