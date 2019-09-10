<!-- CoreUI and necessary plugins-->
<script src="{{ asset("assets/vendors/jquery/js/jquery.min.js") }}"></script>
<script src="{{ asset("assets/vendors/popper.js/js/popper.min.js") }}"></script>
<script src="{{ asset("assets/vendors/bootstrap/js/bootstrap.min.js") }}"></script>
<script src="{{ asset("assets/vendors/pace-progress/js/pace.min.js") }}"></script>
<script src="{{ asset("assets/vendors/perfect-scrollbar/js/perfect-scrollbar.min.js") }}"></script>
<script src="{{ asset("assets/vendors/@coreui/coreui/js/coreui.min.js") }}"></script>

<script src="{{ asset("assets/js/dropzone.js") }}"></script>

@if(Route::is('admin'))
    <!-- Plugins and scripts required by this view-->
    <script src="{{ asset("assets/vendors/chart.js/js/Chart.min.js") }}"></script>
    <script src="{{ asset("assets/vendors/@coreui/coreui-plugin-chartjs-custom-tooltips/js/custom-tooltips.min.js") }}"></script>
    <script src="{{ asset("assets/js/main.js") }}"></script>
@endif
@if(Route::is('config.homeCustomization'))
    <script src="{{ asset('assets/js/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/jquery.nestable.plus.js') }}" type="text/javascript"></script>
@endif
@if(Route::is('products.create') || Route::is('products.edit'))
    <script src="{{ asset('assets/js/summernote-bs4.min.js') }}" type="text/javascript"></script>
@endif
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
<script>
    $('[data-toggle="tooltip"]').tooltip();
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
        
        //submitting form from list

        $(".submitButton").click(function () {
            let dataId = $(this).data().id;
            $('#deleteForm').attr('action','/admin/config/home/content/'+dataId);
            $('#deleteForm').submit();
            $('button').prop('disabled', true);
        })

        //creating form for the content

        $("#createButton").click( function(){
            let theForm = $("form[data-sub='SbTn4MoDeL']");
            theForm.children('input[name="_method"]').remove();
            $('#model_SbTn4MoDeL').text('Create Content');
            theForm.attr('action','/admin/config/home/content');
            $("button[data-sub=SbTn4MoDeL]").html('<i class="fa fa-plus"></i> Add');
            $('#imagePreview').css('background-image', 'url(https://via.placeholder.com/300x300.png?text=Image)');
        })
        $(".editContentButton").click( function(){
            let theForm = $("form[data-sub='SbTn4MoDeL']"),
                hasMethod = theForm.find('input[name="_method"]'),
                content_id = $(this).data().id,
                header = $(this).data().header,
                title = $(this).data().title,
                content = $(this).data().content,
                image = $(this).data().image,
                url = $(this).data().url;
                
            if(hasMethod.length === 0){
                theForm.append('<input type="hidden" name="_method" value="PUT">');
            }
            $('#model_SbTn4MoDeL').text('Edit Content');
            $('#imagePreview').css('background-image', 'url('+image+')');
            theForm.find("input[name=header]").val(header);
            theForm.find("input[name=title]").val(title);
            theForm.find("input[name=url]").val(url);
            theForm.find("textarea[name=content]").html(content);
            theForm.attr('action','/admin/config/home/content/'+content_id);
            $("button[data-sub=SbTn4MoDeL]").html('<i class="fa fa-cloud-upload"></i> Update');
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
            form.prop('action','/admin/price/'+id);
            form.submit();
        })
        //Category options
        $('.option-a').click(function(e){
            e.preventDefault();
            let value = $(this).data('id');
            let text = $(this).text();
            $('.parent_id').val(value);
            $('.dropdown-menu i').removeClass('fa-check-square-o').addClass('fa-square-o');
            $(this).find('i').removeClass('fa-square-o').addClass('fa-check-square-o');
            $('.dropdowntree-name').text(text);
        });
        //end category options
        //Menu Customizer
        @if(Route::is('config.homeCustomization'))
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

        //Summer nots

        @if(Route::is('products.create') || Route::is('products.edit'))
        $.ajax({
        url: 'https://api.github.com/emojis',
        }).then(function(data) {
        window.emojis = Object.keys(data);
        window.emojiUrls = data; 
        });;

        $(".textarea").summernote({
            width: 800,
            height: 300,
            placeholder: 'Product descriptions....',
            hint: {
                match: /:([\-+\w]+)$/,
                search: function (keyword, callback) {
                callback($.grep(emojis, function (item) {
                    return item.indexOf(keyword)  === 0;
                }));
                },
                template: function (item) {
                var content = emojiUrls[item];
                return '<img src="' + content + '" width="20" /> :' + item + ':';
                },
                content: function (item) {
                var url = emojiUrls[item];
                if (url) {
                    return $('<img />').attr('src', url).css('width', 20)[0];
                }
                return '';
                }
            }
        });
        @endif

        //End Summer nots

        @if(Route::is('products.create') || Route::is('products.edit'))

        //Start product meta form script
            let meta_count = 1;
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
                $(this).html(`
                    <i class="fa fa-refresh fa-spin"></i> Saving...
                `).attr('disabled', true);
                getParentElement();
                let i = 0,
                    meta_data = [];
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
                request(window.JSON.stringify(meta_data));
            })
            var getParentElement = function(){
                el_parent = $('.plusItem').find('div.list-group-item');
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
                        "Content-Type": "application/json",
                        "X-Requested-With":"XMLHttpRequest",
                        "X-CSRF-TOKEN": token
                    },
                    data: meta_data
                });

                // Callback handler that will be called on success
                request.done(function (response, textStatus, jqXHR){
                    $("#create-product").submit();
                });

                // Callback handler that will be called on failure
                request.fail(function (jqXHR, textStatus, errorThrown){
                    // Log the error to the console
                    console.error(
                        "Error: "+
                        textStatus, errorThrown
                    );
                });

                // Callback handler that will be called regardless
                // if the request failed or succeeded
                request.always(function () {
                    //in leter
                });
            }

            // create the click function
            var removeDiv = function() {
                if($(this)[0] != window) {
                    let target = $(this).parent();

                    if(target.data().status == 0) {
                        target.attr('data-status','delete');
                        target.hide();
                    } else {
                        target.remove();
                    }
                }
            }

            $(function(){
                $('.list-group-item .meta_close').on("click", removeDiv);
            });
        //end product meta form script
        @endif

    });
