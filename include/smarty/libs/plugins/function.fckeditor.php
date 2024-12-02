<?php

function smarty_function_fckeditor($params, &$smarty)
{   


   if(!isset($params['InstanceName']) || empty($params['InstanceName']))
   {
      $smarty->trigger_error('fckeditor: required parameter "InstanceName" missing');
   }

   static $base_arguments = array();
   static $config_arguments = array();

   // Test if editor has been loaded before
   if(!count($base_arguments)) $init = TRUE;
   else $init = FALSE;
   
   // BasePath must be specified once.
   if(isset($params['BasePath']))
   {
      $base_arguments['BasePath'] = $params['BasePath'];
   }
   else if(empty($base_arguments['BasePath']))
   {
      $base_arguments['BasePath'] = '/FCKeditor/';
   }

   $base_arguments['InstanceName'] = $params['InstanceName'];

   if(isset($params['Value'])) $base_arguments['Value'] = $params['Value'];
   if(isset($params['Width'])) $base_arguments['Width'] = $params['Width'];
   if(isset($params['Height'])) $base_arguments['Height'] = $params['Height'];
   if(isset($params['ToolbarSet'])) $base_arguments['ToolbarSet'] = $params['ToolbarSet'];
   if(isset($params['CheckBrowser'])) $base_arguments['CheckBrowser'] = $params['CheckBrowser'];
   if(isset($params['DisplayErrors'])) $base_arguments['DisplayErrors'] = $params['DisplayErrors'];

   // Use all other parameters for the config array (replace if needed)
   $other_arguments = array_diff_assoc($params, $base_arguments);
   $config_arguments = array_merge($config_arguments, $other_arguments);

   $out = '';

   if($init)
   {
      $out .= '<script type="text/javascript" src="' . $base_arguments['BasePath'] . 'fckeditor.js"></script>';
   }

   $out .= "\n<script type=\"text/javascript\">\n";
   $out .= "var oFCKeditor = new FCKeditor('" . $base_arguments['InstanceName'] . "');\n";

   foreach($base_arguments as $key => $value)
   {
      if(!is_bool($value))
      {
         // Fix newlines, javascript cannot handle multiple line strings very well.
         $value = '"' . preg_replace("/[\r\n]+/", '" + $0"', addslashes($value)) . '"';
         
      }
      
      if($key == 'Value' ) {
        $value = str_replace('</script>','<\/scr"+"ipt>', $value);
      }
      
      $out .= "oFCKeditor.$key = $value; ";
   }

   foreach($config_arguments as $key => $value)
   {
      if(!is_bool($value))
      {
         $value = '"' . preg_replace("/[\r\n]+/", '" + $0"', addslashes($value)) . '"';
      }
      $out .= "oFCKeditor.Config[\"$key\"] = $value; ";
   }

   $out .= "\noFCKeditor.Create();\n";
   $out .= "</script>\n";
   
   return $out;
}
?>