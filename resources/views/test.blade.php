@extends('layouts.app')

@section('content')
    @include('helpers.header')

    <div class="container">
        <div class="content-justify-center">
            <div class="card my-5">
                <div class="card-header">Test</div>
                <div class="card-body">
                    <form action="/test" method="post" class="metaform">
                        @csrf

                        <input type="hidden" name="productMeta">

                        <div class="plusItem">
                            <div class="list-group-item" data-status="0" data-id="1">
                                <button class="close meta_close" type="button" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <input class="form-control plusName" type="text" name="meta_name"  placeholder="Meta Name">
                                <input class="form-control plusData" type="text" name="meta_data"  placeholder="Meta Text">
                            </div>
                        </div>

                        <button id="plus" type="button"><i class="fa fa-circle-notch fa-spin"></i> one</button>
                        <button id="sub" type="submit">sub</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            let meta_count = 1;
            var meta_data = [];
            var el_parent = [];
            $('#plus').click(function(e){
                e.preventDefault();
                let el = $(".plusItem");
                el.append(`
                    <div class="list-group-item" data-id="new-${meta_count}" data-status="create">
                        <button class="close meta_close" type="button" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <input class="form-control plusName" type="text" name="meta_name" placeholder="Meta Name">
                        <input class="form-control plusData" type="text" name="meta_data" placeholder="Meta Text">
                    </div>
                `);
                $('#sub').on("click", getParentElement);
                $('.list-group-item .meta_close').on("click", removeDiv);
                meta_count++;
            });
            $('#sub').click(function(e){
                e.preventDefault();
                getParentElement();
                let i = 0;
                el_parent.each(function(){
                    let name = el_parent[i].children[1].value,
                        data = el_parent[i].children[2].value,
                        status = el_parent[i].dataset.status,
                        id = el_parent[i].dataset.id;
                        
                    if(name != '' && data != ''){
                        meta_data.push({'id': id, 'name': name, 'data':data, 'status': status});
                    }

                    i++;
                });

                console.log(meta_data);
                // request(window.JSON.stringify(meta_data));

                // e.target.form.submit();
            })
            var getParentElement = function(){
                el_parent = $('.plusItem').find('div.list-group-item');

                // console.log(el_parent);
            }
            var request = function(meta_data){
                // Variable to hold request
                var request;
                // Abort any pending request
                if (request) {
                    request.abort();
                }

                let token = $('input[name=_token]').val();

                // Fire off the request to /form.php
                request = $.ajax({
                    url: "/admin/cache_meta",
                    type: "post",
                    headers: {
                        "X-Requested-With":"XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    contentType: "application/json; charset=utf-8",
                    data: meta_data
                });

                // Callback handler that will be called on success
                request.done(function (response, textStatus, jqXHR){
                    console.log(response);
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
                    //in leter
                });
            }

            $(".meta_close").click(function(){
                removeDiv();
            });

            var removeDiv = function() {
                if($(this)[0] != window) {
                    let target = $(this).parent();

                    if(target.data().status == 0) {
                        target.attr('data-status','delete');
                        // meta_data.push({id: target.data().id, status: 'delete'});
                        target.hide();
                    } else {
                        target.remove();
                    }
                }
            }

            $(function(){
                $('.list-group-item .meta_close').on("click", removeDiv);
            });

            //end of the document ready
        });
    </script>


    @include('helpers.footer')
@endsection