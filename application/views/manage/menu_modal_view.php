<div class="modal fade" name="photoSetForm" id="photoSetForm">   
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Menü Ayarları</h3>
  </div>
  <div class="modal-body">
  <div class="menu_span">
    <form id="menu_page_add" data-action="<?php echo base_url()?>manage/menu/add">
    <input type="hidden" name="site_id" value="<?php echo $site_id?>">
    <input type="hidden" name="menu_id" value="<?php echo $menu_id?>">
    <input type="hidden" name="prefix" value="<?php echo $prefix?>">

    <label><input type="radio" name="page_type" value="existing"> Varolan Sayfalardan Seç</label>
    <select name="page_id" id="menu_page_id" class="hide">
      <?php 
      foreach($pages[0] as $page):?>
      <option value="<?php echo $page['page_id']?>"><?php echo $page['title']?></option>
          <?php 
          if(isset($pages[$page['page_id']])):
          foreach($pages[$page['page_id']] as $sub_page):?>
              <option value="<?php echo $sub_page['page_id']?>">--><?php echo $sub_page['title']?></option>
              <?php 
                if(isset($pages[$ssub_page['page_id']])):
                foreach($pages[$sub_page->id] as $sub_sub_page):?>
                    <option value="<?php echo $sub_sub_page['page_id']?>">----><?php echo $sub_sub_page['title']?></option>
                <?php 
                endforeach;
                endif;
                ?>
          <?php 
          endforeach;
          endif;
          ?>
    <?php endforeach;?>
    </select>
    <label><input type="radio" name="page_type" value="new" checked> Yeni Sayfa Yarat</label>
    <input type="text" id="menu_page_title" placeholder="Sayfa Adı" name="title"><br>
    <input type="submit" id="subPageAddBut"  data-loading-text="Lütfen bekleyin..." data-complete-text="Ekle" class="btn btn-primary" value="Ekle">
    </form>
  </div>
  </div>
  <div class="modal-footer">
    <a class="btn" data-dismiss="modal">Kapat</a>    
  </div>     
</div>
