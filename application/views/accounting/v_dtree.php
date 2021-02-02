<?php $this->load->view('template/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dynamic Tree
        <small>Trees</small>
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
    <!-- 4 -->
    <?php  $struc_id = $this->session->userdata('struc_id');?> 
    <input id ="struc_id" type="TEXT" name="struc_id" value="<?php echo $struc_id; ?>">
    <!-- 5 -->
    <?php  $segment_no = $this->session->userdata('segment_no');?>
    <input id ="segment_no" type="TEXT" name="segment_no" value="<?php echo $segment_no; ?>">
    <!-- 6 -->
    <?php  $dependent_on = $this->session->userdata('dependent_on');?>
    <input id ="dependent_on" type="TEXT" name="dependent_on" value="<?php echo $dependent_on; ?>">
    <!-- 7 -->
    <?php  $qualifier_id = $this->session->userdata('qualifier_id');?>
    <input id ="qualifier_id" type="TEXT" name="qualifier_id" value="<?php echo $qualifier_id; ?>">
    <!-- 8 -->
    <?php  $has_dep_val = $this->session->userdata('has_dep_val');?>
    <input id ="has_dep_val" type="TEXT" name="has_dep_val" value="<?php echo $has_dep_val; ?>">
    
    <?php 
     
        // $struc_id = $this->uri->segment(4);
        // $segm_no = $this->uri->segment(5); 
        // $dependent_on = $this->uri->segment(6); 
        // $qual_id = $this->uri->segment(7);
        // $has_dep_val = $this->uri->segment(8);
    ?>

<section class="content">
      <div class="row">
        <div class="col-sm-12">

<div class="box">
  <ul class="tree well">
    <?php foreach($tree['query'] as $list):
              if ($list['PARENT_ID'] == 0)
              { ?>
                <li>
                  <a href = "#" onclick="edit_book(<?php echo $list['SEGMENT_ID'];?>)"><?php echo $list['SEGMENT_VALUE_DESC'];?></a>
                  <?php 
                  $id = $list['ID'];
                  sub($tree,$id);?>
                </li>
        <?php }?>
    <?php endforeach ;?>
  </ul>  
</div>

<!-- ***tree function code*** -->

<?php        
function sub($tree,$id){?>          
  <?php foreach($tree['query'] as $child):
        if($child['PARENT_ID'] == $id){ ?>
          <ul>
            <li>
              <a href = "#" onclick="edit_book(<?php echo $child['SEGMENT_ID'];?>)"><?php echo $child['SEGMENT_VALUE_DESC'];?></a>
              <?php sub($tree,$child['ID']);?>
            </li>
          </ul>
    <?php }?>

  <?php endforeach ;
  } ?>
   
        <!-- /.col -->
      </div>
      <!-- /.row -->


      <!-- Bootstrap modal -->
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

    // var struc_id = $('#struc_id').val();
    // var segm_no  = $('#segment_no').val();
    // var dependent_on = $('#dependent_on').val();
    // var qual_id  = $('#qualifier_id').val();
    // var undefine  = $('#undefine').val();
    var segment_id = id;
    // alert(segment_id); return false;
    // var struc_id2 = $('#struc_id').val();
    // var dependent_key = $('#dependent_key').val();

 $('#add').click(function(){
    var clickedID = this.id;
    //alert(myid);
    window.location.href ='<?php echo base_url();?>accounting/c_tree/seg_add_lov/'+segment_id;
});
  $('#view').click(function(){
     var clickedID = this.id;
    //alert(myid);
    window.location.href ='<?php echo base_url();?>accounting/c_tree/seg_update_lov/'+segment_id;
});

}

</script>
<script>    
$("#root_click").click(function(){
    
    var struc_id = $('#struc_id').val();
    var segment_no = $('#segment_no').val();
    var dependent_on = $('#dependent_on').val();
    var qualifier_id = $('#qualifier_id').val();
    // SELECT LIST ID VALUE 
    var dependent_key = $('#dependent_key').val();
     //alert(dependent_key); return false;

    window.location.href ='<?php echo base_url();?>accounting/c_tree/seg_add_lov/'+<?php echo'null' ?>;
  });

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


