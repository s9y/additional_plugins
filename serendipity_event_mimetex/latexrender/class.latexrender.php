<?php
/**
 * Based on LaTeX Rendering Class
 * Copyright (C) 2003  Benjamin Zeiss <zeiss@math.uni-goettingen.de>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 * --------------------------------------------------------------------
 * @author Benjamin Zeiss <zeiss@math.uni-goettingen.de>
 * @version v0.8
 * @package latexrender
 *
 *
 *
 * This is not the original version of the LaTeX rendering class, but a pretty heavy modification of it.
 * Please find the original at http://www.mayer.dial.pipex.com/tex.htm
 * I won't say this is better, just different.
 *
 */

class LatexRender {

    // ====================================================================================
    // Variable Definitions
    // ====================================================================================
    var $_picture_path = "";
    var $_tmp_dir = "";
    // i was too lazy to write mutator functions for every single program used
    // just access it outside the class or change it here if nescessary
    var $_latex_path = "/usr/bin/latex";
    var $_dvips_path = "/usr/bin/dvips";
    var $_convert_path = "/usr/bin/convert";
    var $_identify_path="/usr/bin/identify";
    var $_formula_density = 120;
    var $_xsize_limit = 600;
    var $_ysize_limit = 500;
    var $_string_length_limit = 500;
    var $_font_size = 10;
    var $_latexclass = "article"; //install extarticle class if you wish to have smaller font sizes
    var $_tmp_filename;
    var $_image_format = "gif"; //change to png if you prefer
    var $_transparency = false;
    // this most certainly needs to be extended. in the long term it is planned to use
    // a positive list for more security. this is hopefully enough for now. i'd be glad
    // to receive more bad tags !
    var $_latex_tags_blacklist = array(
        "include","def","command","loop","repeat","open","toks","output","input",
        "catcode","name","^^",
        "\\every","\\errhelp","\\errorstopmode","\\scrollmode","\\nonstopmode","\\batchmode",
        "\\read","\\write","csname","\\newhelp","\\uppercase", "\\lowercase","\\relax","\\aftergroup",
        "\\afterassignment","\\expandafter","\\noexpand","\\special"
        );
    var $_errorcode = 0;
	var $_errorextra = "";
	var $_cachefiles = 1;
	var $_extraname = ""; //adds time to stop images being cached by IE


    // ====================================================================================
    // constructor
    // ====================================================================================

    /**
     * Initializes the class
     *
     * @param string path where the rendered pictures should be stored
     * @param string same path, but from the httpd chroot
     */
    function LatexRender($config_array) {
        $this->_picture_path = $config_array['picture_path'];
        $this->_tmp_dir =      $config_array['tmp_dir'];
        $this->_filename =     $config_array['filename'];
        $this->_latex_path =   $config_array['latex_path'];
        $this->_dvips_path =   $config_array['dvips_path'];
        $this->_convert_path = $config_array['convert_path'];
        $this->_transparency = $config_array['transparency'];
        $this->_tmp_filename = md5(rand());
        $this->_image_format = $config_array['filetype'];
    }


    // ====================================================================================
    // private functions
    // ====================================================================================

    /**
     * wraps a minimalistic LaTeX document around the formula and returns a string
     * containing the whole document as string. Customize if you want other fonts for
     * example.
     *
     * @param string formula in LaTeX format
     * @returns minimalistic LaTeX document containing the given formula
     */
    function wrap_formula($latex_formula) {
        $string  = "\documentclass[".$this->_font_size."pt]{".$this->_latexclass."}\n";
        $string .= "\usepackage[latin1]{inputenc}\n";
        $string .= "\usepackage{amsmath}\n";
        $string .= "\usepackage{amsfonts}\n";
        $string .= "\usepackage{amssymb}\n";
        $string .= "\pagestyle{empty}\n";
        $string .= "\begin{document}\n";
        $string .= "$".$latex_formula."$\n";
        $string .= "\end{document}\n";

        return $string;
    }

