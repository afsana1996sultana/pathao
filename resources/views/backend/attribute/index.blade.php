@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<section class="content-main">
    <div class="content-header">
        <h3 class="content-title">Attribute list <span class="badge rounded-pill alert-success"> {{ count($attributes) }}</span></h3>
        <div>
            @if(Auth::guard('admin')->user()->role !== '5' || in_array('14', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
               <a href="{{ route('attribute.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i>Attribute Create</a>
            @endif
        </div>
    </div>
    </div>
    <div class="card mb-4 col-10 mx-auto">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">Name</th>
                            <th scope="col">Value</th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attributes as $key => $attribute)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td> {{ $attribute->name ?? 'NULL' }} </td>

                            <td>
                            @foreach($attribute->attribute_values as $value)
                                 {{ $value->value ?? 'NULL' }} ,
                            @endforeach
                            </td>
                            <td class="text-end">
                                @if(Auth::guard('admin')->user()->role == '1')
                                <a href="{{ route('attribute.show',$attribute->id) }}" class="btn btn-md rounded font-sm">Detail</a>
                                @endif
                                @if(Auth::guard('admin')->user()->role != '2')
                                    <div class="dropdown">
                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm"> <i class="material-icons md-more_horiz"></i> </a>
                                        <div class="dropdown-menu">
                                            @if(Auth::guard('admin')->user()->role == '1' || in_array('15', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                                              <a class="dropdown-item" href="{{ route('attribute.edit',$attribute->id) }}">Edit info</a>
                                            @endif
                                            @if(Auth::guard('admin')->user()->role == '1' || in_array('16', json_decode(Auth::guard('admin')->user()->staff->role->permissions)))
                                              <a class="dropdown-item text-danger" href="{{ route('attribute.delete',$attribute->id) }}" id="delete">Delete</a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                <!-- dropdown //end -->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- table-responsive //end -->
        </div>
        <!-- card-body end// -->
    </div>
</section>

@endsection