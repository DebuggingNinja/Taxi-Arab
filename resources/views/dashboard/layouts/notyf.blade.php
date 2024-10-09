@if (session('Success'))
<script>
    const notyf = new Notyf();
        notyf.success({
            message: "{{ session('Success') }}",
            duration: 40000,
            dismissible:true,
            ripple:true,
            position:{
                x:'center',
                y:'top'
            }
        })
</script>
@endif
@if (session('Error'))
<script>
    const notyf = new Notyf();
        notyf.error({
            message: "{{ session('Error') }}",
            duration: 40000,
            dismissible:true,
            ripple:true,
            position:{
                x:'center',
                y:'top'
            }
        })
</script>
@endif


@if ($errors->any())

@foreach ($errors->all() as $error)
<script>
    const notyf = new Notyf();
            notyf.error({
                message: '{{ $error }}',
                duration: 40000,
                dismissible:true,
                ripple:true,
                position:{
                    x:'center',
                    y:'top'
                }
            })
</script>
@endforeach

@endif
