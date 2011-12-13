<?php

define('FPDF_FONTPATH', dirname(__FILE__) . '/font/');
include_once dirname(__FILE__) . '/fpdf.php';
include_once dirname(__FILE__) . '/ufpdf.php';
class PDF extends UFPDF {
    var $TOC = array();

    function Header() {
        global $serendipity;

        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, PLUGIN_EVENT_BLOGPDF_EXPORT .': ' . $serendipity['blogTitle'] . ', ' . $serendipity['baseURL'], 1, 0, 'C');
        $this->Ln(20);
    }

    function Footer() {
        global $serendipity;

        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, PLUGIN_EVENT_BLOGPDF_PAGE . ' ' . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }

    function TOC_Add($header) {
        $this->TOC[] = array(
          'header' => $header,
          'page'   => $this->PageNo(),
          'pos'    => $this->GetY()
        );
    }

    function TOC_Build() {
        $cnt = count($this->TOC);
        if ($cnt < 1) {
            return;
        }

        $first = $this->n+1;
        $last  = $first + $cnt;

        foreach($this->TOC AS $ti => $toc) {
            $this->_newobj();
            $this->_out('<</Title ' . $this->_textstring($toc['header']));

            // This ob has to be the obj reference to the last Outline-Type.
            $this->_out('/Parent ' . ($first + $cnt) . ' 0 R');
            if ($this->n > $first) {
                $this->_out('/Prev ' . ($this->n - 1) . ' 0 R');
            }

            if ($this->n < $last && isset($TOC[$ti+1])) {
                $this->_out('/Next ' . ($this->n + 1) . ' 0 R');
            }

            $this->_out(
              sprintf(
                '/Dest [%d 0 R /XYZ 0 %.2f null]',

                1 + (2*$toc['page']),
                ($this->h - $toc['pos']) * $this->k
              )
            );
            $this->_out('/Count 0>>');
            $this->_out('endobj');
        }

        $this->_newobj();
        $this->OutlineRoot = $this->n;
        $this->_out('<</Type /Outlines /First ' . $first . ' 0 R');
        $this->_out('/Last ' . ($this->n - 1) . ' 0 R>>');
        $this->_out('endobj');
    }

    function _putresources() {
        parent::_putresources();
        $this->TOC_Build();
    }

    function _putcatalog() {
        parent::_putcatalog();
        if(count($this->TOC) > 0) {
            $this->_out('/Outlines '. $this->OutlineRoot . ' 0 R');
            $this->_out('/PageMode /UseOutlines');
        }
    }
}
