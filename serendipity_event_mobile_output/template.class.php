<?php
@define('TEMPLATE_META_NAME',       'NAME');
@define('TEMPLATE_META_AUTHOR',     'AUTHOR');
@define('TEMPLATE_META_DATE',       'DATE');
@define('TEMPLATE_META_VERSION',    'VERSION');
@define('TEMPLATE_META_REQUIRE',    'REQUIRE');
@define('TEMPLATE_META_SUPPORTS',   'SUPPORTS');

class serendipity_template_meta {
    
	var $serendipity_maindir = "";
	var $serendipity_template_dir = "";
	var $template_engine = "";
    var $metainfo;

	public function __construct($template_engine = NULL) {
		global $serendipity;
		$this->serendipity_maindir = $serendipity['serendipityPath'];
		$this->serendipity_template_dir = $serendipity['templatePath'];
        if (empty($template_engine)) {
		  $this->template_engine = $this->serendipity_template_dir . (isset($serendipity['template']) ? $serendipity['template'] . '/' : 'default');
        }
        else if (strpos($template_engine,"/")===false) {
          $this->template_engine = $this->serendipity_template_dir . $template_engine;
        }
        else {
          $this->template_engine = $template_engine;
        }
        $this->loadMetaInfos();
	}

	public function getTemplateDir() {
		return $this->serendipity_maindir . $this->template_engine;
	}
    
    private function loadMetaInfos() {
        $infofilename = $this->getTemplateDir() . '/info.txt';
        if ($f = @fopen($infofilename, "r")) {
            while ( $line = fgets($f, 1000) ) {
                $prop = explode(":",$line,2);
                $this->metainfo[strtoupper(trim($prop[0]))] = trim($prop[1]);
            }
        }
    }
    
    public function getMeta($metaName) {
        if (empty($this->metainfo) || !is_array($this->metainfo) || empty($this->metainfo[$metaName])) {
            return "";
        } 
        else {
            return $this->metainfo[$metaName];
        }
    }
    
    public function supports( $what ) {
        $metavalue = $this->getMeta(TEMPLATE_META_SUPPORTS);
        if (empty($metavalue)) return false;
        $supporting = explode(',',$metavalue);
        $what = strtoupper(trim($what));
        foreach ($supporting as $supp) {
            $supp = strtoupper(trim($supp));
            if ($supp == $what) return true;
        }
        return false;
    }
}
?>