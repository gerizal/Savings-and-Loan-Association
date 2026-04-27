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
                    <li class="breadcrumb-item active">Jabatan</li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection
@section('title','Jabatan')
@section('content')
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <!-- /.box-header -->
        <!-- form start -->
        <div class="card-body">

        <form action="@yield('url', '/role')" method="post">
         {{csrf_field()}}
          @section('editMethod')
            @show
          <div class="form-group">
              <label class="control-label" for="first-name">Name <span class="required">*</span></label>
              <input type="text" data-validation="required" name="name" class="form-control" placeholder="Name" value="@yield('name')">
          </div>
          <div class="form-group">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Menu Lists</th>
                  <th class="non-user text-center">
                    <div class="checkbox checkbox-custom checkbox-primary" style="margin-top:0px !important;margin-bottom:0px !important;">
                      <label>
                        <input type="checkbox" onClick="toggle(this)" /> Select All<br/>
                      </label>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody>
              @php
                foreach($permissions as $data){
                   $access_id[]  = $data->id;
                   $access[]     = $data->access;  
                   $feature[]     = $data->feature;      
                }
                $data_id=(array_chunk($access_id,4));
                $data_access=(array_chunk($access,4));
                $data_feature=(array_chunk($feature,4));
                for($i=0; $i<count($data_id);$i++){
                  $label = $data_feature[$i][0];
                  $label_name = str_replace("_",' ',$label);  
                  echo '<tr>';
                  echo '<td><b>'.ucfirst($label_name).'</b></td>';
                  for($j=0; $j<count($data_id[$i]);$j++){
                    $display = $data_access[$i][$j];
                    $display_name =  explode("_", $display, 2);
                    if(isset($data_permission) && in_array($data_id[$i][$j],$data_permission)){
                      $checked = 'checked';
                    }
                    else{
                      $checked ='';
                    }
                    echo '<td>';
                    echo '<input id="permission" name="permission[]" '.$checked.' type="checkbox" value="'.$data_id[$i][$j].'">'.ucfirst($display_name[0]);
                    echo '</td>';
                  
                  }
                  echo '</tr>';

                }
                @endphp

              </tbody>
            </table>
          </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <button type="submit" id="checkBtn" class="btn btn-primary">Submit</button>
              <a href="/role" class="btn btn-danger">Back</a>
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
