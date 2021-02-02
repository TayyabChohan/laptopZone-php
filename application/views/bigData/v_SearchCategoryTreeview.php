<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
<style>
  .treemenu li { list-style: none; }
  .treemenu .toggler { cursor: pointer; }
  .treemenu .toggler:before { display: inline-block; margin-right: 2pt; }
  li.tree-empty > .toggler { opacity: 0.3; cursor: default; }
  li.tree-empty > .toggler:before { content: "\2212"; }
  li.tree-closed > .toggler:before { content: "+"; }
  li.tree-opened > .toggler:before { content: "\2212"; }

  .tree { background-color:#f5f5f5; color:#337ab7;}
  .tree li,
  .tree li > a,
  .tree li > span {
      padding: 4pt;
      border-radius: 4px;
  }

  .tree li a {
     color:#46CFB0;
      text-decoration: none;
      line-height: 20pt;
      border-radius: 4px;
  }

  .tree li a:hover {
      background-color: #34BC9D;
      color: #fff;
  }

  .activ {
      background-color: #34495E;
      color: white;
  }

  .activ a {
      color: #fff;
  }

  .tree li a.activ:hover {
      background-color: #34BC9D;
  }
  .tree > .tree-empty{display: none;}

</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Search Category List Treeview
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Search Category List Treeview</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
    <!-- Insertion Message start-->
        <?php if($this->session->flashdata('success')){ ?>
          <div id="successMessage" class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php }elseif($this->session->flashdata('error')){  ?>

        <div id="errorMessage" class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
        </div>

    <?php } ?>
    <!-- Insertion Message end-->
          <!-- Search by Category Id -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search Category Tree</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>              
            </div>

            <div class="box-body">
              <form action="<?php echo base_url('bigData/c_bigData/searchCategoryTree') ?>" method="post">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="Search Category Id">Search by Category ID:</label>
                    <input type="text" class="form-control" name="category_id" id="category_id" value="<?php echo $this->session->userdata('category_id'); ?>" placeholder="Search by Parent Category ID">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group p-t-24">
                    <input type="submit" class="btn btn-sm btn-primary" name="search_category" id="search_category" value="Search">
                  </div>
                </div>
                
              </form>

              <div class="col-sm-4">
                <di class="form-group"></di>
              </div>
              <div class="col-sm-2">
                <div class="form-group p-t-24">
                  <a class="btn btn-sm btn btn-primary" title="Back to Category Tree View" href="<?php echo base_url('bigData/c_bigData/categoryTreeview'); ?>">Category Tree View</a>
                </div>
              </div>              
            </div>
          </div>
          <!-- Search by Category Id End-->        

          <div class="box">
            <div class="box-body">  
              <div class="col-sm-12">
                <!-- Specific Categories Block -->
                <div class="col-sm-6">
                  <div class="box box-primary" style="margin-bottom: 0px !important;">
                    <a href="#" title="Category Name"><i class="fa fa-circle" aria-hidden="true"></i> Category Tree View</a><span></span>
                  </div>
                  <div class="box-body">
                    <div class="form-group">
                    <?php //var_dump($data);//exit; ?>

                      <ul class="tree well">

                      <?php  
                      //var_dump($data);
                        foreach($data as $list):
                        if ($list['PARENT_ID'] == 0)
                        { ?>
                          <li>
                           <?php echo $list['CATEGORY_NAME'].' - '.$list['ID']; ?> 
                         
                           <?php $id = $list['ID']; 
                             sub($data, $id); 
                           ?>
                          </li>
                        <?php }elseif($list['PARENT_ID'] !== 0){ ?>
                          <li>
                           <?php echo $list['CATEGORY_NAME'].' - '.$list['ID']; ?> 
                         
                           <?php $id = $list['ID']; 
                             sub($data, $id); 
                           ?>
                          </li>
                          <?php } ?>                        
                        <?php endforeach ; ?>
                      </ul>
  
                    </div>
   
                  <!-- tree function code -->
                  <?php        
                  function sub($data, $id){ 
                    foreach($data as $child):  
                      if($child['PARENT_ID'] == $id){
                  ?>

                <ul>
                  <li>
                <?php 
                  echo $child['CATEGORY_NAME'].' - ( '.$child['ID'].' )';  
                  sub($data, $child['ID']); 
                ?>
                  </li>
                </ul>
              <?php }  
                  endforeach;
  //exit;
                }
              ?>                    

                    </div>
                    
                  </div>
                  <!-- Specific Categories Block End-->

               
                </div>  




              </div>          

                <!-- /.col --> 
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
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
<script>
  $(function(){
        $(".tree").treemenu({delay:300}).openActive();
    });

(function($){
    $.fn.treemenu = function(options) {
        options = options || {};
        options.delay = options.delay || 0;
        options.openActive = options.openActive || false;
        options.closeOther = options.closeOther || false;
        options.activeSelector = options.activeSelector || ".activ";

        this.addClass("treemenu");

        if (!options.nonroot) {
            this.addClass("treemenu-root");
        }

        options.nonroot = true;

        this.find("> li").each(function() {
            e = $(this);
            var subtree = e.find('> ul');
            var button = e.find('.toggler').eq(0);

            if(button.length == 0) {
                // create toggler
                var button = $('<span>');
                button.addClass('toggler');
                e.prepend(button);
            }

            if(subtree.length > 0) {
                subtree.hide();

                e.addClass('tree-closed');

                e.find(button).click(function() {
                    var li = $(this).parent('li');

                    if (options.closeOther && li.hasClass('tree-closed')) {
                        var siblings = li.parent('ul').find("li:not(.tree-empty)");
                        siblings.removeClass("tree-opened");
                        siblings.addClass("tree-closed");
                        siblings.removeClass(options.activeSelector);
                        siblings.find('> ul').slideUp(options.delay);
                    }

                    li.find('> ul').slideToggle(options.delay);
                    li.toggleClass('tree-opened');
                    li.toggleClass('tree-closed');
                    li.toggleClass(options.activeSelector);
                });

                $(this).find('> ul').treemenu(options);
            } else {
                $(this).addClass('tree-empty');
            }
        });

        if (options.openActive) {
            var cls = this.attr("class");

            this.find(options.activeSelector).each(function(){
                var el = $(this).parent();

                while (el.attr("class") !== cls) {
                    el.find('> ul').show();
                    if(el.prop("tagName") === 'UL') {
                        el.show();
                    } else if (el.prop("tagName") === 'LI') {
                        el.removeClass('tree-closed');
                        el.addClass("tree-opened");
                        el.show();
                    }

                    el = el.parent();
                }
            });
        }

        return this;
    }
})(jQuery);


      /*===== Insertion Success message auto hide ====*/
        setTimeout(function() {
          $('#successMessage').fadeOut('slow');
        }, 3000); // <-- time in milliseconds

        setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 3000); // <-- time in milliseconds        

    /*===== Insertion Success message auto hide end ====*/  
 

 </script>