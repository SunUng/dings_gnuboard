<?php
include_once('../common.php');
include_once(G5_PATH.'/dings/config.php'); // 경로 등 사전 정의
include_once(DINGS_PATH.'/dings.lib.php');// 함수 라이브러리

$current = getMenuData($mid);
$g5['title'] = $current['m_title'];

if (!isset($current['template']) || empty($current['template'])) {
  header("HTTP/1.0 404 Not Found");
  include_once(G5_PATH.'/404.php');
  exit;
} else {
  if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
  include_once(G5_PATH.'/head.php');
  include_once(TPL_PATH.'/'.$current['template'].'/page.php');
  include_once(G5_PATH.'/tail.php');
}
?>
