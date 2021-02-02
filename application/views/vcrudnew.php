<?php $this->load->view('template/header');?>

<?php echo form_open('ccrud/save', 'role="form"'); ?>
  <div class="form-group">
    <label for="fn">ITEM ID</label>
    <input type="text" class="form-control" id="template_id" name="template_id">
  </div>
  <div class="form-group">
    <label for="fn">ITEM TITLE</label>
    <input type="text" class="form-control" id="title" name="title">
  </div>
  <div class="form-group">
    <label for="ag">ITEM DESC</label>
    <input type="text" class="form-control" id="desc" name="desc">
  </div>
  <div class="form-group">
    <label for="ad">EBAY PRICE</label>
    <input type="text" class="form-control" id="price" name="price">
  </div>
  <input type="submit" name="mit" class="btn btn-primary" value="Submit">
  <button type="button" onclick="location.href='<?php echo site_url('ccrud') ?>'" class="btn btn-success">Back</button>
</form>
<?php echo form_close(); ?>


<?php $this->load->view('template/footer');?>