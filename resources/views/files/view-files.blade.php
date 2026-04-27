@extends('layouts.base-template')
@section('content')
<div class="container-fluid" style="margin-top:30px">
    <div class="row">
        <div class="col-md-12">
            @include('partials.document-files', ['documents'=>$documents])
        </div>
    </div>
</div>
@endsection
