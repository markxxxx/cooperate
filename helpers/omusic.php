<?php declare(strict_types=1)

/*


<li class="trackListRow">
    <ul class="trackListItems">
        <ul class="graphic">
            <li class="trackNumber">1</li>
            <li class="playbtn">
                <a href="http://images.handy.de/fundb/web/290/7117/52333948.mp3">
                <span style="color:White"></span></a>
            </li>
            <li class="trackName"><a href="/9117733/Usher_featuring_Pitbull/Song/DJ_Got_Us_Fallin_In_Love"> 
                <div  id= "less_9117733" onmouseover="showMore('9117733')">DJ Got Us Fallin' In Love by U...</div>
                <div id="more_9117733"  style="display:none;" class="trackNameLongrelease" onmouseout="showLess('9117733')"> 
                DJ Got Us Fallin' In Love by Usher featuring Pitbull </div></a>
            </li>
            

*/



class omusic {

    private $url = 'http://omusic.dstv.com/';

    public function top_10() {
        
        $cache_name = 'music::top_10';
        
        if(($results = Cache::get($cache_name)) === false) {
        
            $dom = new DomDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTMLFile($this->url);
            $xpath = new DOMXpath($dom);
            $elements = $xpath->query('//*[contains(@class, \'graphic\')]');
            
            $results = array();

            foreach ($elements as $element) {
                
                $track_info = $element->getElementsByTagName('li')->item(2);
                
                $results[] = array(
                    'file'      => $element->getElementsByTagName('li')->item(1)->getElementsByTagName('a')->item(0)->getAttribute('href'),
                    'link'      => $track_info->getElementsByTagName('a')->item(0)->getAttribute('href'),
                    'title'     => trim($track_info->getElementsByTagName('div')->item(1)->nodeValue)
                );
                
            }
            
            Cache::set($cache_name, $results, DAY);
            
        }
        
        return $results;
        
    }
}
?>