<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header" style="position:relative;"><strong>Transaction Lists</strong>
                    <button style="display:inline-block; float:right; right: 0; bottom:8px;" type="button" id="sell_item_btn" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#addItemFCatForm">+ New Sale Transactions</button>
                    <!-- <button style="display:inline-block; float:right; right: 0; bottom:8px;" type="button" id="buy_item_btn" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addItemFCatForm">Buy Items</button> -->
                </div>
                <table class="table table-striped">
                    <thead>
                        <th>Item Name</th>
                        <th>Item Quantity (pcs)</th>
                        <th>Item Price</th>
                        <th>Transaction Type</th>
                        <th>Total Price</th>
                    </thead>
                    <tbody>
                        <!-- <tr v-for="a in items" :key="a.id" :value="a.id">
                            <td>{{a.item_name}}</td>
                            <td>{{a.item_desc}}</td>
                            <td>{{a.item_qty}}</td>
                            <td>Rp {{a.item_buy_price}}</td>
                            <td>Rp {{a.item_sell_price}}</td>
                            <td>
                                    <a
                                        href="#"
                                        @click="showModalEdit(a)"
                                        ><i class="fas fa-edit blue"></i
                                    ></a>
                                    | <a
                                        href="#"
                                        @click="deleteData(a.id)"
                                        ><i
                                            class="fas fa-trash-alt red"
                                        ></i
                                    ></a>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
                <div class="card-body">
                        <div class="modal fade" id="addItemFCatForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content" >
                                    <div class="modal-header text-center">
                                        <h4 class="modal-title" id="exampleModalLongTitle">New Transactions</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="/add_item" id="addItemForm">
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
                                                    <select name="category_id" id="category_id" class="form-control input-lg dynamic" style="width:inherit;">
                                                        <option value="">Choose Category</option>
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

</template>

<script src="http://code.jquery.com/jquery-3.4.1.js"></script>
<script>
    function form_submit(){
        document.getElementById("addItemForm").submit();
    }
</script>

<script>
    export default {
        mounted() {
        }
    }
</script>
