@extends('layouts.template')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pengaturan Pengguna</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Pengaturan Pengguna</a></li>
                    <li class="breadcrumb-item active">Pengguna</li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection
@section('title','Pengguna')
@section('content')
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <!-- /.box-header -->
        <!-- form start -->
        <div class="card-body">

        <form action="@yield('url', '/user')" method="post">
        {{csrf_field()}}
          @section('editMethod')
            @show
            <div class="box-body">
              <div class="form-group">
                <div class="col-md-12">
                  <label for="name">Full Name <span class="required">*</span></label>
                  <input type="text" name="name"  required="required"  class="form-control" placeholder="Name" value="@yield('name')">
                </div>
              </div>
              <div class="form-group">
                  <div class="col-md-12">
                    <label for="email">Email Address <span class="required">*</span> </label>
                    <input name="email" type="email" required="required"  class="form-control" id="email" placeholder="Enter email" value="@yield('email')" @yield('readonly', 'true')>
                  </div>
                </div>
              <div class="form-group">
                <div class="col-md-12">
                  <label for="role">Role</label>
                  <select name="role_id"  id="role_id" class="form-control">
                    @foreach( $roles as $key => $role )
                      <option value="{{ $key }} " {{$__env->yieldContent('role') == $key ? "selected" : ""}}>{{ $role }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
           </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('script')
<script>
    function toggle(source) {
        checkboxes = document.getElementsByName('permission[]');
        for(var i=0, n=checkboxes.length;i<n;i++) {
        checkboxes[i].checked = source.checked;
        }
    }
</script>
@endpush
