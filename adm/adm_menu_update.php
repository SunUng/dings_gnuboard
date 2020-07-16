<?php
// error_reporting(-1);
// ini_set('display_errors', 'On');

$sub_menu = "400200";
include_once('./_common.php');
include_once(G5_PATH.'/dings/config.php');
include_once(DINGS_PATH.'/dings.lib.php');

$version = time();
auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

$saveFlag = false;
foreach($_POST as $key => $value) {
  if ($key === 'token') continue;
  if (!empty($value)) $saveFlag = true;
}
if ($saveFlag === true) {

  // 중복된 ID가 들어왔을 때 저장하지 않고 되돌아감
  foreach($mid as $key => $value) {
    foreach($mid as $key2 => $value2) {
      if ($key !== $key2) {
        if ($value === $value2) {
          alert('중복된 메뉴ID가 있어 저정할 수 없습니다. 삭제할 메뉴ID와 중복되는 메뉴가 있다면 우선 삭제 작업을 먼저 진행해주세요.', './adm_menu.php');
          die;
        }
      }
    }
  }

  //디비 초기화
  initSiteinfo();
  initSitemenu();

  // 분산된 데이터 맵핑해서 배열로 구하기
  function getMappingData($index){
    $arr = array();
    global $id, $todo, $old, $m_order, $mid, $m_title, $m_type, $m_use, $m_nw, $m_url, $mb_use, $mb_nw, $mb_url, $template, $parent_order;
    $arr['id'] = $id[$index];
    $arr['todo'] = $todo[$index];
    $arr['old'] = $old[$index];
    $arr['m_order'] = $m_order[$index];
    $arr['mid'] = $mid[$index];
    $arr['m_title'] = $m_title[$index];
    $arr['m_type'] = $m_type[$index];
    $arr['m_use'] = $m_use[$index];
    $arr['m_nw'] = $m_nw[$index];
    $arr['m_url'] = $m_url[$index];
    $arr['mb_use'] = $mb_use[$index];
    $arr['mb_nw'] = $mb_nw[$index];
    $arr['mb_url'] = $mb_url[$index];
    $arr['template'] = $template[$index];
    $arr['parent_order'] = $parent_order[$index];
    return $arr;
  }
  foreach($todo as $index => $value) {
    if ($value === 'removed') {
      $removed[$index] = getMappingData($index);
    }
    if ($value === 'changed') {
      $changed[$index] = getMappingData($index);
    }
    if ($value === 'created') {
      $created[$index] = getMappingData($index);
    }
    if ($value === 'nothing') {
      $nothing[$index] = getMappingData($index);
    }
  }

  // 체크박스 값이 없는 경우 0 리턴하기
  function validateCheckbox($val){
    if (!isset($val) || empty($val)) $val = 0;
    return $val;
  }

  //삭제 로직
  if (isset($removed) && !empty($removed)) {
    foreach($removed as $index => $value) {
      $del_query = "DELETE FROM adm_menu WHERE id = {$value[id]}";
      $del_result = sql_query($del_query);
      if ($del_result) {
        // DB에서 해당메뉴 row 삭제 성공. 이 아래로 이미지, 연관 테이블 db삭제 로직 진행
        // $value[id] pk값
        // $value[mid] (이미지 폴더명)

        // 요금표 행 삭제 시작
        $price_query = "DELETE FROM adm_pricetable WHERE id = {$value[id]}";
        $price_result = sql_query($del_query);
        // 요금표 행 삭제 끝

        // 이미지 디렉토리 삭제
        // if ($price_result) {
        //   $dirPath = DINGS_IMG_PATH.'/'.$value['mid'];
        //   if (file_exists($dirPath) && is_dir($dirPath)) {
        //       recursiveRemoveDirectory($dirPath);
        //   }
        // }

      }
    }
  }

  //수정 로직
  if (isset($changed) && !empty($changed)) {
    foreach($changed as $index => $value) {

      $old_query = "SELECT * FROM adm_menu WHERE `id` = {$value['id']}";
      $old_result = sql_fetch($old_query);

      $value['m_use'] = validateCheckbox($value['m_use']);
      $value['mb_use'] = validateCheckbox($value['mb_use']);
      $value['m_nw'] = validateCheckbox($value['m_nw']);
      $value['mb_nw'] = validateCheckbox($value['mb_nw']);

      $update_query = "UPDATE adm_menu
        SET       `m_order`   = '{$value['m_order']}',
                  `mid`       = '{$value['mid']}',
                  `m_title`   = '{$value['m_title']}',
                  `m_type`    = '{$value['m_type']}',
                  `m_use`     = {$value['m_use']},
                  `m_nw`      = {$value['m_nw']},
                  `m_url`     = '{$value['m_url']}',
                  `mb_use`    = {$value['mb_use']},
                  `mb_nw`     = {$value['mb_nw']},
                  `mb_url`     = '{$value['mb_url']}',
                  `template`  = '{$value['template']}',
                  `parent_order` = '{$value['parent_order']}'
        WHERE `id` = {$value['id']}
      ";
      $update_result = sql_query($update_query);
      // if ($update_result) {

      //   // 이미지 디렉토리 이름 변경 : mid가 변경된 경우에
      //   if ($old_result['mid'] !== $value['mid']) {
      //     $oldDirPath = DINGS_IMG_PATH.'/'.$old_result['mid'];
      //     if (file_exists($oldDirPath) && is_dir($oldDirPath)) {
      //       $newDirPath = DINGS_IMG_PATH.'/'.$value['mid'];
      //       $result = rename($oldDirPath, $newDirPath);
      //       if ($result) chmod($newDirPath, 0777);
      //     }
      //   }
      // }
    }
  }

  //삽입 로직
  if (isset($created) && !empty($created)) {
    foreach($created as $index => $value) {
      $value['m_use'] = validateCheckbox($value['m_use']);
      $value['mb_use'] = validateCheckbox($value['mb_use']);
      $value['m_nw'] = validateCheckbox($value['m_nw']);
      $value['mb_nw'] = validateCheckbox($value['mb_nw']);
      
      $create_query = "INSERT INTO adm_menu(mid, m_order, m_title, m_type, m_use, m_nw, m_url, mb_use, mb_nw, mb_url, template, parent_order) VALUES('{$value[mid]}', '{$value[m_order]}', '{$value[m_title]}', '{$value[m_type]}', {$value[m_use]}, {$value[m_nw]}, '{$value[m_url]}', {$value[mb_use]}, {$value[mb_nw]}, '{$value[mb_url]}', '{$value[template]}', '{$value[parent_order]}')";
      $create_result = sql_query($create_query);
      // if ($create_result) {
      //   // 이미지 디렉토리 생성
      //   $dirPath = DINGS_IMG_PATH.'/'.$value['mid'];
      //   makeImgDirInDings($dirPath);

      // }
    }
  }

  // 재삽입로 로직
  // 메뉴에 내용 수정은 없으나 디비가 지워진 경우 생성 재삽입
  if (isset($nothing) && !empty($nothing)) { // 기존 데이터는 그냥 두는게 원칙이나, id로 비교해서 행이 없을 때 행을 삽입함.
    foreach($nothing as $index => $value) {
      $nothing_query = "SELECT EXISTS(SELECT * FROM adm_menu WHERE id = {$value[id]}) AS success";
      $nothing_result = sql_fetch($nothing_query);
      if ($nothing_result['success'] === '0') {
        $create_query = "INSERT INTO adm_menu(id, mid, m_order, m_title, m_type, m_use, m_nw, m_url, mb_use, mb_nw, mb_url, template, parent_order) VALUES('{$value[id]}', '{$value[mid]}', '{$value[m_order]}', '{$value[m_title]}', '{$value[m_type]}', {$value[m_use]}, {$value[m_nw]}, '{$value[m_url]}', {$value[mb_use]}, {$value[mb_nw]}, '{$value[mb_url]}', '{$value[template]}', '{$value[parent_order]}')";
        $create_result = sql_query($create_query);
        // if ($create_result) {

        //   // 이미지 디렉토리 생성
        //   $dirPath = DINGS_IMG_PATH.'/'.$value['mid'];
        //   makeImgDirInDings($dirPath);

        // }
      }
    }
  }
  
  alert('정상적으로 저장되었습니다.', './adm_menu.php');
} else {
  alert('저장할 내용이 없습니다.', './adm_menu.php');
}


?>