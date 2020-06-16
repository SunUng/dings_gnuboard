<?php
// error_reporting(-1);

$sub_menu = "400200";
include_once('./_common.php');
// include_once(G5_PATH.'/mango/config.php');
// include_once(MANGO_PATH.'/mango.lib.php');

$query = "SELECT * FROM adm_menu";
$result = sql_query($query);
while($row = sql_fetch_array($result)) {
  $sitemenu[] = $row;
}

if (count($sitemenu) > 0 && !empty($sitemenu) && isset($sitemenu)) {
  $xml = new DomDocument('1.0', 'utf-8');
  $xml->formatOutput = true;
  $urlset = $xml->createElement('urlset');
  $urlset -> appendChild(
      new DomAttr('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9')
  );
  $xml -> appendChild($urlset);
  $hostname = G5_URL;
  $lastmodDate = date('c',time());
  $main = $xml->createElement('url');
  $main -> appendChild( $xml->createElement('loc', $hostname) );
  $main -> appendChild( $lastmod2 = $xml->createElement('lastmod', $lastmodDate) );
  $main -> appendChild( $changefreq2 = $xml->createElement('changefreq', 'monthly') );
  $main -> appendChild( $priority2 = $xml->createElement('priority', '0.5') );
  $urlset -> appendChild($main);

  foreach($sitemenu as $key => $entry) {
    if ($entry['m_use'] === '0') continue;
    $prefix = $entry['m_type'] === 'room' ? 'room' : 'page';
    if ($entry['m_type'] === 'room') $prefix = 'room';
    else if ($entry['m_type'] === 'board') $prefix = 'board';
    else $prefix = 'page';
    
    if (isset($entry['m_url']) && !empty($entry['m_url']) && trim($entry['m_url']) !== '') $outputUrl = $entry['m_url'];
    else $outputUrl = G5_URL.'/'.$prefix.'/'.$entry['mid'];

    $url = $xml->createElement('url');
      $url -> appendChild( $xml->createElement('loc', $outputUrl) );
      $url -> appendChild( $lastmod = $xml->createElement('lastmod', $lastmodDate) );
      $url -> appendChild( $changefreq = $xml->createElement('changefreq', 'monthly') );
      $url -> appendChild( $priority = $xml->createElement('priority', '0.5') );
      $urlset -> appendChild($url);
  }
  $xml->save(G5_PATH.'/sitemap.xml');
  alert('사이트맵을 정상적으로 생성하였습니다.', './adm_menu.php');
} else {
  alert('메뉴가 존재하지 않기 때문에 작업을 수행할 수 없습니다.', './adm_menu.php');
}
?>
