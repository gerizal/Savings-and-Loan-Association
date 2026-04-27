@extends('user.create')
@section('editId',$user->id)
@section('name',$user->name)
@section('email',$user->email)
@section('url','/user/'.$user->id)
@section('editMethod')
  {{method_field('PUT')}}
@endsection