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
                <form action="" class="form-group formSubmit"  id="formSubmit">
                    <input type="text" class="form-control" value="{{auth()->user()->name ?? ''}}" placeholder="User Name"><br>
                    <input type="email" class="form-control" value="{{auth()->user()->email ?? ''}}" placeholder="Email"><br>
                    <input type="submit" value="Connect" class="form-control bg-primary text-white">
                </form>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        $(document).ready(function(){
            $('.formSubmit').on('click',function(e){
               e.preventDefault();
               const formData = new FormData(formSubmit)
                
               $.ajax({
                // url:"{{url('/facebook')}}"
               })

            })
        })
    </script>
@endpush
@endsection
