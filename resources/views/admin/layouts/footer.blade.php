<!-- CoreUI and necessary plugins-->
<script src="{{ asset("assets/vendors/jquery/js/jquery.min.js") }}"></script>
<script src="{{ asset("assets/vendors/popper.js/js/popper.min.js") }}"></script>
<script src="{{ asset("assets/vendors/bootstrap/js/bootstrap.min.js") }}"></script>
<script src="{{ asset("assets/vendors/pace-progress/js/pace.min.js") }}"></script>
<script src="{{ asset("assets/vendors/perfect-scrollbar/js/perfect-scrollbar.min.js") }}"></script>
<script src="{{ asset("assets/vendors/@coreui/coreui/js/coreui.min.js") }}"></script>
@if(Route::is('admin'))
    <!-- Plugins and scripts required by this view-->
    <script src="{{ asset("assets/vendors/chart.js/js/Chart.min.js") }}"></script>
    <script src="{{ asset("assets/vendors/@coreui/coreui-plugin-chartjs-custom-tooltips/js/custom-tooltips.min.js") }}"></script>
    <script src="{{ asset("assets/js/main.js") }}"></script>
@endif
@if(Route::is('config.headerCustomization'))
    <script src="{{ asset('assets/js/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/jquery.nestable.plus.js') }}" type="text/javascript" defer></script>
@endif
@if(Route::is("products.create") || Route::is("products.edit") || Route::is("users.create") || Route::is("users.edit") || Route::is("shops.create") || Route::is("shops.edit"))
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });

        $(document).ready(function(){
            $("#deletesubmit").click(function(e){
                e.preventDefault();
                $(this).prop('disabled', true);
                $("#deleteform").submit();
            });
            $("form").submit(function(e) {
                // submit more than once return false
                $(this).submit(function(e) {
                    e.preventDefault();
                });
                // submit once return true
                $(".submitButton").prop('disabled', true);
            });
        });
    </script>
@endif
@if(Route::is("products.show") || Route::is("products.index"))
    <script>
        $(document).ready(function() {
            $(".subbtn").click(function(){
                $(".formsub").submit();
                $(this).prop("disabled", true);
            });
        });
    </script>
@endif
<script>
    $(document).ready(function() {
        $("#productSub").click(function(){
            $("#SubForm").submit();
            $(this).prop("disabled", true);
        });
        let email_input = $("#login-email");
        function emailCheck() {
            let email = email_input.val();
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if(regex.test(email)) {
                email_input.removeClass('is-invalid');
                email_input.addClass('is-valid');
            }else{
                email_input.removeClass('is-valid');
                email_input.addClass('is-invalid');
            }
        }
        email_input.on('input', emailCheck);

        //submitting form from list

        $(".subbtn").click(function () {
            let subForm = $(this).data().sub;
            $('.formsub[data-sub='+subForm+']').submit();
            $(this).prop('disabled', true);
        })

        //Show and hiding price edit form

        $(".formShowBtn").click(function () {
            let editForm = $(this).data().edit;
            $("tr[data-tr="+editForm+"]").hide();
            $("tr[data-edit="+editForm+"]").fadeIn();
        })

        $(".xbtn").click(function () {
            let editForm = $(this).data().edit;
            $("tr[data-tr="+editForm+"]").fadeIn();
            $("tr[data-edit="+editForm+"]").hide();
        })

        //Generating random data on form and submit it

        $(".sButton").click(function () {
            $(this).prop('disabled', true);
            let editArea = $(this).data().info;
            let id = editArea.replace('e','');
            let amounts = $('input[data-info='+editArea+']').val();
            let description = $('textarea[data-info='+editArea+']').val();
            let form = $('#edit-form-bottom');
            form.children('input[name=amounts]').val(amounts);
            form.children('textarea[name=description]').html(description);
            form.prop('action','/price/'+id);
            form.submit();
        })
        //Menu Customizer
        @if(Route::is('config.headerCustomization'))
        $('.dd.nestable').nestable({
            maxDepth: 2
        })
        .on('change', updateOutput);
        $('#savePM').click(function(){
            $('#resText').show().html("<span class='text-warning'>Sending.....</span>");
            $('#animiLine').show();
            $('#overlay').show();
            // Variable to hold request
            var request;
            // Abort any pending request
            if (request) {
                request.abort();
            }
            // setup some local variables
            var $form = $('.form-group');

            // Let's select and cache all the fields
            var $inputs = $form.find("input, select, button, textarea");

            // Let's disable the inputs for the duration of the Ajax request.
            // Note: we disable elements AFTER the form data has been serialized.
            // Disabled form elements will not be serialized.
            $inputs.prop("disabled", true);

            // Fire off the request to /form.php
            request = $.ajax({
                url: "/api/menu",
                type: "post",
                contentType: "application/json; charset=utf-8",
                data: sendData
            });

            // Callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR){
                $('#resText').html("<span class='text-success'><i class=\"fa fa-check\" aria-hidden=\"true\"></i> Saved</span>").delay(1000).fadeOut();
            });

            // Callback handler that will be called on failure
            request.fail(function (jqXHR, textStatus, errorThrown){
                $('#resText').html("<span class='text-danger'>Error.....</span>");
                // Log the error to the console
                console.error(
                    "The following error occurred: "+
                    textStatus, errorThrown
                );
            });

            // Callback handler that will be called regardless
            // if the request failed or succeeded
            request.always(function () {
                // Reenable the inputs
                $inputs.prop("disabled", false);
                $('#animiLine').hide();
                $('#overlay').hide();
            });
        });
        @endif
        //end menu customizer

    });
</script>
