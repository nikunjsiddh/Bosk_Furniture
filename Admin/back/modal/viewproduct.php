 <div class="modal fade" id="expedit<?php echo $row['id'] ?>" tabindex="-1"  aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title  fw-bold" id="expeditLabel"> Edit Return Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                       <div class="row">
                                        <div class="col-md-5">Product Name</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><?php echo $pname; ?></div>
                                    </div>
                       	<br/>
                                  
									
									 <div class="row">
                                        <div class="col-md-5">Product Image 1</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px" src="product_image/<?php echo $img1; ?>"></div>
                                    </div>
									<br/>
									<?php
									if($img1=='noimg.jpg')
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 2</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px" src="product_image/noimg.jpg"></div>
                                    </div>
																	
									<?php	
									}
									else
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 2</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px"src="product_image/<?php echo $img2; ?>"></div>
                                    </div>
									<?php									
									}
									?>
									 
									<br/>
									 <?php
									if($img2=='noimg.jpg')
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 3</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px" src="product_image/noimg.jpg"></div>
                                    </div>
																	
									<?php	
									}
									else
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 3</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px"src="product_image/<?php echo $img3; ?>"></div>
                                    </div>
									<?php									
									}
									?>
									<br/>
									 <?php
									if($img3=='noimg.jpg')
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 4</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px" src="product_image/noimg.jpg"></div>
                                    </div>
																	
									<?php	
									}
									else
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 4</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px"src="product_image/<?php echo $img4; ?>"></div>
                                    </div>
									<?php									
									}
									?>
									<br/>
									 <?php
									if($img4=='noimg.jpg')
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 5</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px" src="product_image/noimg.jpg"></div>
                                    </div>
																	
									<?php	
									}
									else
									{
									?>
									<div class="row">
                                        <div class="col-md-5">Product Image 5</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-5"><img height="200px" width="200px"src="product_image/<?php echo $img5; ?>"></div>
                                    </div>
									<?php									
									}
									?>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                        
                    </div>
                </div>
                </div>
            </div>