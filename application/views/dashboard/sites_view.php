        	<?php foreach($sites as $site):
                    $alert = "";//sitenin yanındaki mesaj
                    $cls = "";
                    //pasiflestirildi
                    if($site['statu']==1){
                        $cls = "passive";
                        $alert = " (".lang('str_passive_site').")";
                    }
                    
                    //silme onati bekliyor
                    if($site['statu']==2){
                        $cls = "passive";
                        $alert = " (".lang('str_delete_site').")";
                    }                    
                            echo "<div class=\"row\" style=\"margin-top:10px;\">
                                    <div class=\"span2\">
                                        <div class=\"thumbnail\">
                                            <img src=\"".base_url()."files/themes/".$site['theme_css']."/screen-mini.jpg\" height=\"75\" width=\"100\"/>
                                        </div>
                                    </div>
                                    <div class=\"span5\">
                                        <h5>".$site['title']."</h5>
                                        <span class=\"".$cls."\">".$site['url']."</span>
                                        <div>Toplam: ".format_size_units($site['package']->storage * 1024 * 1024)."'lık alanının ".format_size_units($site['storage_quota'] * 1024)."'i (%".$site['storage_percentage'].") kullanılıyor.</div>
                                        ";

                                        if (isset($orders[$site['site_id']])) {
                                            foreach($orders[$site['site_id']] as $order):
                                            echo '<div class="alert alert-info">Bu adres <strong>www.'. $order['domain'].'</strong> olarak satın alınmak üzere sipariş edilmiştir. Ödemeniz onaylandıktan sonra siteniz <strong>www.'.$order['domain'].' </strong>olacaktır.</div>';
                                            endforeach;
                                        }
                                        echo $alert;
                        echo "<br /><div class=\"btn-group\">";
                        //kurulum tamamlanmış ve site aktifse
                        if($site['setup'] == false and $site['statu'] == 0){
                            
                            if($site['is_purchased'] == false){
                                //echo "<a href=\"#\" data-action=\"".base_url()."dashboard/domain/".$site['site_id']."\" data-loading-text=\"".lang('str_please_wait')."\" data-complete-text=\"".lang('but_buy')."\" class=\"buy-but btn btn-success\">".lang('but_buy')."</a>";
                            }
                            echo "<a href=\"".base_url()."manage/editor/wellcome/".$site['site_id']."\" class=\"btn btn-primary\">".lang('but_edit')."</a>";
                            echo "<a href=\"".$site['url']."\" target=\"_blank\" class=\"btn\">".lang('but_preview')."</a> ";
                            if($site['is_purchased'] == true){
                                //mail yönetimi
                                echo "<a href=\"#\" data-action=\"".base_url()."dashboard/mails/".$site['site_id']."\" data-loading-text=\"".lang('str_please_wait')."\" data-complete-text=\"".lang('but_mail')."\" class=\"mail-but btn btn-primary\">".lang('but_mail')."</a>";
                            }                           
                        
                        //kurulum tamamlanMamıs ama site aktifse    
                        }elseif($site['statu'] == 0){
                            if($site['is_purchased'] == false){
                                //echo "<a href=\"#\" data-action=\"".base_url()."dashboard/domain/".$site['site_id']."\" data-loading-text=\"".lang('str_please_wait')."\" data-complete-text=\"".lang('but_buy')."\" class=\"buy-but btn btn-success\">".lang('but_buy')."</a>";
                            }
                            echo "<a href=\"#\" data-action=\"".base_url()."dashboard/setup/".$site['site_id']."\" data-loading-text=\"".lang('str_please_wait')."\" data-complete-text=\"".lang('but_setup')."\" class=\"setup-but btn btn-primary\">".lang('but_setup')."</a>";
                        }
                        //İstatistikler
                        echo "<a href=\"#\" data-action=\"".base_url()."stats/index/".$site['site_id']."\" data-loading-text=\"".lang('str_please_wait')."\" data-complete-text=\"İstatistikler\" class=\"stats-but btn\">İstatistikler</a>";                            
                        //silindiyse
                        if($site['statu'] != 2){
                            echo "<a href=\"#\" data-action=\"".base_url()."dashboard/delete/".$site['site_id']."\" data-loading-text=\"".lang('str_please_wait')."\"  data-complete-text=\"".lang('but_delete')."\" class=\"delete-but btn btn-danger\">".lang('but_delete')."</a>";
                        }
                        echo "</div></div>                         
                            </div>";
                        endforeach;?>