@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">E-Presensi</div>
    <div class="right"></div>
</div>
<!-- App Header -->
<style>
    .webcam-capture,
    .webcam-capture video {
        display: inline-block;
        width: 100% !important;
        margin: auto;
        height: auto !important;
        border-radius: 15px;
    }
</style>
@endsection
@section('content')
<div class="row" style="margin-top: 70px">
   <div class="col">
        <input type="text" id="lokasi">
        <div class="webcam-capture"></div>
   </div>
</div>
@endsection

@push('myscript')
<script>
Webcam.set({
    height:480,
    width:640,
    image_format:'jpeg',
    jpeg_quality: 80
});
Webcam.attach('.webcam-capture');
var lokasi = document.getElementById('lokasi');
if(navigator.geolocation){
    navigator.geolocation.getCurrentPosition(successCalback, errorCalback);
}

</script>
@endpush