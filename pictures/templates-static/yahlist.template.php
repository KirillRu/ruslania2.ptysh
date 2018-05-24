<?
class CTemplate_YAHLIST extends CCommonTask
{
    var $fields = NULL;

    var $entity_name_map = Array
    (
        ENTITY_ALL          =>  "BOOKS",
        ENTITY_BOOKS        =>  "BOOKS",
        ENTITY_PEREODICS    =>  "PEREOD",
        ENTITY_PRINTED      =>  "PRINTED",
        ENTITY_AUDIO        =>  "AUDIO",
        ENTITY_VIDEO        =>  "VIDEO",
        ENTITY_SHEETMUSIC   =>  "SHEETMUSIC",
        ENTITY_MUSIC        =>  "MUSIC",
        ENTITY_SOFT         =>  "SOFT",
        ENTITY_MAPS         =>  "MAPS"
    );

    function setData(&$r)
    {
        if (strtolower(get_class($r)) !== "ccollection")
        {
            trigger_error("CTemplate::setData() accepts only ccollection class as argument", E_USER_ERROR);
        }
        else
        {
            $this->fields = &$r;
        }
    }

    function get_banner_file()
    {
        $banner_html = "";

        if ( $this->argv->exists("entity") )
        {
            //
            // NOTE: [06.08.2008 13:15][lex] Text banners moved to language constants
            //
            $banner_html = $this->ui->item("TEXT_BANNER_".$this->entity_name_map[$this->argv->data->item("entity")]);
            
            //
            // NOTE: not used anymore
            //
//            $lang = CCatalog::getLanguageModifierFull();
//          $banner_file = 
//             "templates/".
//               "banner_".
//             $this->entity_name_map[$this->argv->data->item("entity")].
//               $lang.
//               ".php";
//            
//            $html = "";
//            if ( file_exists($banner_file) )
//            {
//              $banner_html = file_get_contents($banner_file);
//            }
//            else 
//            {
//              trigger_error("Banner not found at ".$banner_file, E_USER_WARNING);
//            }
//            
//            switch(CCatalog::detect_encoding($banner_html))
//            {
//              case "utf16le":
//                  $banner_html = iconv("UTF-16", $this->ui->item("LANGUAGE_ENCODING")."//TRANSLIT", $banner_html);
//                  break;
//              case "utf8":
//                  $banner_html = iconv("UTF-8", $this->ui->item("LANGUAGE_ENCODING")."//TRANSLIT", $banner_html);
//                  break;
//            }
        }
        
        $banner_html = "<td width=\"40%\" class=\"maintxt\" align=\"center\" nowrap>".
                       $banner_html.
                       "</td>";
        
        return $banner_html;
    }
    
    function getText()
    {

        $pclist = &$this->fields;
        $ui = &$this->ui;

        $buff = array();
        while($pclist->next())
        {
            $pc = $pclist->item();
            if ($pc->url != NULL)
            {
                $buff[] = "<a href=".$pc->url." class=maintxt>".$pc->title."</a>";
            }
            else
            {
                $buff[] = "<span class=maintxtnu>".$pc->title."</span>";
            }
        }
        $buff = @join($buff, "&nbsp;&nbsp;<img src=/pic/cl_m2.gif width=3 height=5 border=0>&nbsp;&nbsp;");

        $ret = "<tr><td>".
               "<!-- you are here !-->".
               "<table width=100% cellspacing=0 cellpadding=0 border=0>".
               "<tr>".
                 "<td width=37 valign=top><img src=/pic1/youarehere.gif width=37 height=35></td>".
                 "<td width=6 valign=top><img src=/pic/null.gif width=6 height=1></td>".
                 "<td width=60% class=maintxt>".
               "<b>".
               $ui->item("You are here").
               ":</b>&nbsp;&nbsp;".
               $buff.
                 "</td>".
                 $this->get_banner_file().
               "</tr>".
               "</table>".
               "<!-- you are here !-->".
               "</td></tr>".
               "<tr><td><div class=itemsep1><img src=/pic/null.gif width=1 height=1 border=0></div></td></tr>";
              
        return $ret;
    }
    
}

return new CTemplate_YAHLIST();

?>