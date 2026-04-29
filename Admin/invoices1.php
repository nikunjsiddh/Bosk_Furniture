<?php 
include_once("connect.php");
session_start();
if(isset($_GET['astringdata']) && isset($_GET['astringdata1']))
	{
	    $order_id = mysqli_real_escape_string($con,$_GET['astringdata']);
	     $user_id = mysqli_real_escape_string($con,$_GET['astringdata1']);
	   
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
  <style media="print">
    #Invoice-Simple{
        background-color:green !important;
    }
    /* Add other styles with sufficient specificity */
</style>
   <?php include_once"design/header.php"?>
   
  <script>
   function printDocument() {
    var printContents = document.getElementById("Invoice-Simple").innerHTML;
    var printContainer = document.createElement("div");
    printContainer.innerHTML = printContents;

    // Open a new window and set its content to the print container
    var printWindow = window.open('', '_blank');
    printWindow.document.body.appendChild(printContainer);

    // Print the contents of the new window
    printWindow.print();
}

</script>

</head>
<body>
    <div id="ebazar-layout" class="theme-blue">
        
        <!-- sidebar -->
        

        <!-- main body area -->
        <div class="main px-lg-4 px-md-4">

            <!-- Body: Header -->
          

            <!-- Body: Body -->
            <div class="body d-flex py-lg-3 py-md-2">
                <div class="container-xxl">
                    
                    <div class="row align-items-center">
                        <div class="border-0 mb-4">
                            <div class="card-header no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <h3 class="fw-bold mb-0 py-3 pb-2">Invoice</h3>
                               
                            </div>
                        </div>
                    </div> <!-- Row end  -->

                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-md-12">
                            <div class="tab-content">
                                
                                <form>
                                <div class="tab-pane fade show active" id="Invoice-Simple">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-8 col-md-12">
                                            <div class="card p-xl-5 p-lg-4 p-0">
                                                <div class="card-body">
                                                    <?php
                                                    $currentDateTime = date('Y-m-d H:i:s');
                                             $cmd2="select * from admin";
                                             $result2=mysqli_query($con,$cmd2) or die(mysqli_error($con));
                                             $row2=mysqli_fetch_array($result2);
                                             $email=$row2['email'];
                                             $phone=$row2['phone'];
                                             $firstname=$row2['firstname'];
                                             $lastname=$row2['lastname'];
                                             $adminname=$firstname.' '.$lastname;
                                                  
                                            $cmd1="select * from user where id='$user_id'";
                                            $result1=mysqli_query($con,$cmd1)or die(mysqli_error($con));
                                            $row1=mysqli_fetch_array($result1);
                                            $firstname=$row1['firstname'];
                                            $lastname=$row1['lastname'];
                                            $name=$firstname.' '.$lastname;
                                            $email=$row1['email'];
                                            $addressline1=$row1['addressline1'];
                                            $addressline2=$row1['addressline2'];
                                            $pincode=$row1['pincode'];
                                            $state=$row1['state'];
                                            $city=$row1['city'];
                                            $country=$row1['country'];
                                            $phone=$row1['phone'];
                                            
                                            $cmd="select * from orders where order_id='$order_id'";
                                              $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
                                              $row=mysqli_fetch_array($result);
                                               $address=$row['address'];
                                                //   $user_id=$row['user_id'];
                                                  $date_time=$row['date_time'];
                                                  $phone=$row['phone'];
                                          
                                ?>
                                                    <div class="mb-3 pb-3 border-bottom">
                                                        Invoice
                                                        <strong><?php echo $currentDateTime;?></strong>
                                                        <span class="float-end"> <strong>transection id:</strong> #18414</span>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <div class="col-sm-6">
                                                            <h6 class="mb-3">From:</h6>
                                                            <div><strong><?php echo $adminname;?></strong></div>
                                                            <!--<div>111  Berkeley Rd</div>-->
                                                            <!--<div>STREET ON THE FOSSE, Poland</div>-->
                                                            <div>Email: <?php echo $email;?></div>
                                                            <div>Phone: +91 <?php echo $phone;?></div>
                                                        </div>
                                                        
                                                        <div class="col-sm-6">
                                                            <h6 class="mb-3">To:</h6>
                                                            <div><strong><?php echo $name;?></strong></div>
                                                            <div><?php echo $addressline1;?>,<?php echo $addressline2;?></div>
                                                            <div><?php echo $city;?>,<?php echo $pincode;?>,<?php echo $state;?>,<?php echo $country;?></div>
                                                            <div>Email: <?php echo $email;?></div>
                                                            <div>Phone: +91 <?php echo $phone;?></div>
                                                        </div>
                                                    </div> <!-- Row end  -->
                                                    
                                                    <div class="table-responsive-sm">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">#</th>
                                                                    <th>Item</th>
                                                                    
                                                                    <th class="text-end">Item Cost</th>
                                                                    <th class="text-center">Products Item</th>
                                                                    <th class="text-end">Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $count=0;
                                                                 include_once("connect.php");
                                                                    $cmd2="select * from order_items where order_id='$order_id'";
                                                                    $result2=mysqli_query($con,$cmd2) or die(mysqli_error($con));
                                                                    while($row2=mysqli_fetch_array($result2))
                                                                    {     
                                                                        $product_id = $row2['product_id'];
                                                                      
                                                                        $price=$row2['price'];
                                                                        $quantity=$row2['quantity'];
                                                                        
                                                                        
                                                                     $cmd3="select * from products where id='$product_id' ";
                                                                        $result3=mysqli_query($con,$cmd3) or die(mysqli_error($con));
                                                                        while($row3=mysqli_fetch_array($result3))
                                                                        {   
                                                                            $count = $count + 1;
                                                                            $pname = $row3['pname'];
                                                                          
                                                                            $pcategory=$row3['pcategory'];
                                                                            $img1=$row3['img1'];
                                                                             $new_price=$row3['new_price'];
                                                                             $total_price = $quantity * $new_price;
                                                                                $totalPrice1 += $total_price; 
                                                                       
                                                                    ?>
                                                                <tr>
                                                                    <td class="text-center"><?php echo $count;?></td>
                                                                    <td><?php echo $pname;?></td>
                                                                    
                                                                    <td class="text-end"><?php echo $new_price;?></td>
                                                                    <td class="text-center"><?php echo $quantity;?></td>
                                                                    <td class="text-end"><?php echo $totalPrice1;?></td>
                                                                </tr>
                                                                <?php
                                                                        }
                                                                    }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                    
                                                    <div class="row">
                                                        <div class="col-lg-4 col-sm-5">
                                                        
                                                        </div>
                                                        <?php
                                                        $total_price = $quantity * $new_price;
                                                        $subTotal+=$totalPrice1;
                                                        $tax=$subTotal*0.18;
                                                        $shipping=$subTotal*0.02;
                                                        $total1=$subTotal+$tax+$shipping;
                                                        ?>
                                                        <div class="col-lg-4 col-sm-5 ms-auto">
                                                            <table class="table table-clear">
                                                                <tbody>
                                                                    <tr>
                                                                        <td ><strong>Subtotal</strong></td>
                                                                        <td class="text-end"><?php echo $subTotal;?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td ><strong>Tax(18%)</strong></td>
                                                                        <td class="text-end"><?php echo $tax;?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td ><strong>Shipping(2%)</strong></td>
                                                                        <td class="text-end"><?php echo $shipping;?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td ><strong>Total</strong></td>
                                                                        <td class="text-end"><strong><?php echo $total1;?></strong></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div> <!-- Row end  -->
                    
                                                    <div class="row">
                                                        <!--<div class="col-lg-12">-->
                                                        <!--    <h6>Terms &amp; Condition</h6>-->
                                                        <!--    <p class="text-muted">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over</p>-->
                                                        <!--</div>-->
                                                        <div class="col-lg-12 text-end">
                                                            <button type="button" onclick="printDocument()"  class="btn btn-outline-secondary btn-lg my-1"><i class="fa fa-print"></i> Print</button>
                                                           
                                                        </div>
                                                    </div> <!-- Row end  -->
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- Row end  -->
                                </div> <!-- tab end  -->
                                </form>
                               
                            </div>
                        </div>

                    </div> <!-- Row end  -->
                </div>
            </div>

           

        </div>

    </div>

    <!-- Jquery Core Js -->
    <script src="assets/bundles/libscripts.bundle.js"></script>

    <!-- Jquery Page Js -->
    <script src="../js/template.js"></script>
    

</body>

<!-- Mirrored from pixelwibes.com/template/ebazar/html/dist/invoices.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 06:18:25 GMT -->
</html>
<?php
}
?>