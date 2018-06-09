

<h1> All Pages</h1>


<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even){background-color: #f2f2f2}

        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>




<table>
    <th>Website Name</th>
    <th>Page Name</th>
    <th>Page URL</th>
    <th>Meta Tags</th>
    <th>Delete</th>
    @foreach ($genericGlobalTags as $page)
        <tr>
            <td>{{$page->website_name}}</td>
            <td>{{$page->page_name}}</td>
            <td>{{$page->page_url}}</td>
            <td>{{$page->tags}}</td>
            <td><a href="{{$page->website_name}}/delete/{{$page->page_id}}">Delete</a></td>
            <td></td>

        </tr>



    @endforeach

</table>