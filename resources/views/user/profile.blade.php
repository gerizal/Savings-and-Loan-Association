@extends('layouts.template')
@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Profile</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Profile Pengguna</a></li>
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
<div class="container-fluid">
   <div class="row">
      <div class="col-md-3">
         <div class="card card-primary card-outline">
            <div class="card-body box-profile">
               <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="{{ photo_user() }}" alt="User profile picture">
               </div>
               <h3 class="profile-username text-center">{{$profile->name}}</h3>
               <p class="text-muted text-center">{{$profile->email}}</p>
            </div>
         </div>
      </div>
      <div class="col-md-9">
         <div class="card">
            <div class="card-header p-2">
               <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#edit_profile" data-toggle="tab">Ganti Profil</a></li>
                  <li class="nav-item"><a class="nav-link " href="#edit_password" data-toggle="tab">Ganti Password</a></li>
               </ul>
            </div>
            <div class="card-body">
               <div class="tab-content">
                  <div class="active tab-pane" id="edit_profile">
                     <form class="form-horizontal" method="post" action="{{route('user.update.profile',$profile->id)}}">
                     {{csrf_field()}}
                        <div class="form-group row">
                           <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                           <div class="col-sm-10">
                              <input type="text" class="form-control" id="inputName" name="name" placeholder="Name" value="{{$profile->name}}">
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                           <div class="col-sm-10">
                              <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" value="{{$profile->email}}">
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="offset-sm-2 col-sm-10">
                              <button type="submit" class="btn btn-primary">Save</button>
                           </div>
                        </div>
                     </form>
                  </div>
                  <div class="tab-pane" id="edit_password">
                     <form class="form-horizontal">
                        <div class="form-group row">
                           <label for="inputName" class="col-sm-2 col-form-label">Current Password</label>
                           <div class="col-sm-10">
                              <input type="password" class="form-control" id="current_password">
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="inputEmail" class="col-sm-2 col-form-label">New Password</label>
                           <div class="col-sm-10">
                              <input type="password" class="form-control" id="password1">
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="inputName2" class="col-sm-2 col-form-label">Confirm Password</label>
                           <div class="col-sm-10">
                              <input type="password" class="form-control" id="password2" >
                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="offset-sm-2 col-sm-10">
                              <button type="submit" class="btn btn-primary">Save</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@push('script')
<script>
    
</script>
@endpush
