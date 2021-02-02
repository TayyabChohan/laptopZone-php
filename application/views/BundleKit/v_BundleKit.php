<?php $this->load->view("template/header.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        laptop Parts Form
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">laptop Parts Form</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">laptop Parts Form</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

<form style="background: #fff;">
      <div class="col-sm-12">
          <h4 for="inputEmail3" class="col-sm-3 col-form-label pull-left">Internal Parts</h4>    
        <div class="col-sm-12"> 
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">CPU</label>
              <input type="text" class="form-control" id="internal_parts" name="CPU">
            </div>
            
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">RAM</label>
              <input type="text" class="form-control" id="internal_parts" name="RAM">
            </div>
            
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">Video Card</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
        </div>
        <!-- ==============2nd row=============-->
        <div class="col-sm-12">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">Audio Board</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">Hard Drive</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">Motherboard</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
        </div>
        <!-- ==============3nd row=============-->
        <div class="col-sm-12">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">Power Board</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">LED Board</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">Web Cam</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
        </div>
        <!-- ==============4th row=============-->
        <div class="col-sm-12">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">Cable Clips</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">Heat Sinks</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">Modem</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
        </div>  
      </div>
      <!-- ==============External Parts=============-->
        <div class="col-sm-12">
        <h4 for="inputEmail3" class="col-sm-3 col-form-label pull-left">External Parts</h4>
        <div class="col-sm-12">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">Keyboard</label>
              <input type="text" class="form-control" id="internal_parts" name="Keyboard">
            </div>
            
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">Mouse Pad</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">Cooling Fan</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
        </div>
        <!-- ==============2nd row=============-->
        <div class="col-sm-12">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">Battery</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">Palm Rest</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">Cover Doors</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
        </div>
        <!-- ==============3nd row=============-->
        <div class="col-sm-12">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">Optimal Drive</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">Speakers</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label for="">USB Board</label>
              <input type="text" class="form-control" id="internal_parts" name="">
            </div>
            
          </div>
        </div>  
      </div>
      <div class="col-sm-12">
          <button type="submit" class="btn btn-success" style="margin-left:30px; ">Save</button>
        </div>
  </form>           
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>  

<?php $this->load->view("template/footer.php"); ?>