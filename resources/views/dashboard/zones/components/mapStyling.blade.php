<style>
    #panel-1017 {
        display: none;
        top: 0 !important;
    }



    #messagebox-1001 {
        display: none;
    }

    #zone-card {
        display: none;
    }

    #component-1031 {
        z-index: 1000;
        top: 60px !important;
    }
</style>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBE67dSC2tOcvHiXAewxiAmTnPMnTN9ueY&libraries=geometry">
</script>
<link href="{{ asset('dist/css/tabler.rtl.min.css') }}" rel="stylesheet">
<script>
    if (typeof google !== 'object' && typeof google.maps !== 'object') {
        document.write('<script src="http://maps.google.cn/maps/api/js?key=AIzaSyBE67dSC2tOcvHiXAewxiAmTnPMnTN9ueY&libraries=geometry" type="text/javascript"><\/script>');
    }
</script>
<link rel="stylesheet" type="text/css" href="
    {{ asset('css/ext-all.css') }}" />
<script type="text/javascript" src="{{ asset('js/ext-all.js') }}">
</script>
<script src="{{ asset('js/common.js') }}">
</script>

<meta charset="utf-8">
<style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    #mapC {
        height: 100%;
    }

    .collapsed-toolbox {
        width: 110px;
        position: absolute;
        right: 65px;
        top: 110px !important;
        transition-duration: 0.5s;
    }

    #toolbox-card {
        z-index: 1001;
        top: 10px;
    }
</style>