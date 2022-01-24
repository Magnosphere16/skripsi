<!DOCTYPE html>
<html>
<head>
    <title>Transactions Receipt</title>
    <style>
        #invoice-POS{
        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
        padding:2mm;
        margin: 0 auto;
        width: 100%;
        background: #FFF;

        h2{font-size: .9em;}
        h3{
        font-size: 1.2em;
        font-weight: 300;
        line-height: 2em;
        }
        
        #top, #mid,#bot{ /* Targets all id with 'col-' */
        border-bottom: 1px solid #EEE;
        }

        #top{min-height: 100px;}
        #mid{min-height: 80px;} 
        #bot{ min-height: 50px;}

        #top .logo{
            height: 60px;
            width: 60px;
            background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
            background-size: 60px 60px;
        }
        .clientlogo{
        float: left;
            height: 60px;
            width: 60px;
            background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
            background-size: 60px 60px;
        border-radius: 50px;
        }
        .info{
        display: block;
        //float:left;
        margin-left: 0;
        }
        .title{
        float: right;
        }
        .title p{text-align: right;} 
        table{
        width: 100%;
        border-collapse: collapse;
        }
        .tabletitle{
        background: #EEE;
        }
        .service{border-bottom: 1px solid #EEE;}

        }
    </style>
<body>
    
  
<div id="invoice-POS">
        <center><h1>{{$shop}}</h1></center>
    
        <center>
        <p>{{$address}}</p>
        <p>{{$email}}</p>
        <p>{{$phone}}</p></center>
    <div id="bot">
        <div>
        <p><strong>Transaction No. #{{$transHeader->id}}</strong></p>
        <p><strong>{{$date}}</strong></p>
        </div>
        <hr>
                <center>
					<div id="table">
						<table>
							<tr class="tabletitle">
								<td class="item"><h2>Product</h2></td>
                                <td class="item"><h2>Qty</h2></td>
                                <td class="item"><h2>Unit</h2></td>
								<td class="item" style="text-align: right;"><h2>Price</h2></td>
								<td class="item" style="text-align: right;"><h2>Sub Total</h2></td>
							</tr>
                        <?php 
                             foreach ($transDetail as $dtl){
                                 ?>
							<tr class="service">
                                <?php
                                    $unit_type_id=0; 
                                    foreach($item as $itm){
                                    if($dtl->td_item_id==$itm->id){
                                        ?>
								<td class="tableitem"><p class="itemtext">{{$itm->item_name}}</p></td>
                                        <?php
                                        $unit_type_id=$itm->unit_type_id;
                                        }
                                    }  
                                ?> 
								<td class="tableitem"><p class="itemtext">{{$dtl->td_item_qty}}</p></td>
                                <?php foreach($unitType as $unt){
                                    if($unit_type_id==$unt->id){
                                        ?>
								<td class="tableitem"><p class="itemtext">{{$unt->unit_type_name}}</p></td>
                                        <?php
                                        }
                                    }  
                                ?> 
								<td class="tableitem"><p class="itemtext" style="text-align: right;">Rp. {{number_format( $dtl->td_item_price , 0 , '.' , ',' )}}</p></td>
                                <td class="tableitem"><p class="itemtext" style="text-align: right;">Rp. {{number_format( $dtl->td_sub_total_price , 0 , '.' , ',' )}}</p></td>
							</tr>
                            <?php 
                                } 
                                ?>
							<tr class="tabletitle">
								<td colspan="3"></td>
								<td class="Rate" style="text-align: right;"><h2>Grand Total</h2></td>
								<td class="payment" style="text-align: right;"><h2>Rp. {{number_format($transHeader->tr_total_price , 0 , '.' , ',')}}</h2></td>
							</tr>

						</table>
					</div><!--End Table-->
                    </center>
				</div><!--End InvoiceBot-->
  </div><!--End Invoice-->
</body>
</html>