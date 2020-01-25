@extends('admin.layouts.app')

@section('title')
    Create new page
@endsection

@section('content')
    <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    @include("admin.layouts.header")
    <div class="app-body">
        @include('admin.layouts.sidebar')
        <main class="main">
            <!-- Breadcrumb-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><i class="icon-home"></i></li>
                <li class="breadcrumb-item active">Admin</li>
                <li class="breadcrumb-item"><a href="{{ route("page.index") }}">All Pages</a></li>
                <li class="breadcrumb-item active">Add Page</li>
                @include('admin.layouts.breadcrumbMenu')
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    @if(count($errors) > 0)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Coution!</strong> {{ $error }}
                                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                        @endforeach
                    @endif
                <!-- /.row-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header"><i class="fa fa-edit"></i>Add Page</div>
                                <div class="card-body">
                                    <form id="create-product" action="{{ route("page.store") }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text">Title</span></div>
                                                    <input class="form-control" id="title" type="text" name="title" placeholder="page title" required value="{{ old("title") }}">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <textarea class="textarea" type="text" name="descriptions" placeholder="Descriptions" required>{{ old("descriptions") }}</textarea>
                                                </div>
                                            </div>
                                        <hr>
                                        <div class="form-group form-actions">
                                            <button class="btn btn-primary float-right" id="submit-btn" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-->
                    </div>
                    <!-- /.row-->
                </div>
            </div>
        </main>
    </div>


    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-success modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Photos</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active show" data-toggle="tab" href="#all_photos">Photos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#upload_photos">Upload</a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div id="all_photos" class="tab-pane fade in active show">
                        <div class="loading text-center m-5">
                            <i class="fa fa-refresh fa-spin fa-5x"></i>
                            <br>
                            Loading photos...
                        </div>
                        <div class="row">
                        </div>
                    </div>
                    <div id="upload_photos" class="tab-pane fade">
                        <form id="dropzone-uploader" action="{{ route('photos.store') }}" class="dropzone rounded">
                            @csrf
                            <div class="dz-message d-flex flex-column">
                              <i class="fa fa-cloud-upload fa-3x"></i>
                              Drag &amp; Drop here or click
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button id="photo_add_btn" class="btn btn-success" type="button" data-dismiss="modal">Save</button>
            </div>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>
    <!-- /.modal-->

    <footer class="app-footer">
        <div><a href="https://github.com/utpalongit">Utpal Sarkar</a><span>&copy; 2019.</span></div>
        <div class="ml-auto"><span>Powered by</span> Utpal Sarkar</div>
    </footer>
    @include('admin.layouts.footer')

    <script>
        $(document).ready(function(){
            $("ul.tree-css>li").first().children("label").children("input[type=radio]").attr("checked", true);
            var isEdit;
            if($(".data-view").children()[0]){
                $(".data-view").children()[0].className = "row";
            }
            $(".data-view").children().children().each((i,el) => {
                if(i%2 === 0) {
                    el.className = "col-sm-4";
                    $(el).append(`<div class="options"><button type="button" class="btn btn-outline-primary btn-sm add-to-edit"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-outline-danger btn-sm remove-the-paren"><i class="fa fa-trash"></i></button></div>`);
                } else {
                    el.className = "col-sm-8";
                }
            });

            $('body').on('click', 'button.plus-input', function(){
                let inputs = `<div class="type-item">
                    <input type="text" placeholder="Type" class="details-type mb-1 form-control">
                    <input type="text" placeholder="Value" class="details-value form-control">
                    <button type="button" class="btn btn-outline-danger btn-sm rounded close-btn-input mt-2">Remove</button>
                </div>`;
                $(this).parent().children("div#group-type").append(inputs);
            });

            $("body").on('click','button.close-btn-input', function() {
                $(this).parent().remove();
            });
            $("body").on('click','button.remove-the-paren', function() {
                $(this).parent().parent().next().remove();
                $(this).parent().parent().remove();
            });
            $("body").on('click','button.add-to-edit', function() {
                let specificationEl = $(this).parent().parent().parent();
                let specificationTitle = $(this).parent().parent().text();
                let exackEl = $(this).parent().parent().next();
                let creatingInput = '';
                exackEl.children().each((i,el)=>{
                    if(i%2 == 0) {
                        let rBtn = i > 0 ? `<button type="button" class="btn btn-outline-danger btn-sm rounded close-btn-input">Remove</button>`:'';
                        creatingInput = `${creatingInput}<div class="type-item">
                    <input type="text" value="${el.textContent.trim()}" placeholder="Type" class="details-type mb-1 form-control">
                    <input type="text" value="${$(el.nextElementSibling).text().trim()}" placeholder="Value" class="details-value form-control">
                    ${rBtn}
                </div>`;
                    }
                });
                $("input#details-title").val(specificationTitle.trim());
                $('#group-type').html(creatingInput);
                isEdit = specificationEl;
                if($(".input-container").find(".input-btn-cancle").length == 0) {
                    $(".input-container").append(`<button type="button" class="btn btn-warning btn-block input-btn-cancle">
                                                                Cancle
                                                            </button>`);
                }
            });
            $("body").on("click","button.input-btn-cancle",function(){
                let inputElement = `
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input type="text" placeholder="Title" class="form-control" id="details-title">
                                        </div>
                                        <div class="col-sm-8">
                                            <div id="group-type">
                                                <div class="type-item">
                                                    <input type="text" placeholder="Type" class="details-type mb-1 form-control">
                                                    <input type="text" placeholder="Value" class="details-value form-control">
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-outline-dark plus-input float-right m-2">
                                                + One
                                            </button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-info btn-block input-btn-add">
                                        Add
                                    </button>`;
                $(this).parent().html(inputElement);
                isEdit = null;
            });
            $("body").on('click','button.input-btn-add', function() {
                let title = $("input#details-title").val();
                let typeAndValue = '';
                $("div#group-type").children().each((i,el)=>{
                    let type = el.children[0].value;
                    let value = el.children[1].value;
                    typeAndValue = `${typeAndValue}
                    <div class="w-1/2 bg-gray-100 border-b border-gray-400 p-2">
                        ${type}
                    </div> 
                    <div class="w-1/2 border-b border-gray-400 p-2">
                        ${value}
                    </div>
                    `;
                });
                let buttons = `<div class="options"><button type="button" class="btn btn-outline-primary btn-sm add-to-edit"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-outline-danger btn-sm remove-the-paren"><i class="fa fa-trash"></i></button></div>`;
                let vHtml = `
                <div class="row">
                    <div class="col-sm-4">${title}${buttons}</div>
                    <div class="col-sm-8">${typeAndValue}</div>
                </div>`;
                let inputElement = `
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input type="text" placeholder="Title" class="form-control" id="details-title">
                                        </div>
                                        <div class="col-sm-8">
                                            <div id="group-type">
                                                <div class="type-item">
                                                    <input type="text" placeholder="Type" class="details-type mb-1 form-control">
                                                    <input type="text" placeholder="Value" class="details-value form-control">
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-outline-dark plus-input float-right m-2">
                                                + One
                                            </button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-info btn-block input-btn-add">
                                        Add
                                    </button>`;
                if(!isEdit){
                    let checkRow = $('div.data-view').children(".row");
                    if(checkRow.length === 0) {
                        $('div.data-view').append(vHtml);
                    } else {
                        checkRow.append(`<div class="col-sm-4">${title}${buttons}</div><div class="col-sm-8">${typeAndValue}</div>`);
                    }
                } else {
                    $(isEdit).html(`<div class="col-sm-4">${title}${buttons}</div><div class="col-sm-8">${typeAndValue}</div>`);
                    isEdit = null;
                }
                $(this).parent().html(inputElement);
            });

            function textCreator(){
                $(".options").remove();
                let inputText = $(".data-view").html();
                inputText = inputText
                .replace(/row/g,"flex flex-wrap bg-white max-w-6xl mx-auto mt-1")
                .replace(/col-sm-4/g,"w-3/12 flex items-center justify-center md:font-extrabold md:text-lg font-mono border-b border-gray-400")
                .replace(/col-sm-8/g, "w-9/12 flex flex-wrap");
                $("#details-input").html(inputText);
            }
            $("button#submit-btn-create-post").click(function(e){
                e.preventDefault();
                $(this).html(`
                    <i class="fa fa-refresh fa-spin"></i> Saving...
                `).attr('disabled', true);
                textCreator();
                $("#create-product").submit();
            });
            // TODO: variants...
            let editingVariant;
            $("body").on("click","button.add-variant-button",function(){
                let values = $(this).prev().val();
                if(values.trim().length > 0) {
                    let vHtml = `<div class="bg-gray-100 variants-value mt-1">${values}<button type="button" class="btn btn-default text-success btn-sm variant-to-edit"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-default text-danger btn-sm remove-the-variant"><i class="fa fa-trash"></i></button></div>`;
                    if(editingVariant){
                        $(editingVariant).html(`${values}<button type="button" class="btn btn-default text-success btn-sm variant-to-edit"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-default text-danger btn-sm remove-the-variant"><i class="fa fa-trash"></i></button>`);
                        editingVariant = null;
                    } else {
                        $('div.variant-viewer').append(vHtml);
                    }
                    $(this).prev().val('');
                }
            });
            $("body").on("click","button.remove-the-variant", function(){
                $(this).parent().remove();
            });
            $("body").on("click","button.variant-to-edit", function(){
                editingVariant = $(this).parent();
                let theText = $(this).parent().text();
                $('div.variant-input>input').val(theText);
            });
            function makeVariants(){
                let variants = '';
                $('div.variant-viewer').children().each((i,el)=>{
                    if(variants){
                        variants = `${variants}|${$(el).text()}`;
                    } else {
                        variants = $(el).text();
                    }
                });
                $('input#variants').val(variants);
            }
        });
    </script>

    </body>
@endsection
