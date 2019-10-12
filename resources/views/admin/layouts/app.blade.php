<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Laravel App">
    <meta name="author" content="Utpal Sarkar">
    <meta name="keyword" content="Laravel,App">
    <title>@yield('title', $site_name)</title>
    
    <link rel="shortcut icon" type="image/x-icon" href="{{ $favicon }}">
    <!-- Icons-->
    <link href="{{ asset("assets/vendors/@coreui/icons/css/coreui-icons.min.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/vendors/flag-icon-css/css/flag-icon.min.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/vendors/font-awesome/css/font-awesome.min.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/vendors/simple-line-icons/css/simple-line-icons.css") }}" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="{{ asset("assets/css/style.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/vendors/pace-progress/css/pace.min.css") }}" rel="stylesheet">

    <link href="{{ asset("assets/css/dropzone.css") }}" rel="stylesheet">


    @if(Route::is('config.homeCustomization'))
        <link rel="stylesheet" href="{{ asset('assets/css/nestable-style.css') }}" />
    @endif
    @if(Route::is('products.create') || Route::is('products.edit'))
        <link rel="stylesheet" href="{{ asset('assets/css/summernote-bs4.css') }}" />
    @endif
        <style>
            .avatar-upload {
                position: relative;
                max-width: 205px;
            }
            .avatar-upload .avatar-edit {
                position: absolute;
                right: 12px;
                z-index: 1;
                top: 10px;
            }
            .avatar-upload .avatar-edit input {
                display: none;
            }
            .avatar-upload .avatar-edit input + label {
                display: inline-block;
                width: 34px;
                height: 34px;
                margin-bottom: 0;
                border-radius: 100%;
                background: #FFFFFF;
                border: 1px solid #006fff;
                box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
                cursor: pointer;
                font-weight: normal;
                transition: all 0.2s ease-in-out;
            }
            .avatar-upload .avatar-edit input + label:hover {
                background: #f1f1f1;
                border-color: #d6d6d6;
            }
            .avatar-upload .avatar-edit input + label:after {
                content: "\f03e";
                font-family: "FontAwesome";
                text-rendering: auto;
                color: #006fff;
                position: absolute;
                top: 6px;
                left: 0;
                right: 0;
                text-align: center;
                margin: auto;
            }
            .avatar-upload .avatar-preview {
                width: 192px;
                height: 192px;
                position: relative;
                border: 6px solid #F8F8F8;
                box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
            }
            .avatar-upload .avatar-preview > div {
                width: 100%;
                height: 100%;
                background-repeat: no-repeat;
                background-size: contain;
                background-position: center;
            }
            .tree li {
                list-style-type:none;
                background-color: #f7f1d5;
                margin:0;
                padding:10px 5px 0 5px;
                position:relative
            }
            .tree li::before, 
            .tree li::after {
                content:'';
                left:-20px;
                position:absolute;
                right:auto
            }
            .tree li::before {
                border-left:2px solid #d0c9aa;
                bottom:50px;
                height:100%;
                top:0;
                width:1px
            }
            .tree li::after {
                border-top:2px solid #d0c9aa;
                height:20px;
                top:25px;
                width:25px
            }
            .tree li label {
                -moz-border-radius:5px;
                -webkit-border-radius:5px;
                background-color: #FFF8DC;
                border:2px solid #d0c9aa;
                border-radius:3px;
                display:inline-block;
                padding:3px 8px;
                text-decoration:none;
                cursor:pointer;
            }
            .border-tree{
                border:2px solid #d0c9aa;
            }
            .tree-header{
                background-color: #f7f1d5;
                color: #737063;
            }
            .tree li label input{
                z-index: 1;
            }
            .tree>ul>li::before,
            .tree>ul>li::after {
                border:0
            }
            .tree li:last-child::before {
                height:27px
            }
            .tree li label:hover {
                background: #aeaeae;
                border:2px solid #94a0b4;
                }
            .tree-css{
                overflow-x: scroll;
                overflow-y: hidden;
                background-color: #f7f1d5;
                padding: 0 5px;
            }
            .tree input[type='radio'] {
                -moz-appearance: none;
                -webkit-appearance: none;
                width: 18px;
                height: 18px;
                border-radius: 50%;
                outline: none;
                border: 2px solid #d0c9aa;
                margin-top: 2px;
            }

            .tree input[type='radio']:before {
                background: #f7f1d5;
                content: '';
                display: block;
                width: 100%;
                height: 100%;
                border-radius: 50%;
            }

            .tree input[type="radio"]:checked:before {
                width: 60%;
                height: 60%;
                margin: 20% auto;
                background: green;
                border-radius: 0;
            }
            
            .tree input[type="radio"]:checked {
                border-color:green;
            }
            .option-a{
                display: block;
                padding: 2px 5px;
                border-bottom: 1px solid #c1c1c1;
                color: #777;
            }
            .option-ul{
                list-style: none;
            }
            .child {
                border-left: 1px solid #c1c1c1;
            }
            .option-label{
                background-color: #d5d5d5;
                padding: 8px;
                margin-bottom: 0px;
                position: relative;
                margin-inline-end: -5px;
                padding-top: 5px;
                border-top-left-radius: 0.25rem;
                border-bottom-left-radius: 0.25rem;
            }
            .image-plus-btn{
                border: 1px dashed #7b7b7b;
                padding: 13px 20px;
                border-radius: 5px;
                max-width: min-content;
                position: relative;
                left: 5px;
                color: #a2a2a2;
                transition: all 0.2s ease-in-out;
                cursor: pointer;
            }
            .image-plus-btn:hover{
                border: 1px dashed #27b8ff;
                color: #0070ff;
            }
            .image-prev{
                background-repeat: no-repeat;
                background-position: center;
                background-size: contain;
                width: 75px;
                height: 70px;
                transition-duration: 150ms;
                transition-property: transform;
            }
            .image-prev:hover{
                box-shadow: 0px 0px 3px #868686;
                transform: scale(1.05);
                background-color: #e8e8e8;
                z-index: 9;
            }
            #photo_preview{
                display: flex;
                transition: all 0.2ms ease-in-out;
            }
            .image-prev-remove{
                position: absolute;
                right: -12px;
                top: -12px;
                border: 1px dashed red;
                background: #fdd;
                border-radius: 100%;
                height: 17px;
                width: 17px;
                font-size: inherit;
                text-rendering: auto;
                font: normal normal normal 10px/1 FontAwesome;
                color: red;    
                opacity: 0;
                transform: scale(0.25);
                transition-duration: 150ms;
                transition-property: transform, opacity;
            }
            .image-prev-remove::before{
                content: "\f00d";
                position: relative;
                left: -4px;
                top: -1px;
            }
            .image-prev-remove:focus{
                outline: 0;
            }
            .image-prev:hover .image-prev-remove{
                opacity: 1;
                transform: scale(1);
                transition-delay: 333ms;
            }
            .img-btn>i{
                position: absolute;
                color: #eee;
                border: 1px solid gray;
                border-radius: 100%;
                background-color: #19ac29;
            }
            .delete-photo-btn{
                position: relative;
                top: -44px;
                left: -2px;
            }
        </style>
</head>
@yield('content')
</html>
