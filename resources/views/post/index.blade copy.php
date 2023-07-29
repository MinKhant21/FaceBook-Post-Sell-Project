@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-9">
            <h1>Post</h1>
        </div>
        <div class="col">
            <a href="" class="btn btn-sm btn-primary">Add Post</a>
        </div>
    </div>
    <hr>
    <table id="datatable" class="table table-striped datatable">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Messages</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>
@push('script')
    <script>
        $( document ).ready(function(){
            $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                bPaginate: true,
                ajax: {
                    'url': "{{ url('getall') }}",
                    'type': 'POST',
                    'data': function (d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', "orderable": false},
                    {data: 'image'},
                    {data: 'name'},
                    {data: 'message'},
                    {data: 'status'},
                    {data: 'action', orderable: false, 'width':'15%'},
                ]
            })
        })
    </script>
@endpush
@endsection
