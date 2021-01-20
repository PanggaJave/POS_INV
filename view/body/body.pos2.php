<!-- Start app main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Ken's POS System</h1> 
                    
                    <div class="col-lg-9">
                      <div class="row" >
                            <style type="text/css">
                              .aaa {
                                margin: 3%;
                                float: right;
                              }
                            </style>
                                <button  type="button" class="btn btn-dark col-lg-3 aaa" >
                                 Proceed Order
                                </button> 
                                <button  type="button" class="btn btn-dark col-lg-3 aaa">
                                 Get New Order ID
                                </button>
                                <button  type="button" onclick="ClearOrder(<?php echo $_SESSION["orderid"]; ?>)" class="btn btn-dark col-lg-3 aaa"> 
                                Clear Order
                              </button>
                      </div>                                    
                    </div>  
                </div>   
                <div class="row">
                <div class="col-lg-12">
                  <div class="col-md-12">
                    <div class="row">
                      <?php
                      
                          $SelectQuery = "SELECT * FROM product";
                          $s_res = $c_Select->fn_SelectAll($conn, $SelectQuery);  
                          while ($row = $s_res->fetch())
                          {  
                              echo '
                              <div class="col-md-3 col-md-3 col-sm-3 col-12" >
                                  <button onclick="func_addcart('.$row['id'].', '.$_SESSION["orderid"].');" type="button" class="btn btn-dark card card-statistic-1" style="height:90%;">
                                      <div class="card-icon bg-primary">
                                          <img src="'.$row['photo'].'" height="100px;" width="180px;">
                                      </div>
                                      <br/>
                                      <div class="card-wrap" style="float: right">
                                          <div class="card-header">
                                              <h4>'.$row['productname'].'</h4>
                                          </div>
                                          <div class="card-body" style="color: white">
                                            P '.$row['price'].'
                                          </div>
                                      </div>
                                  </button>
                              </div>
                              ';
                          }
                          ?>
                    </div>               
                  </div>
                </div>
                    
                              
                </div>
            </section>
        </div>

  <!-- Modal -->
  <div class="modal fade" id="modalReloadDuration" role="dialog"  data-backdrop="static">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">        
          <h4 class="modal-title" style="float:left">Add Order</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>          
        </div>
        <div class="modal-body">
            <div class="form-group">
              <label for="pwd">OrderID</label>
              <input type="text" class="form-control" id="OrderID" name="OrderID" disabled>
            </div>
            <div class="form-group">
              <label for="pwd">ProductID</label>
              <input type="text" class="form-control" id="ProductID" name="ProductID" disabled>    
            </div>
            <div class="form-group">
              <label for="pwd">No. of Order</label>
              <input type="number" class="form-control" id="qtyoforder" name="qtyoforder">    
            </div>
        </div>        
        <button type="submit" class="btn btn-success" onclick="funcAddOrderCart()" style="float:left">Add order</button>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>      
    </div>
  </div>

<script type="text/javascript">
            
var myWindow;
function func_addcart(id, orderid) 
{
      $.ajax({
          type: "POST",
          url: "class/api.function.php",
          data: {
              id: 'GetProduct',
              data: id
          },
          success: function(response)
          {
              var a_response = JSON.parse(response);
              if (response != "[]") {
                  document.getElementById("ProductID").value = a_response[0].productid;
                  document.getElementById("OrderID").value = orderid;
                  $("#modalReloadDuration").modal();
              } else {
                  alert("something Wrong");
              }
          }
      });
}      
  function closeWin() {
      myWindow.close();
    }
  function openWin() {
      myWindow = window.open("receipt.php", "_blank", "width=400, height=800");
    }
  function funcAddOrderCart()
  {
    debugger
    var orderid = document.getElementById("OrderID").value;
    var productid = document.getElementById("ProductID").value;
    var qty = document.getElementById("qtyoforder").value;
   $.ajax({
        type: "POST",
        url: "class/api.function2.php",
        data: {
            id : "addordercart",
            data1: orderid,
            data2: productid,
            data3: qty
        },
        success: function(resp) {
            alert(resp);
            $("#modalReloadDuration").modal("hide");
        }
    });
  }

  function funcPrint()
  {
    debugger;    
    document.getElementById("ReceiptPrint").print();

  }

  function ClearOrder(id)
  {
    $.ajax({
          type: "POST",
          url: "class/api.function.php",
          data: {
              id: 'ClearOrder',
              data: id
          },
          success: function(response)
          {
              alert(response);            
          }
      });
  }

</script>