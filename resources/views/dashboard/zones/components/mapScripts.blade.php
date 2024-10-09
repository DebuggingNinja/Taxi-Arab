<script>
    $(document).ready(function () {
        $("#toggleControlBox").click(function () {
            $("#toolbox-card").toggleClass('collapsed-toolbox', 500); // 500 is the duration in milliseconds

            $("#control-box").toggle();
            var newText = $(this).text() == "+" ? "—" : "+"; // Change the text accordingly

            $(this).text(newText);
        });
    });

    function clearPolygon() {
        $("#Clear_All_Poly_Button-btnInnerEl").click();
    }

    function savePolygon(){
        if($("#textareafield-1013-inputEl").val() == ''){
            alert(
                'ارسم المنطقه اولا'
            )
        }else{
            $("#component-1016").hide();
        $("#panel-1017").hide();
        $("#component-1031").hide();
        $("#coordinatesBox").hide();
        $("#toolbox-card").hide();
        $("#polygon_array").val($("#textareafield-1013-inputEl").val());
        $("#zone-card").show();
        }

    }

    function importPolygon(){
    $("#Import_Txt_Button-btnInnerEl").click();
        setTimeout(function() {
        // Code to be executed after a delay of 2 seconds

        $("#messagebox-1001-textarea-inputEl").val(`#Polygon_0
42.43278058732622, -71.59958349206543
42.424671389837506, -71.61932455041504
42.417765074322006, -71.6088532064209
42.41947588390665, -71.58773885705567
`);

        // Additional code to be executed after the click event
        // Add your desired actions here

        // For example, triggering another click event for button-1005-btnInnerEl
        $("#button-1005-btnInnerEl").click();

        // Add more actions as needed
    }, 0); // 2000 milliseconds = 2 seconds
    }


    $("#map_search").on('keydown', function(event) {
    // Set the value of #textfield-1009-inputEl to the value of the current input field
    $('#textfield-1009-inputEl').val($(this).val());

    // Check if the pressed key is Enter (key code 13)
    if (event.keyCode === 13) {
        // Trigger "Enter" key press in #textfield-1009-inputEl
        $('#textfield-1009-inputEl').trigger($.Event('keypress', { keyCode: 13 }));
        alert('');
        // Optionally prevent the default Enter key behavior in the current input field
        event.preventDefault();
    }
});


</script>