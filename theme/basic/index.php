<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/head.php');

$poopup = $isMobile ? G5_MOBILE_PATH.'/newwin.inc.php' : G5_BBS_PATH.'/newwin.inc.php'; 
include_once($poopup);
?>

메인페이지 내용
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>