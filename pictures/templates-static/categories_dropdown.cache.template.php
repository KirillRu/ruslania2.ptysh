<?

define("TEMPLATE_CACHE_PATH", "template-cache/");

class CCacheTemplate_AllCategoriesDropdown extends CCommonTask
{
    var $__dataFileName = NULL;
    var $__flagFileName = NULL;
    
    function CCacheTemplate_AllCategoriesDropdown()
    {
        $this->__dataFileName = TEMPLATE_CACHE_PATH."categories_dropdown.html.php";
        $this->__flagFileName = $this->__dataFileName.".process";
    }

    function getIncludePath()
    {
        if (!$this->__inCache())
        {
            $buff = "<select class=sort>";
            //
            // ------------------------------------------------------------------------------
            //
            // NOTE: create "Books" categories list
            //
            require_once("books_catalog_items.class.php");
            $o = new CBooksCatalog_Items();
            $this->setResources($o);
            $col = $o->getAllCategories();
            
            $buff .= '<option style="background-color:#758495; color: white">&nbsp;-&nbsp;'.
                     $this->ui->item('A_GOTOBOOKS');
            
            while($col->next())
            {
                $f = $col->item();
                $buff .= '<option value="'.$f->url.'">, '.$f->title;
            }
            //
            // ------------------------------------------------------------------------------
            //
            // NOTE: create "Pereodicals" categories list
            //
            require_once("pereod_catalog_items.class.php");
            $o = new CPereodicalsCatalog_Items();
            $this->setResources($o);
            $col = $o->getAllCategories();
            
            $buff .= '<option style="background-color:#758495; color: white">&nbsp;-&nbsp;'.
                     $this->ui->item('A_GOTOPEREODICALS');
            
            while($col->next())
            {
                $f = $col->item();
                $buff .= '<option value="'.$f->url.'">, '.$f->title;
            }
            //
            // ------------------------------------------------------------------------------
            //
            // NOTE: create "Audio" categories list
            //
            require_once("audio_catalog_items.class.php");
            $o = new CAudioCatalog_Items();
            $this->setResources($o);
            $col = $o->getAllCategories();
            
            $buff .= '<option style="background-color:#758495; color: white">&nbsp;-&nbsp;'.
                     $this->ui->item('A_GOTOAUDIO');
            
            while($col->next())
            {
                $f = $col->item();
                $buff .= '<option value="'.$f->url.'">, '.$f->title;
            }
            //
            // ------------------------------------------------------------------------------
            //
            // NOTE: create "Video" categories list
            //
            require_once("video_catalog_items.class.php");
            $o = new CVideoCatalog_Items();
            $this->setResources($o);
            $col = $o->getAllCategories();
            
            $buff .= '<option style="background-color:#758495; color: white">&nbsp;-&nbsp;'.
                     $this->ui->item('A_GOTOVIDEO');
            
            while($col->next())
            {
                $f = $col->item();
                $buff .= '<option value="'.$f->url.'">, '.$f->title;
            }
            //
            // ------------------------------------------------------------------------------
            //
            // NOTE [21.04.2006 17:33][Dain]: (added) create "Printed" categories list
            //
            require_once("printed_catalog_items.class.php");
            $o = new CPrintedCatalog_Items();
            $this->setResources($o);
            $col = $o->getAllCategories();
            
            $buff .= '<option style="background-color:#758495; color: white">&nbsp;-&nbsp;'.
                     $this->ui->item('A_GOTOPRINTED');
            
            while($col->next())
            {
                $f = $col->item();
                $buff .= '<option value="'.$f->url.'">, '.$f->title;
            }
            
            $buff .= "</select>";

            $this->__makeCache($buff);
        }
        return $this->__dataFileName;
    }
    
    function __makeCache($buffer)
    {
        $state = ignore_user_abort(TRUE);
        
        $f_flag = fopen($this->__flagFileName, "w");
        $f_main = fopen($this->__dataFileName, "w");
        
        fwrite($f_main, $buffer);
        fclose($f_main);
        
        fclose($f_flag);
        unlink($this->__flagFileName);
        
        ignore_user_abort($state);
    }
    
    function __inCache()
    {
        return file_exists($this->__dataFileName) &&
               !file_exists($this->__flagFileName);
    }
    
}

return new CCacheTemplate_AllCategoriesDropdown();

?>