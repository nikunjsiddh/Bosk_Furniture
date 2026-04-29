<div class="modal fade" id="categorymodal" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
                    <h5>Edit Category Details</h5>
                    <button type="button" class="close" style="font-size:20pt;" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
            <div class="modal-body">
               
                    <form id="MyForm" method="post">
                        
                    <input type="hidden" name="id" id="id">
                    
								<div class="form-group">
                                <label for="">Category Name<sup style="color:red;">*</sup></label>
                                <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId"   required />

                                </div>
							
							
							
							
								
								
                            <div class="modal-footer">                                
                            <button class="btn waves-effect waves-light btn-primary btn-square btn-block"type="submit" name="submit" id="submit">Submit</button>
                            </div>
							
                            
                            
                            
                        </form>

                        <div id="return"></div>

                    </div>


            </div>
           
        </div>
    </div>
</div>
