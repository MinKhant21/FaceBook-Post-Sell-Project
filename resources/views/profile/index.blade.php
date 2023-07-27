@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            {{-- <img src="{{asset('kaung.jpeg')}}" alt=""> --}}
            <img src="{{asset('kaung.jpeg')}}" alt="">
            <div>
                <h3>{{auth()->user()->name ?? ''}}</h3>
                <span>{{auth()->user()->email ?? ''}}</span>
            </div>
        </div>
        <div class="col">
            <div class="container flex">
                <form action="{{route('profile.store')}}" class="form-group formSubmit"  enctype="multipart/form-data">
                    @csrf
                    <input type="text" class="form-control" name="name" value="{{auth()->user()->name ?? ''}}" placeholder="User Name"><br>
                    <input type="email" class="form-control" name="email" value="{{auth()->user()->email ?? ''}}" placeholder="Email"><br>
                    <input type="submit" value="Connect" class="form-control bg-primary text-white">
                    <span class="submitspinner"></span>
                </form>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        $(document).ready(function(){
            $('.formSubmit').on('click',function(e){
            //    e.preventDefault();
            //    const formData = new FormData(formSubmit)
                
               $.ajax({
                url:$(this).attr('action'),
                data:new FormData(this),
                type:'POST',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend:function(){
                    $('.submitspinner').html('<i class="fa fa-spinner fa-spin"></i>')
                },
                success:function(data){
                    $('.submitspinner').html('');
                    if(data.status == 200)
                    {
                        // for Handle Reload 

                        // window.location.reload();
                        // $.confirm({
                        //     title: 'Success!',
                        //     content: data.msg,
                        //     // autoClose: 'cancelAction|3000',
                        //     buttons: {
                        //         cancelAction: function (e) {}
                        //     }
                        // });
                    }

                    if (data.status==400) {
                        $.alert({
                            title: 'Success!',
                            content: data.msg,
                        });
                    }
                }
               })

            })
        })
    </script>
@endpush
@endsection
