<?php
class xml  {
   /** Written by Aaron Colflesh **/

   /** Updated with phpFlickr 1.4.3 **/

   /** If attributesDirectlyUnderParent is true then a tag's attributes will be merged into
     * the tag itself rather than under the special '_attributes' key.
     * For example: 
     *  false: $tag['_attributes'][$attributeName];
     *  true: $tag[$attributeName]; OR $tag['_attributes'][$attributeName];
     *
     * @var boolean
     */
   var $attributesDirectlyUnderParent = false;
   
   /** If childTagsDirectlyUnderParent is true then a tag's children will be merged into
     * the tag itself rather than under the special '_value' key.
     * For example: 
     *  false: $tag['_value'][$childTagName];
     *  true: $tag[$childTagName];
     *
     * @var boolean
     */
   var $childTagsDirectlyUnderParent = false;
   
   var $caseInsensitive = false;
   
   var $_replace = array('°','&',"\n","");
   var $_replaceWith = array('{deg}', '{amp}', '{lf}','{ESC}');

   function xml($caseInsensitive = false, $attributesDirectlyUnderParent = false, $childTagsDirectlyUnderParent = false)
   {
     $this->caseInsensitive = $caseInsensitive;
     $this->attributesDirectlyUnderParent = $attributesDirectlyUnderParent;
     $this->childTagsDirectlyUnderParent = $childTagsDirectlyUnderParent;
   }
   
   function parse($xml)
   {
       $this->_parser = xml_parser_create();
       
       $this->input = $xml;
       $xml = str_replace($this->_replace, $this->_replaceWith, $xml);
       $xml = str_replace(">{lf}", ">\n", $xml);
       
       unset($this->_struct, $this->_index, $this->parsed);
       xml_set_object($this->_parser, $this);
       xml_parser_set_option($this->_parser, XML_OPTION_CASE_FOLDING, $this->caseInsensitive);
       xml_parser_set_option($this->_parser, XML_OPTION_SKIP_WHITE, 1);
       
       xml_parse_into_struct($this->_parser, $xml, $this->_struct, $this->_index);
       
       $this->parsed = $this->_postProcess($this->_struct);
       $this->parsed = array($this->parsed['_name']=>$this->parsed);
       
       return $this->parsed;
   }
   
   /* You'll note that I used php's array pointer functions in the _postProcess function.
    In fact it looks like I made a foreach overly complicated in the 'open' case of the 
    switch statement. However this is not the case. By using the array pointer functions, 
    each time you go another call deeper (or shallower) in the recursion it doesn't loose 
    its place in the structure array.*/
  function _postProcess() {
    $item = current($this->_struct);
    
    $ret = array('_name'=>$item['tag'], '_attributes'=>array(), '_value'=>null);

    if (isset($item['attributes']) && count($item['attributes'])>0) {
        foreach ($item['attributes'] as $key => $data) {
            if (!is_null($data)) {
                $item['attributes'][$key] = str_replace($this->_replaceWith, $this->_replace, $item['attributes'][$key]);
            }
        }
      $ret['_attributes'] = $item['attributes'];
      if ($this->attributesDirectlyUnderParent)
        $ret = array_merge($ret, $item['attributes']);
    }

    if (isset($item['value']) && $item['value'] != null)
      $item['value'] = str_replace($this->_replaceWith, $this->_replace, $item['value']);
    
    switch ($item['type']) {
      case 'open':
        $children = array();
        while (($child = next($this->_struct)) !== FALSE ) {
          if ($child['level'] <= $item['level'])
            break;
          
          $subItem = $this->_postProcess();
          
          if (isset($subItem['_name'])) {
            if (!isset($children[$subItem['_name']]))
              $children[$subItem['_name']] = array();
          
            $children[$subItem['_name']][] = $subItem;
          }
          else {
            foreach ($subItem as $key=>$value) {
              if (isset($children[$key])) {
                if (is_array($children[$key]))
                  $children[$key][] = $value;
                else
                  $children[$key] = array($children[$key], $value);
              }
              else {
                $children[$key] = $value;
              }
            }
          }
        }
        
        if ($this->childTagsDirectlyUnderParent)
          $ret = array_merge($ret, $this->_condenseArray($children));
        else
          $ret['_value'] = $this->_condenseArray($children);
        
        break;
      case 'close':
        break;
      case 'complete':
        if (count($ret['_attributes']) > 0) {
          if (isset($item['value']))
            $ret['_value'] = $item['value'];
        }
        else {
			if (isset($item['value'])) {
				$ret = array($item['tag']=> $item['value']);
			} else {
				$ret = array($item['tag']=> "");
			}
        }
        break;
    }

    //added by Dan Coulter

    
    /*
    foreach ($ret as $key => $data) {
        if (!is_null($data) && !is_array($data)) {
            $ret[$key] = str_replace($this->_replaceWith, $this->_replace, $ret[$key]);
        }
    }
    */
    return $ret;
  }
  
  function _condenseArray($array) {
    $newArray = array();
    foreach ($array as $key => $value) {
      if (is_array($value) && count($value)==1)
        $newArray[$key] = current($value);
      else
        $newArray[$key] = $value;
    }
    
    return $newArray;
  }
}

?>
