<?php
  if (!defined('_GNUBOARD_')) exit;

  // 사이트 정보 초기화
  function initSiteinfo(){
    $createSiteinfo = "
      CREATE TABLE IF NOT EXISTS `adm_siteinfo` (
      `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '행 고유번호',
        `open` int(11) NOT NULL COMMENT '사이트 오픈여부',
        `temp` int(11) DEFAULT NULL COMMENT '임시홈페이지 여부',
        `version` int(11) DEFAULT NULL COMMENT '사이트 버전',
        `title` varchar(255) NOT NULL COMMENT '사이트 이름',
        `company` varchar(255) DEFAULT NULL COMMENT '상호명',
        `owner` varchar(255) DEFAULT NULL COMMENT '대표자 성명',
        `tel` varchar(255) DEFAULT NULL COMMENT '대표전화번호',
        `email` varchar(255) DEFAULT NULL COMMENT '대표이메일',
        `account` varchar(255) DEFAULT NULL COMMENT '계좌번호',
        `biznum1` varchar(255) DEFAULT NULL COMMENT '사업자등록번호',
        `biznum2` varchar(255) DEFAULT NULL COMMENT '통신판매번호',
        `address` varchar(255) DEFAULT NULL COMMENT '주소',
        `address2` varchar(255) DEFAULT NULL COMMENT '주소 상세',
        `map_key` varchar(255) DEFAULT NULL COMMENT '지도 api key',
        `marker` varchar(255) DEFAULT NULL COMMENT '마커제목',
        `mapx` varchar(255) DEFAULT NULL COMMENT '지도 x좌표',
        `mapy` varchar(255) DEFAULT NULL COMMENT '지도 y좌표',
        `mapzoom` varchar(255) DEFAULT NULL COMMENT '지도 레벨',
        `meta_url` varchar(255) DEFAULT NULL COMMENT '메타URL',
        `meta_kwd` varchar(255) DEFAULT NULL COMMENT '메타키워드',
        `meta_desc` varchar(255) DEFAULT NULL COMMENT '메타설명',
        `meta_mstr` varchar(255) DEFAULT NULL COMMENT '메타소유인증',
        `as_1` varchar(255) DEFAULT NULL COMMENT '여분필드1',
        `as_2` varchar(255) DEFAULT NULL COMMENT '여분필드2',
        `as_3` varchar(255) DEFAULT NULL COMMENT '여분필드3',
        `as_4` varchar(255) DEFAULT NULL COMMENT '여분필드4',
        `as_5` varchar(255) DEFAULT NULL COMMENT '여분필드5',
        `as_6` varchar(255) DEFAULT NULL COMMENT '여분필드6',
        `as_7` varchar(255) DEFAULT NULL COMMENT '여분필드7',
        `as_8` varchar(255) DEFAULT NULL COMMENT '여분필드8',
        `as_9` varchar(255) DEFAULT NULL COMMENT '여분필드9',
        `as_10` varchar(255) DEFAULT NULL COMMENT '여분필드10',
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='홈페이지 설정 및 정보';
      ";
      $createSiteinfoResult = sql_query($createSiteinfo);

      //생성된 행이 없을 경우에 행 삽입
      $checkinfo_query = "SELECT * FROM adm_siteinfo";
      $checkinfo_result = sql_query($checkinfo_query);
      if ($checkinfo_result->num_rows < 1) {
        $insertSiteinfoRow = "
          INSERT adm_siteinfo SET
            id              = 1,
            open				    = 0,
            temp				    = 0,
            version				  = 0,
            title			     	= '',
            company			   	= '',
            owner			     	= '',
            tel			       	= '',
            account		  		= '',
            biznum1			   	= '',
            biznum2			   	= '',
            address		    	= '',
            map_key			  	= '',
            marker			  	= '',
            mapx			    	= '127.748108101568',
            mapy		     		= '37.8833118829931',
            mapzoom		     	= '2',
            meta_url				= '',
            meta_kwd				= '',
            meta_desc				= '',
            meta_mstr				= '',
            as_1				= '',
            as_2				= '',
            as_3				= '',
            as_4				= '',
            as_5				= '',
            as_6				= '',
            as_7				= '',
            as_8				= '',
            as_9				= '',
            as_10				= ''
        ";
        $insertSiteinfoResult = sql_query($insertSiteinfoRow);
      }
  }

  // 사이트 메뉴 초기화
  function initSitemenu(){
    $createTable = "
    CREATE TABLE IF NOT EXISTS `adm_menu` (
      `id`        INT(11)         NOT NULL    AUTO_INCREMENT COMMENT '행 고유번호',
      `mid`       VARCHAR(255)    NOT NULL    COMMENT '메뉴 ID',
      `m_order`   VARCHAR(255)    NOT NULL    COMMENT '메뉴 순서',
      `m_title`   VARCHAR(255)    NOT NULL    COMMENT '메뉴 제목',
      `m_type`    VARCHAR(255)    NOT NULL    COMMENT '메뉴 종류',
      `m_use`     INT(11)         NULL        COMMENT 'PC에서 사용',
      `m_nw`      INT(11)         NULL        COMMENT 'PC에서 새창',
      `m_url`     VARCHAR(255)    NULL        COMMENT 'PC URL',
      `mb_use`    INT(11)         NULL        COMMENT '모바일에서 사용',
      `mb_nw`     INT(11)         NULL        COMMENT '모바일에서 새창',
      `mb_url`     VARCHAR(255)    NULL        COMMENT '모바일 URL',
      `template`  VARCHAR(255)    NULL        COMMENT '페이지 템플릿',
      `parent_order`  VARCHAR(255)    NULL        COMMENT '부모 메뉴순서',
      `am_1`  VARCHAR(255)    NULL        COMMENT '여분필드1',
      `am_2`  VARCHAR(255)    NULL        COMMENT '여분필드2',
      `am_3`  VARCHAR(255)    NULL        COMMENT '여분필드3',
      `am_4`  VARCHAR(255)    NULL        COMMENT '여분필드4',
      `am_5`  VARCHAR(255)    NULL        COMMENT '여분필드5',
      `am_6`  VARCHAR(255)    NULL        COMMENT '여분필드6',
      `am_7`  VARCHAR(255)    NULL        COMMENT '여분필드7',
      `am_8`  VARCHAR(255)    NULL        COMMENT '여분필드8',
      `am_9`  VARCHAR(255)    NULL        COMMENT '여분필드9',
      `am_10`  VARCHAR(255)    NULL        COMMENT '여분필드10',
      PRIMARY KEY (id),
      UNIQUE KEY (mid)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='홈페이지 메뉴 설정';
    ";
    $createTableResult = sql_query($createTable);
  }

  // 모바일 확인
  function isMobile() {
      return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
  }

  //홈페이지 설정 값 리턴
  function getSiteinfo(){
    $sql = "SELECT * FROM adm_siteinfo";
    $siteinfo = sql_fetch($sql);
    return $siteinfo;
  }

  //홈페이지 메뉴 DB에서 가져오기
  function getSitemenu(){
    $sql = "SELECT * FROM adm_menu ORDER BY m_order+0 ASC";
    $result = sql_query($sql);
    while($row = sql_fetch_array($result)) {
      $order = $row['m_order'];
      $checkMain = substr($order, 0, 2);
      $checkSub = substr($order, -2);
      $sitemenu['total'][$checkMain][$order] = $row;
      if ($row['m_type'] === 'room') {
        $sitemenu['every_room'][] = $row;
        if ($row['m_use'] === '1') {
          $sitemenu['room']['pc'][] = $row;
        }
        if ($row['mb_use'] === '1') {
          $sitemenu['room']['mb'][] = $row;
        }
      };
      if ($checkSub === '00') {
        $sitemenu['main'][$checkMain][$order] = $row;
        $sitemenu['group'][$checkMain]['main'][$checkSub] = $row;
      } else {
        $sitemenu['sub'][$checkMain][$order] = $row;
        $sitemenu['group'][$checkMain]['sub'][$checkSub] = $row;
      }
    }
    return $sitemenu;
  }

  //디렉토리의 1단계 서브 디렉토리 가져오기. 매개변수는 /로 끝나면 안됨.
  function getDirList($dirname){
    $dirname = substr($dirname, -1) === '/' ? $dirname : $dirname.'/';
    $dir_array = array();
    $handle = opendir($dirname);
    while ($file = readdir($handle)) {
        if($file == '.'||$file == '..') continue;
        if (is_dir($dirname.$file)) $dir_array[$file] = $file;
    }
    closedir($handle);
    // sort($dir_array); //배열 키값을 1, 2, 3, 4로 바꿔줌
    return $dir_array;
  }

  //
  function getGnb($device = 'pc'){
    $prefix = $device === 'mobile' ? 'mb' : 'm';
    // 사용중지 목록 순서값 배열에 담음
    $query = "SELECT * FROM adm_menu WHERE {$prefix}_use != '1'";
    $result = sql_query($query);
    while($row = sql_fetch_array($result)) {
      $banOrderArr[] = $row['m_order'];
    }
    // 배열에 담긴 순서중단값이 부모의 순서값과 일치하는 것 제외시킴(사용 중단된 부모의 하위메뉴 제외)
    $querySearch = '';
    if (isvar($banOrderArr)) {
      foreach($banOrderArr as $index => $value) {
        $querySearch = $querySearch." AND parent_order != '{$value}'";
      }
    }
    // 사용중인 메뉴를 가져옴
    $query = "SELECT * FROM adm_menu WHERE {$prefix}_use = '1'".$querySearch;
    $result = sql_query($query);
    while($row = sql_fetch_array($result)) $gnbOriginal[] = $row;
    foreach($gnbOriginal as $index => $value) {
      // 메뉴종류 > 템플릿여부 > URL 여부 순에 따라 URL 세팅
      if ($value['m_type'] === 'board') $value[$prefix.'_url'] = G5_URL.'/board/'.$value['mid'];
      else if (!empty($value['template'])) $value[$prefix.'_url'] = G5_URL.'/'.$value['mid'];
      // 메인메뉴, 서브메뉴 각 배열에 담음
      if ($value['m_order'] === $value['parent_order']) $gnb['main'][$value['parent_order']] = $value;
      else $gnb['sub'][$value['parent_order']][] = $value;
    }
    // 메인메뉴에 URL 세팅값이 없을 경우, 가장 근접한 서브메뉴의 URL을 가져오도록 함.
    foreach($gnb['main'] as $key => $value) {
      if ($value['m_type'] !== 'board' && empty($value[$prefix.'_url']) && empty($value['template'])) {
        $gnb['main'][$key][$prefix.'_url'] = $gnb['sub'][$key][0][$prefix.'_url'];
      }
    }
    return $gnb;
  }

  //경로상의 폴더와 파일들 권한 변경
  function chmod_r($path) {
    $dir = new DirectoryIterator($path);
    foreach ($dir as $item) {
      chmod($item->getPathname(), 0777);
      if ($item->isDir() && !$item->isDot()) {
        chmod_r($item->getPathname());
      }
    }
  }

  //관리자인지 확인 설정 : 레벨 8이상이거나, 'super' 관리자
  function checkAdmin(){
    global $member, $is_admin;
    if ($member['mb_level'] >= 8 || $is_admin == 'super') return true;
    else return false;
  }
  $apms = checkAdmin();

  //문자화 된 json데이터 다시 php 배열로 조립
  function remakeJson($json){
    $strip = stripslashes($json);
    return json_decode($strip, true);
  }

  //첨부된 이미지 파일 유효성 검사
  function validationImageFile($receivedFile){
    if(isset($receivedFile)) {
      $errors     = array();
      $maxsize    = 5242880; //5mb
      $acceptable = array(
        'image/jpg',
        'image/jpeg',
        'image/png',
      );
      if(($receivedFile['size'] >= $maxsize) || ($receivedFile['size'] == 0)) {
          $errors[] = '파일이 너무 큽니다.';
      }
      if (!in_array($receivedFile['type'], $acceptable) && (!empty($receivedFile['type']))) {
          $errors[] = '파일형식이 잘못 되었습니다.';
      }
      if(count($errors) === 0) {
          return true;
      } else {
          return false;
      }
    }
  }

  // 버전업데이트
  function versionUpdate(){
    $version = time();
    $sql = "UPDATE adm_siteinfo SET `version` = {$version}";
    $result = sql_query($sql);
    return $result;
  }
  function getVersionUpdate(){
    $sql = "SELECT * FROM adm_siteinfo WHERE id = '1'";
    $result = sql_fetch($sql);
    $result = $result['version'];
    return $result;
  }

  //오픈그래프 이미지 가져오기
  function getOgImage(){
    global $siteinfo;
    $fileName = 'og_image_default.png';
    $ogImagePng = file_exists(DINGS_IMG_PATH.'/og_image.png');
    $ogImageJpg = file_exists(DINGS_IMG_PATH.'/og_image.jpg');
    if ($ogImageJpg) $fileName = 'og_image.jpg';
    if ($ogImagePng) $fileName = 'og_image.png';
    $ogImage = DINGS_IMG.'/'.$fileName;
    return $ogImage;
  }
  
  function isVar($var){
    if (isset($var) && !empty($var)) return true;
    else return false;
  }

  function checkSetReturnEmpty($value){
    if (isset($value)) echo $value;
    else echo '';
  }

  function getMenuData($mid){
    $result = sql_fetch("SELECT * FROM adm_menu WHERE mid = '{$mid}'");
    return $result;
  }

  $siteinfo = getSiteinfo();
  $dingsVersion = getVersionUpdate();

  //개발자 모드
  $developMode = false;
  $developMode = $developMode ? $developMode : false;
  $dingsVersion = ($developMode === true) ? time() : $dingsVersion;
  if ($developMode === true) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
  }

  // gnb가져오기;
  $gnb = getGnb();
  $gnbMobile = getGnb('mobile');
  $gnb['siblings'] = $gnb['sub'][$current['parent_order']];
?>
