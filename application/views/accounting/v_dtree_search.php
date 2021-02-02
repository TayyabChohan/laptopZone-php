<?php $this->load->view('template/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dynamic Tree
        <small>Tree</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tree View</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
        
    <!-- Main content -->
    <input id ="root_click" type="button" name="add_root" class="btn btn-info btn-lg" value ="Add Root">
    <input id ="struc_id" type="TEXT" name="struc_id" value="<?php echo $this->uri->segment(4); ?>">
    <input id ="segment_no" type="TEXT" name="segment_no" value="<?php echo $this->uri->segment(5); ?>">
    <input id ="dependent_on" type="TEXT" name="dependent_on" value="<?php echo $this->uri->segment(6); ?>">
    <input id ="qualifier_id" type="TEXT" name="qualifier_id" value="<?php echo $this->uri->segment(7); ?>">
    <input id ="has_dep_val" type="TEXT" name="has_dep_val" value="<?php echo $this->uri->segment(8); ?>">
    <?php 
     
        $struc_id = $this->uri->segment(4);
        $segm_id = $this->uri->segment(5); 
        $dependent_on = $this->uri->segment(6); 
        $qual_id = $this->uri->segment(7);
        $has_dep_val = $this->uri->segment(8);
    ?>

<!--     //<input type="submit" title="Search Item" class="btn btn-primary" name="insert" value="Search"> -->
<section class="content">
      <div class="row">
        <div class="col-sm-12">
          
     <?PHP 
    $dependents_on = $this->uri->segment(6);
    if($dependents_on != 0){?>
          <div class="box">

              <div class="box box-body">
                
                <form method="post" action="<?php echo base_url().'accounting/c_tree/tree_list/'.$struc_id.'/'.$segm_id.'/'.$dependent_on.'/'.$qual_id.'/'.$has_dep_val?>">
        
                    <div class="col-sm-8">
                      <div class="form-group">
                          <select name="dependent_key" class="form-control" id ="dependent_key" data-live-search="true" >
                              
                              <?php foreach($depkey['query_two'] as $row){

                                  $test = $_POST['dependent_key'];

                                  if($row['DEP_ON_KEY_ID'] == $_POST['dependent_key'])
                                    {
                                       $isSelected = ' selected="selected"'; // if the option submited in form is as same as this row we add the selected tag
                                    } 
                                  else 
                                    {
                                        $isSelected = ''; // else we remove any tag
                                    }
                                  
                                  echo "<option value='".$row['DEP_ON_KEY_ID']."'".$isSelected.">".$row['DEP_ON_KEY_DESC']."</option>";
                              } ?>
                          </select>
                          
                      </div>                                     
                    </div>

                    <div class="col-sm-2">
                      <div class="form-group">

                      
                        <!-- <input type="text" name="dependent_on" value="<?php //echo $this->uri->segment(6); ?>"> -->
                        <input type="submit" title="Search Item" class="btn btn-primary" name="search" value="Search">

                      </div>
                    </div>
                </form>
    
               </div>
            </div>  

    <?php }
   
    ?>

<?php if($this->input->post('search')){ ?>
<div class="box">
  <ul class="tree well">

    <?php   
  
    foreach($tree['query'] as $list):
      if ($list['PARENT_ID'] == 0){?>
        <li>
        
        <a href = "#" onclick="edit_book(<?php echo $list['SEGMENT_ID'];?>)"><?php echo $list['SEGMENT_VALUE_DESC'];?></a>

          <?php $id = $list['ID'];
          sub($tree,$id);?>
        </li>
      <?php }?>
    <?php endforeach ;?>

  </ul>  
</div>
<?php } ?>
<!-- 
tree function code -->
<?php        

function sub($tree,$id){ 

  // $URI = $_SERVER['REQUEST_URI'];
  // $link= explode('/',$URI);
  // $struc_id = $link[5];
  // $segm_id = $link[6];
  // $dependent_on = $link[7];
  // $qual_id = $link[8];
  //$has_dep_val = $link[8];

  ?>          
  <?php foreach($tree['query'] as $child):?>

    <?php if($child['PARENT_ID'] == $id)
    { ?>

      <ul>
 <li><a href = "#" onclick="edit_book(<?php echo $child['SEGMENT_ID'];?>)"><?php echo $child['SEGMENT_VALUE_DESC'];?></a>

          <?php sub($tree,$child['ID']);?>
        </li>

      </ul>

    <?php }?>

  <?php endforeach ;?>

<?php }
?>
   
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               
            </div>
            
            <div class="modal-body form">
                 <!-- FORM ACTION BASE URL -->
              <form >
                        
                               
                        <div >
                       <!--  <input type="tel" name="" value="<?php //echo $test1 ?>">  -->               
                        <input  id ="add" name="insert" value="Add Child" class="btn btn-info" />  
                        <input id ="view" name="insert" value="View Child" class="btn btn-success" /> 
                     
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                </form>
            </div>
           
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    </section>

    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
  
 <script>
  function edit_book(id){
    $('#modal_form').modal('show');


    var struc_id = $('#struc_id').val();
    var segm_id  = $('#segment_no').val();
    var dependent_on = $('#dependent_on').val();
    var qual_id  = $('#qualifier_id').val();
    var undefine  = $('#undefine').val();
    var segment_id = id;
    var struc_id2 = $('#struc_id').val();
    var dependent_key = $('#dependent_key').val();

 $('#add').click(function(){
    var clickedID = this.id;
    //alert(myid);
    window.location.href ='<?php echo base_url();?>accounting/c_tree/seg_add_lov/'+struc_id+'/'+segm_id+'/'+dependent_on+'/'+qual_id+'/'+undefine+'/'+segment_id+'/'+struc_id2;
});
  $('#view').click(function(){
     var clickedID = this.id;
    //alert(myid);
    window.location.href ='<?php echo base_url();?>accounting/c_tree/seg_update_lov/'+struc_id+'/'+segm_id+'/'+dependent_on+'/'+qual_id+'/'+undefine+'/'+segment_id+'/'+struc_id2;
});


}

</script>


<script>    
$("#root_click").click(function(){

   var cat_id = $('#category_id').val();

   var catalog_id = $('#catalog_id').val();
   // alert(catalog_id);
   // return false;
   var lz_bd_cata_id = $('#lz_bd_cata_id').val();
   // alert(lz_bd_cata_id);
   // return false;
    // var struc_id = $('#struc_id').val();
    // var segment_no = $('#segment_no').val();
    // var dependent_on = $('#dependent_on').val();
    // var qualifier_id = $('#qualifier_id').val();
    // dependend key value when select tree from lov 
    var dependent_key = $('#dependent_key').val();
     //alert(dependent_key); return false;
///'+cat_id+'/'+catalog_id+'/'+lz_bd_cata_id
    window.location.href ='http://192.168.0.78:8081/laptopzone/catalogueToCash/c_add_comp/kitComponents/'+cat_id+'/'+catalog_id+'/'+lz_bd_cata_id;
  });
  /*=====  End of edit by Yousaf  ======*/
    
  
</script>






















        <style>
  .treemenu li { list-style: none; }
.treemenu .toggler { cursor: pointer; }
.treemenu .toggler:before { display: inline-block; margin-right: 2pt; }
li.tree-empty > .toggler { opacity: 0.3; cursor: default; }
li.tree-empty > .toggler:before { content: "\2212"; }
li.tree-closed > .toggler:before { content: "+"; }
li.tree-opened > .toggler:before { content: "\2212"; }

.tree { background-color:#2C3E50; color:#46CFB0;}
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

</style>

<script >
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
</script>




