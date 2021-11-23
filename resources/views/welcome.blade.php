@extends('layouts.app')
        <style>
            #container{
                width:100%;
                height: 100vh;
                background-color:#00a4ff;
                display: inline-block;
            }
            .text-box{
                color: white;
                position: absolute;
                top: 35%;
                margin-left: 5%;
            }
            .text-box a{
                color: white;
                text-decoration: none;
                padding: 10px 20px;
                margin-right:20px;
                border: 2px solid white;
            }
            .text-box .row{
                display:flex;
                align-items: center;
                flex-wrap: wrap;
                margin-left: 1%;
            }

        </style>
@section('content')
        <div id="container">
                <div class="text-box">
                    <h1 class="display-4">StockInFlow</h1>
                    <h3 class="display-6">MEMPERMUDAH MANAJEMEN INVENTORI DAN KEUANGANMU</h3>

                    <div class="row">
                        <a class="display-6" href="{{ route('register') }}">Sign Up &#8594</a>    
                    </div>
                </div>
        </div>
@endsection