</script>


<script>
Dropzone.autoDiscover = false;
$(document).ready(function(){
    var myDropzone = new Dropzone('form#dropzone-uploader',{
                            paramName: "photo",
                            maxFiles:12,
                            maxFilesize: 1,
                            acceptedFiles: 'image/*',
                            dictInvalidFileType: 'This form only accepts images.',
                            success: function(file, response){
                                $('#all_photos>.row').prepend(`
                                        <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                                            <div class="thumbnail img-btn" data-id="${response.photo.id}" data-url="${response.photo.path}">
                                                <img class="img-thumbnail"
                                                    src="${response.photo.path}">
                                            </div>
                                        </div>`);
                                    }
                        });

    $("#photo_add_btn").click(function(){
        Photos.createPreview();
        Photos.createValue();
    });

    $('.image-plus-btn').click(function(){
        Photos.sendRequest();
    });

    $(document).on('click','.load-more', function(){
        let path = $(this).data().next;
        $(this).prepend(`<i class="fa fa-refresh fa-spin"></i> &nbsp;`);
        Photos.sendRequest(path);
    });

    $(document).on('click','.img-btn', function(e){Photos.selectPhotos(e)});

    $(document).on('click', '.image-prev-remove', function(e){Photos.removePhoto(e)});

    $(function(){
        Photos.createValue();
    });

    var Photos = function(){
        return {
            loadPhotos: function(url){
                var request;
                // Abort any pending request
                if (request) {
                    request.abort();
                }

                // Fire off the request to 
                request = $.ajax({
                    url,
                    type: "get",
                    contentType: "application/json; charset=utf-8"
                });

                // Callback handler that will be called on success
                request.done(function (response, textStatus, jqXHR){
                    Photos.createGallary(response);
                    $('div.loading').remove();
                });

                // Callback handler that will be called on failure
                request.fail(function (jqXHR, textStatus, errorThrown){
                    // Log the error to the console
                    console.error(
                        "The following error occurred: "+
                        textStatus, errorThrown
                    );
                });
            },

            sendRequest: function(req = false){
                let hasFiles = $("#all_photos>.row").find('.img-btn')
                    path = req ? req:"/admin/get-photos";

                if(req || hasFiles.length === 0){
                    Photos.loadPhotos(path);
                }
            },

            createGallary: function(photos){
                let gallary = $('#all_photos>.row');

                $(".load-more").parent().remove();
                photos.data.forEach(function(photo){
                    gallary.append(`
                    <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                        <div class="thumbnail img-btn" data-id="${photo.id}" data-url="${photo.path}">
                            <img class="img-thumbnail"
                                    src="${photo.path}">
                        </div>
                    </div>`);
                });

                if(photos.next_page_url){
                    $('#all_photos').append(`
                        <div class="mx-auto mt-3"><button class="btn btn-sm btn-outline-success load-more" data-next="${photos.next_page_url}">Load more</button></div>
                    `);
                }
            },

            selectPhotos: function(e){
                let self = $(e.currentTarget),
                    i = self.find('i');

                if(i.length > 0){
                    i.remove();
                    self.removeClass('checked');
                } else {
                    self.prepend(`<i class="fa fa-check"></i>`).addClass('checked');
                }
            },

            createValue: function () {
                let checked = $('div#photo_preview .image-prev'),
                    input = $('input[name=photos]'),
                    val = [];

                $.each(checked, function(i){
                    val.push(checked[i].dataset.id);
                });

                input.val(val);
            },

            createPreview: function(){
                let checked = $('div.img-btn.checked'),
                    prev = $('#photo_preview');
                    
                prev.children('div.image-plus-btn').remove();
                checked.each(function(){
                    let already = $(".image-prev[data-id=" + $(this).data().id + "]");
                    
                    if(already.length === 0){
                        prev.append(`
                            <div class="image-prev" data-id="${$(this).data().id}" style="background-image:url(${$(this).data().url})">
                                <button type="button" class="image-prev-remove"></button>
                                &nbsp;
                            </div>
                            `);
                    }
                });
                prev.append(`<div class="image-plus-btn" data-toggle="modal" data-target="#successModal"><i class="fa fa-plus fa-3x"></i></div>`);

                $('.image-prev-remove').click(this.removePhoto);
            },

            removePhoto: function(e) {
                let self = $(e.currentTarget);
                self.parent().slideUp("fast", function() { 
                                    self.parent().remove();
                                    Photos.createValue();
                                });
            }
        }
    }();
    
})
</script>