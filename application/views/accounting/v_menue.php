<?php $this->load->view('template/header');?>


  <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dynamic Menue
        <small>Menu</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dynamic Menue</li>
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

            <ul  class="tree well">
            <?php foreach($dropdown['st_dat'] as $menu): ?> 
  
    <?php if($menu['ST_ID'] != $menu['TYPE_ID']) :?>  
     
         <li><a href="#"><?php echo $menu['NAME']; ?></a>
        

    <?php else :?>
        <li><a href="#">
       <?php echo $menu['NAME']; 
        ?></a>          
              
              <?php foreach($sub_menu['type_data'] as $type):
           
              $sub_menu_id = $type['STRUCTURE_ID'];
              ?> 
             
           
                  <?php if($menu['ST_ID']  == $type['STRUCTURE_TYPE_ID']) :?>
                     <ul>
                      <li><a href="#"><?php echo $type['STRUCTURE_DESC'];?></a>
                         <!--   foreach nested 3rd level -->
                            
                              <?php foreach ($seg_menu['segm_data'] as $seg):?>
                                  
                              <?php 
                                 
                                  if($sub_menu_id == $seg['STRUCTURE_ID'])
                                  { ?>
                                   <ul>
                                  <li>
                                 <?php $emp = $seg['DEPENDENT_ON_SEGMENT_NO']; 
                                 ?> 
<a href="<?php echo base_url();?>accounting/c_tree/tree_list/<?php echo $seg['STRUCTURE_ID']; ?>/<?php echo $seg['SEGMENT_NO'];?>/<?php echo $seg['DEPENDENT_ON_SEGMENT_NO'];?>/<?php echo $seg['QUALIFIER_ID'];?>/<?php echo $seg['HAS_DEP_SEG_YN'];?>" target="_blank"><?php echo $seg['SEGMENT_DESC'];?></a>
 


<!-- 
                                     struc<input type="text" name="structure_id"  value=<?php //echo $seg->STRUCTURE_ID;?> />
                                    seg<input type="text" name="segment_no"  value=<?php //echo $seg->SEGMENT_NO;?> />
                                   
                                    dep_key<input type="text" name="structure_id"  value=<?php //echo $seg->DEPENDENT_ON_SEGMENT_NO;?> />
                                    
                                  QUA_ID<input type="text" name="structure_id"  value=<?php //echo $seg->QUALIFIER_ID;?> />  -->
                                 <!--  HAS_DEP_SEG_YN <input type="text" name="structure_id"  value=<?php// echo $seg['DEPENDENT_ON_SEGMENT_NO'];?> />
                                  HAS_DEP_SEG_YN <input type="text" name="structure_id"  value=<?php// echo $seg['HAS_DEP_SEG_YN'];?> /> -->
                                  
                                  </li>
                                  </ul>
                                <?php  
                                  }
                                ?>
                                  
                              <?php endforeach ;?>
                              
                          <!--   end foreach nested 3rd level -->
                       </li>
                       </ul>
                <?php endif;?>
                
                <!-- end of     2nd foreach loop -->
              <?php endforeach ;?>
             
             <!--  </ul> -->
                
      
      </li>

  </li>
    <?php endif ;?>
   <!-- end of 1st foreach loop -->

<?php endforeach ; ?>
</ul>
                        
                        


          </div>  
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div> 

<?php $this->load->view('template/footer');?>
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
