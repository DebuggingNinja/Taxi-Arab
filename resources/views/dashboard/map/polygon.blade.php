<!DOCTYPE html>
<html>

<head>
    <style>
        #panel-1017 {
            display: none;
            top: 0 !important;
        }

        #component-1031 {
            top: 0px !important;
        }

        #messagebox-1001 {
            display: none;
        }
    </style>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBE67dSC2tOcvHiXAewxiAmTnPMnTN9ueY&libraries=geometry">
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
    <title>Polygon Tool</title>
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
            top: 10px;
            transition-duration: 0.5s;
        }
    </style>

</head>

<body>
    <div class="container">
        <div id="toolbox-card" class="card">
            <div class="card-header justify-content-between m-0 py-0">
                <h3 class="card-title">الادوات</h3>
                <div class="card-actions btn-actions m-0">

                    <a href="#" class="btn-action" id="toggleControlBox">
                        —
                    </a>

                </div>
            </div>
            <div id="control-box" class="card-body">
                <button class="btn btn-primary" onclick="clearPolygon()">اعادة تعيين</button>
                <button class="btn btn-info" onclick="savePolygon()">حفظ المنطقه</button>
                <button class="btn btn-warning" onclick="importPolygon()">استرداد منطقه</button>
            </div>
        </div>
    </div>

</body>
<script src="{{ asset('dist/js/jquery-3.6.3.min.js') }}"></script>

</html>