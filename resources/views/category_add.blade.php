@extends('layouts.app')

@section('content')
    <h1>Create Category</h1>

    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>



    {!! Form::open(array('url' => 'admin/category', 'method' => 'post')) !!}

    <div class="form-group">
        {!! Form::label('Category Name') !!}
        {!! Form::text('category_name', null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Category Name')) !!}
    </div>



    <div class="form-group">
        {!! Form::label('Parent Category') !!}
        {!! Form::select('category_parents',$categoryData[1], null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Parent Category')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Category Description') !!}
        {!! Form::text('category_description', null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Category Description')) !!}
    </div>




    <div class="form-group">
        {!! Form::label('Share To Website') !!}
        {!! Form::select('share_to_website',array('true' => 'Yes', 'false' => 'No'), null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'Share To Website')) !!}
    </div>



    <div class="form-group">
        {!! Form::label('Select Websites') !!}

        <br/>
        @foreach ($categoryData[0] as $website)
            {{--print_r($website)--}}
            {{--$website['name']--}}
            {!! Form::checkbox('websites[]', $website['website_id'])!!}
            {!! Form::label($website['website_name'])!!}
            <br/>
        @endforeach



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
