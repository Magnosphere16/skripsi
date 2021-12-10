<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl">
            <div class="card mt-5">
                <div class="card-header" style="position:relative;"><strong>Purchase Transaction Lists</strong>
                        <router-link to="newPurchase" class="btn btn-success btn-sm" style="float:right; right:0;" tag="button">+ New Purchase Transaction</router-link>
                    <!-- <router-link to="newSale" style="display:inline-block; float:right; right: 0; bottom:8px;" type="button" id="sell_item_btn" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#addItemFCatForm">+ New Sale Transactions</router> -->
                    <!-- <button style="display:inline-block; float:right; right: 0; bottom:8px;" type="button" id="buy_item_btn" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addItemFCatForm">Buy Items</button> -->
                </div>
                <div class="card-body">
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
