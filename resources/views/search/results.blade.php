@extends('layout')

@section('content')

    <div class="container">

    <div class="starter-template">
        <h1>Search</h1>
        <form action="?" method="get" class="form">
            <div class="form-group">
                <input class="form-control" type="text" required value="{{$term}}" name="q">
            </div>
            <button class="btn btn-primary" type="submit">Search</button>
        </form>

        @foreach($results as $result)
            <article>
                {!! $result->short !!} <abbr>{{$result->relevance}}</abbr>
            </article>
        @endforeach
    </div>

</div><!-- /.container -->
@endsection