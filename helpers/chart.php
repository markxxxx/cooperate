<?php
class chart {

    private $chart_lib = 'include/fusioncharts/';

    public function getInstance() {
    
        static $instant;
        
        if(!is_object($instant)) {
            $instant = new chart();
        }
        return $instant;
    
    }
    
    function render($chartSWF, $strXML, $chartId, $chartWidth, $chartHeight, $debugMode) {
    
        $strFlashVars = "&chartWidth=" . $chartWidth . "&chartHeight=" . $chartHeight . "&debugMode=0&dataXML=" . $strXML;

        $HTML_chart = <<<HTMLCHART

            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="$chartWidth" height="$chartHeight" id="$chartId">
                <param name="allowScriptAccess" value="always" />
                <param name="movie" value="{$this->chart_lib}$chartSWF"/>		
                <param name="FlashVars" value="$strFlashVars" />
                <param name="quality" value="high" />
                <embed src="{$this->chart_lib}$chartSWF" FlashVars="$strFlashVars" quality="high" width="$chartWidth" height="$chartHeight" name="$chartId" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
            </object>
HTMLCHART;

        return $HTML_chart;
    }

}
?>