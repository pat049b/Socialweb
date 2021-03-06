@extends('layouts.master')

@section('title')
    All Categories
@endsection

@section('content')
    @include('includes.message-block')
    <div class="row">
        <div class="col-md-8">
            <h1>Categories</h1>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $categories as $category)
                <tr>
                    <th>{{ $category->id }}</th>
                    <td>{{ $category->name }}</td>
                    <td><a href="{{ route('category.delete', ['category_id'=> $category->id]) }}" class="glyphicon glyphicon-trash"></a></td>
                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-3">
            <div class="well">
                {!! Form::open(['route'=>'categories.store', 'method'=>'POST']) !!}
                <h2>New Category</h2>
                {{ Form::label('name', 'Name:') }}
                  {{ Form::text('name', null, ['class' => 'form-control']) }}
                {{ Form::submit('Create New Category', ['class'=> 'btn btn-primary btn-block btn-space']) }}
                {!! Form::close() !!}
            </div>
        </div>

    </div>

@endsection