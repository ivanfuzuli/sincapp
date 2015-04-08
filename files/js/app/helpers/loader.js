define(['modules/htmls', 'modules/photo_cloud', 'modules/slider_cloud', 'modules/maps', 'modules/menus', 'modules/paragraphs', 'modules/blog', 'modules/documents'],
 function(htmls, photo_cloud, slider_cloud, maps, menus, paragraphs, blog, documents){
    return{
      canCallback: function(ext_type, ext_id){//javascript dosyalarini cagirmaca
            switch(ext_type)
            {
            case "htmls":
              htmls.firstRun(ext_id);
              break;
            case "photo_cloud":
              photo_cloud.firstRun(ext_id);
              break;
            case "slider_cloud":
              slider_cloud.firstRun(ext_id);
              break;    
            case "maps":
              maps.firstRun(ext_id);
              break;
            case "menu": 
                menus.firstRun(ext_id);
                break; 

            case "paragraphs":
                paragraphs.firstRun(ext_id);
                break;
            case "blog_cloud":
                blog.firstRun(ext_id);
                break;
            case "documents":
                documents.firstRun(ext_id);
                break;                                             
            default:
              
            }          
      }        
    }
})