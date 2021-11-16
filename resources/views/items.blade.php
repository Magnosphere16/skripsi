@extends('layouts.app')
@section('content')
<?php
    use App\Models\Category;
    use App\Models\Item;

        $category=Category::All();
        $item=Item::All();
        
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="position:relative;"><strong>Items</strong>
                    <button style="position: absolute; right: 10px; bottom:8px;" type="button" id="add_item_cat" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#addItemFCatForm">+</button>
                </div>
                <div class="card-body">
                @foreach ($item as $view)
                    <p>{{$view->item_name}}</p>
                    <?php
                        if($view->item_qty<=100){
                            ?>
                                <p>Stok tersisa Kurang dari 100</p>
                    <?php
                        }
                    ?>
                    <br>
                @endforeach

                <!-- Pop Up untuk insert -->
                        <div class="modal fade" id="addItemFCatForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content" >
                                    <div class="modal-header text-center">
                                        <h4 class="modal-title" id="exampleModalLongTitle">New Item</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="/add_item" id="addItemForm">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="name" class="col-md-4 col-form-label text-md-right">Item Name</label>

                                                <div class="col-md-6">
                                                    <input id="item_name" type="text" class="form-control" name="item_name">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="item_desc" class="col-md-4 col-form-label text-md-right">Item Description</label>

                                                <div class="col-md-6">
                                                    <textarea id="item_desc" rows="4" cols="50" class="form-control" name="item_desc">
                                                        
                                                    </textarea>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="item_desc" class="col-md-4 col-form-label text-md-right">Item Category</label>

                                                <div class="col-md-6">
                                                    <select name="category_id" id="category_id" class="form-control input-lg dynamic @error('category_id') is-invalid @enderror" style="width:inherit;">
                                                        <option value="">Choose Category</option>
                                                        @foreach ($category as $object)
                                                            <option value="{{$object->id}}">{{$object->category_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="qty" class="col-md-4 col-form-label text-md-right">Item Quantity</label>

                                                <div class="col-md-6">
                                                    <input id="item_qty" type="number" class="form-control" name="item_qty" min="1" placeholder="1">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="buy" class="col-md-4 col-form-label text-md-right">Item Buy Price</label>

                                                <div class="col-md-6">
                                                    <input id="item_buy" type="number" class="form-control" name="item_buy" min="0" placeholder="0">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="sell" class="col-md-4 col-form-label text-md-right">Item Sell Price</label>

                                                <div class="col-md-6">
                                                    <input id="item_sell" type="number" class="form-control" name="item_sell" min="0" placeholder="0">
                                                </div>
                                            </div>

                                            <div class="form-group row mb-0">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="button" class="btn btn-primary btn-block" onCLick="form_submit()">
                                                        Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="http://code.jquery.com/jquery-3.4.1.js"></script>
<script>
    function form_submit(){
        document.getElementById("addItemForm").submit();
    }
</script>
@endsection
