@extends('layouts.app')



@section('content')

    <script src="https://cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>

    <!--<textarea name="editor1"></textarea>
    <textarea name="editor2"></textarea> -->

    <h1>Create Chapter For {{$chapterData[1]}}</h1>

    <h5> <i> {{$chapterData[2]}}  </i></h5>

    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>



    {!! Form::open(array('url' => 'admin/chapter', 'method' => 'post')) !!}

    <div class="form-group">
        {!! Form::label('Chapter Name') !!}
        {!! Form::text('tutorial_chapter_name', null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Chapter Name')) !!}
    </div>



    <div class="form-group">
        {!! Form::label('Chapter Description') !!}
        {!! Form::text('tutorial_chapter_desc', null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Chapter Description')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Select Chapter Group') !!}
        {!! Form::select('tutorial_chapter_group_name',$chapterData[5], null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Tutorial Chapter Group Name')) !!}
    </div>





    {!! Form::hidden('chapterSectionsName', $chapterData[3],
        array(null,
          'class'=>'form-control')) !!}


    {!! Form::hidden('tutorial_id', $chapterData[4],
    array(null,
      'class'=>'form-control')) !!}

  <div class="form-group">

      @foreach ($chapterData[0] as $section_name)
          {!! Form::label($section_name) !!}
            {!! Form::textarea(trim($section_name), null,
                array('required',
                      'class'=>'form-control',
                      'placeholder'=>$section_name)) !!}

            <br/>
        @endforeach

            <script>
               @foreach ($chapterData[0] as $section_name)
                 CKEDITOR.replace('{{trim($section_name)}}');
               @endforeach
            </script>

    </div>

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
