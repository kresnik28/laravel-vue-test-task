@extends('layouts.app')
@section('title', 'Add products')
@section('content')
    <product-form :required-cols='@json($requiredCols)'></product-form>
@endsection
