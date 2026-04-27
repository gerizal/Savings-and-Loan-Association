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
                    <li class="breadcrumb-item"><a href="{{route('role.index')}}">Pengaturan Pengguna</a></li>
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
            {!! Form::model($data, $form) !!}
                <div class="form-group required @error('first_name') has-danger @enderror">
                    {!! Form::label('Nama', null, ['class' => 'control-label']) !!}
                    {!! Form::text('name', null, ['class' => "form-control".($errors->has('name') ? ' is-invalid' : ''), 'id'=>'name','placeholder'=>'Nama Jabatan/Role']) !!}
                    @if($errors->has('name'))
                        <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                    @endif
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
                        foreach($permissions_group as $feature_name => $data){
                            $label = $feature_name;
                            $label_name = str_replace("_",' ',$label);
                            echo '<tr>';
                            echo '<td><b>'.ucfirst($label_name).'</b></td>';
                            foreach($data as $value){
                                $display_name = str_replace("_",' ',$value->access);
                                echo '<td>';
                                echo '<input id="permission" name="permission[]" '.$value->checked.' type="checkbox" value="'.$value->id.'">'.ucfirst($display_name);
                                echo '</td>';
                            }
                            $last_column = count($data)-1;
                            for ($i=$last_column; $i < $max_column ; $i++) {
                                echo '<td></td>';
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
            {!! Form::close() !!}
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