    /**
     * Renders a LaTeX formula by the using the following method:
     *  - write the formula into a wrapped tex-file in a temporary directory
     *    and change to it
     *  - Create a DVI file using latex (tetex)
     *  - Convert DVI file to Postscript (PS) using dvips (tetex)
     *  - convert, trim and add transparancy by using 'convert' from the
     *    imagemagick package.
     *  - Save the resulting image to the picture cache directory using an
     *    md5 hash as filename. Already rendered formulas can be found directly
     *    this way.
     *
     * @param string LaTeX formula
     * @returns true if the picture has been successfully saved to the picture
     *          cache directory
     */
    function renderLatex($latex_formula) {
        $latex_document = $this->wrap_formula($latex_formula);

        // create temporary latex file
        $fp = fopen($this->_tmp_dir."/".$this->_tmp_filename.".tex","a+");
        fputs($fp,$latex_document);
        fclose($fp);
        if (!is_file($this->_tmp_dir."/".$this->_tmp_filename.".tex")) {
          $this->_errorcode = 1;
          $this->_errorextra = "Unable to create tex file.  There are various reasons this might happen, from the wrong latex mode to invalid pathes. <br />The command was: $command";
          return;
        }
        // create temporary dvi file
        $command = $this->_latex_path." --interaction=nonstopmode -output-directory=".$this->_tmp_dir." ".$this->_tmp_dir."/".$this->_tmp_filename.".tex";
        $status_code = exec($command);
        if (!is_file($this->_tmp_dir."/".$this->_tmp_filename.".dvi")) {
          $this->_errorcode = 1;
          $this->_errorextra = "Unable to create dvi file (".$this->_tmp_dir."/".$this->_tmp_filename.".dvi).  There are various reasons this might happen, from the wrong latex mode to invalid pathes. <br />The command was: $command";
          return;
        }

        // convert dvi file to postscript using dvips
        $command = $this->_dvips_path." -E ".$this->_tmp_dir."/".$this->_tmp_filename.".dvi"." -o ".$this->_tmp_dir."/".$this->_tmp_filename.".ps";
        $status_code = exec($command);
        if (!is_file($this->_tmp_dir."/".$this->_tmp_filename.".dvi")) {
          $this->_errorcode = 1;
          $this->_errorextra = "Unable to create ps file (".$this->_tmp_dir."/".$this->_tmp_filename.".ps).  There are various reasons this might happen, from the wrong latex mode to invalid pathes. <br />The command was: $command";
          return;
        }

        if ($this->_transparency) {
           $trans_string = " -transparent \"#FFFFFF\" ";
        } else {
           $trans_string = "";
        }
        // imagemagick convert ps to image and trim picture
        $command = $this->_convert_path." -quality 100 -unsharp 5 -density ".$this->_formula_density.
                    " -trim ".$trans_string." ".$this->_tmp_dir."/".$this->_tmp_filename.".ps ".
                    $this->_tmp_dir."/".$this->_tmp_filename.".".$this->_image_format;
        $status_code = exec($command);
        if (!is_file($this->_tmp_dir."/".$this->_tmp_filename.".".$this->_image_format)) {
          $this->_errorcode = 1;
          $this->_errorextra = "Unable to create ".$this->_image_format." file (".$this->_tmp_dir."/".$this->_tmp_filename.$this->_image_format.").  There are various reasons this might happen, from the wrong latex mode to invalid pathes. <br />The command was: $command";
          return;
        }

        // copy temporary formula file to cached formula directory
        $filename = $this->_picture_path."/".$this->_filename.".".$this->_image_format;
        $status_code = copy($this->_tmp_dir."/".$this->_tmp_filename.".".$this->_image_format,$filename);
        if (!is_file($this->_tmp_dir."/".$this->_tmp_filename.".".$this->_image_format)) {
          $this->_errorcode = 1;
          $this->_errorextra = "Unable to copy the final file (".$filename.").  There are various reasons this might happen, from the wrong latex mode to invalid pathes.";
          return;
        }
        $this->cleanTemporaryDirectory();
        return true;
    }

    /**
     * Cleans the temporary directory
     */
    function cleanTemporaryDirectory() {
        unlink($this->_tmp_dir."/".$this->_tmp_filename.".tex");
        unlink($this->_tmp_dir."/".$this->_tmp_filename.".aux");
        unlink($this->_tmp_dir."/".$this->_tmp_filename.".log");
        unlink($this->_tmp_dir."/".$this->_tmp_filename.".dvi");
        unlink($this->_tmp_dir."/".$this->_tmp_filename.".ps");
        unlink($this->_tmp_dir."/".$this->_tmp_filename.".".$this->_image_format);
        chdir($current_dir);
    }

}

?>
