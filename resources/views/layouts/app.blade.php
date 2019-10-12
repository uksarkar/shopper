<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="author" content="Bootstrap-ecommerce by Vosidiy">

<title>@yield('title', $site_name) </title>

<link rel="shortcut icon" type="image/x-icon" href="{{ $favicon }}">

<!-- jQuery -->
<script src="{{ asset('js/jquery-2.0.0.min.js') }}" type="text/javascript"></script>
<!-- Bootstrap4 files-->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>

<!-- Font awesome 5 -->
<link href="{{ asset('fonts/fontawesome/css/fontawesome-all.min.css') }}" type="text/css" rel="stylesheet">
@if(Route::is('dynamic'))
    <!-- plugin: fancybox  -->
    <script src="{{ asset('plugins/fancybox/fancybox.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('plugins/fancybox/fancybox.min.css') }}" type="text/css" rel="stylesheet">
@endif

<!-- plugin: owl carousel  -->
<link href="{{ asset('plugins/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
<link href="{{ asset('plugins/owlcarousel/assets/owl.theme.default.css') }}" rel="stylesheet">
<script src="{{ asset('plugins/owlcarousel/owl.carousel.min.js') }}"></script>

<!-- custom style -->
<link href="{{ asset('css/ui.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/responsive.css') }}" rel="stylesheet" media="only screen and (max-width: 1200px)" />

@if(session()->has("successMassage") || $errors->count() > 0)
    <link rel="stylesheet" href="{{ asset("css/iziToast.min.css") }}">
@endif

<!-- custom javascript -->
<script src="{{ asset('js/script.js') }}" type="text/javascript"></script>

<style>
    .addProduct{
        position: relative;
        margin-bottom: -30px;
        z-index: 9;
    }
</style>
</head>
<body>
    @yield('content')
    @if(session()->has("successMassage") || $errors->count() > 0)
        <script src="{{ asset("js/iziToast.min.js") }}"></script>
    @endif
    <script type="text/javascript">
        $(document).ready(function(){
            var request = function(product_id){
                // Variable to hold respons data
                var reqData;
                // Variable to hold request
                var request;
                // Abort any pending request
                if (request) {
                    request.abort();
                }

                $('#SubForm .form-group').first().find('span.input-group-text').html(`<i class="fa fa-circle-notch fa-spin"></i> Shop`);
                $('#SubForm').find("input, select, button, textarea").attr('disabled',true);
                $('#subBtn').attr('disabled',true);

                // Fire off the request to /form.php
                request = $.ajax({
                    url: "/account/getShops",
                    type: "get",
                    data: {product_id}
                });

                // Callback handler that will be called on success
                request.done(function (response, textStatus, jqXHR){

                    //lets create the options from the data
                    let theFormOption = $('#shop_options');
                    theFormOption.html(`<option vlaue="0">All Shops</option>`);
                    response.forEach(function(data) {
                        theFormOption.append(`<option value="${data.id}">${data.name}</option>`);
                    });

                    //lets enable all the feilds 
                    $('#SubForm').find("input, select, button, textarea").removeAttr('disabled');
                    $('#subBtn').removeAttr('disabled');
                });

                // Callback handler that will be called on failure
                request.fail(function (jqXHR, textStatus, errorThrown){
                    $('#SubForm').parent().first().find('p.alert').remove();
                    $('#SubForm').parent().prepend(`
                        <p class="alert alert-warning">
                            ${textStatus, errorThrown}
                        </p>
                    `);
                    // Log the error to the console
                    console.error(
                        "The following error occurred: "+
                        textStatus, errorThrown
                    );
                });

                // Callback handler that will be called regardless
                // if the request failed or succeeded
                request.always(function () {
                    $('#SubForm .form-group').first().find('span.input-group-text').html('Shop');
                });
            }

            $('.addProductBtn').click(function(){
                let product_id = $(this).data().id,
                    product_input = $("#SubForm").find("input[name=product]");
                product_input.val(product_id);

                let img = $(this).parent().parent().find("img").attr("src"),
                    name = $(this).parent().parent().find("a").text();
                    
                $("#model-product-img").html(`
                    <img src="${img}" style="max-height: 200px; max-width: 100%;">
                `);

                $("#model-product-name").html(name);

                request(product_id);
            });

            $('#subBtn').click(function(e){
                e.preventDefault();
                $(this).html(`
                    <i class="fa fa-circle-notch fa-spin"></i> Saving...
                `);
                $("#SubForm").submit();
                $('body').find("input, select, button, textarea").attr('disabled',true);
            });

            $(".subbtn").on('click', function(){
                let id = $(this).data("sub");

                $("form[data-sub="+id+"]").submit();
            });


            //Errors and success massage handaling

            @if($errors->count() > 0)
                @foreach($errors->all() as $error)
                    iziToast.warning({
                        timeout: false,
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX',
                        title: 'Caution',
                        message: "{{ $error }}",
                    });
                @endforeach
            @endif

            @if(session()->has("successMassage"))
                iziToast.success({
                    timeout: 10000,
                    title: 'OK',
                    message: '{{ session()->get("successMassage") }}',
                });
            @endif
        
        });
    </script>
</body>
</html>
