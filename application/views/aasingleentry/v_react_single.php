<?php $this->load->view("template/header.php"); ?>

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        React Js 
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php //echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">React</li>
      </ol>
    </section>

    <section class="content">
    <div class="row">
    	<div class="col-sm-12">
    		<div class="box">
    			<div class="box-header">
              	<h3 class="box-title">React Js Single Entry</h3>
            	</div>
            	<div class="box-body">
            		<div id="content">
            
    				</div>
            	</div>
    		</div>
    		
    	</div>
    </div>

    

	</section>
 </div> 

<?php $this->load->view("template/footer.php"); ?>

<!-- react js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.1.0/react.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.1.0/react-dom.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.min.js"></script>

<!-- main compnent file load -->
<!-- <script   type="text/babel" src="<?php //echo base_url('assets/reactjs/main.component.js');?>"></script> -->
<script   type="text/babel" src="<?php echo base_url('assets/reactjs/loaddata.js');?>"></script>
<!-- <script   type="text/babel" src="<?php //echo base_url('assets/reactjs/loaddata.js');?>"></script> -->

	<!-- <script type="text/javascript">
		$(document).ready(function() {
    $('#example').DataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false
    } );
} );
	</script> -->

