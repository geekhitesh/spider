
<h1> Get Linked Content For {{$website_name}} </h1>
<script src="https://cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>



{!! Form::open(array('url' => 'admin/generic-global-tags/website/get-content', 'method' => 'post')) !!}

<div class="form-group">
    {!! Form::label('Enter content to be linked') !!}
    {!! Form::textarea('content', null,
        array('required',
              'class'=>'form-control',
              'placeholder'=>'content')) !!}
</div>


{!! Form::hidden('website_name', $website_name,
    array(null,
      'class'=>'form-control')) !!}

<div class="form-group">
    {!! Form::submit('Create!',
      array('class'=>'btn btn-primary')) !!}
</div>

<script>
    CKEDITOR.replace('content');
</script>

