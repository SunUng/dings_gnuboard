<?php
$sub_menu = "400100";
include_once('./_common.php');
include_once(G5_PATH.'/dings/config.php');
include_once(DINGS_PATH.'/dings.lib.php');

$version = time();
auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

$saveFlag = false;

if (isset($_FILES) && !empty($_FILES)) {
  $imagePath = DINGS_IMG_PATH;
  
  $validateOg = validationImageFile($regexImage);
  
  if ($validateOg === false) {
    alert('저장할 내용이 없어 저장되지 않았습니다.', './adm_siteinfo.php');
    exit;
  }

  foreach($_FILES as $index => $file) {
    $validation = validationImageFile($_FILES[$index]);
    if ($validation === true) {
      $file_extension = pathinfo($file['name'])['extension'];
      $fileTempName = $file['tmp_name']; // "C:\Bitnami\wampstack-7.1.12-0\php\tmp\php7C4C.tmp"
      if(!empty($file['error'][$index])){
        return false;
      }
      if(!empty($fileTempName) && is_uploaded_file($fileTempName)){ //첨부파일 확인되면...
        if ($index === 'og_image') {
          if (file_exists($imagePath.'/og_image.jpg')) {
            unlink($imagePath.'/og_image.jpg');
          }
          if (file_exists($imagePath.'/og_image.png')) {
            unlink($imagePath.'/og_image.png');
          }
          $result = move_uploaded_file($fileTempName, $imagePath.'/og_image.'.$file_extension); //이미지저장
          chmod($imagePath.'/og_image.'.$file_extension, 0777);
        } else if ($index === 'logo_image') {
          move_uploaded_file($fileTempName, $imagePath.'/logo.'.$file_extension); //이미지저장
          chmod($imagePath.'/logo.'.$file_extension, 0777);
        }
      } else {
        var_dump('첨부된 파일이 없음');
      }
    } else {
      $imageFileError++;
    }
  }
  if ($imageFileError > 0) {
    // echo $imageFileError.'첨부파일에 문제가 있어 이미지가 정상적으로 업로드되지 않았을 수 있습니다.';
  }
  //메타태그 이미지, 썸네일 이미지 저장 E
}


foreach($_POST as $key => $value) {
  if ($key === 'token') continue;
  if (!empty($value)) $saveFlag = true;
}
if ($saveFlag === true) {
  initSiteinfo();
  initSitemenu();

  if (!isset($open)) $open = 0;
  if (!isset($temp)) $temp = 0;
  $open = trim($open);
  $temp = trim($temp);
  $version = trim($version);
  $title = trim($title);
  $company = trim($company);
  $owner = trim($owner);
  $tel = trim($tel);
  $$email = trim($email);
  $account = trim($account);
  $biznum1 = trim($biznum1);
  $biznum2 = trim($biznum2);
  $address = trim($address);
  $address2 = trim($address2);
  $map_key = trim($map_key);
  $marker = trim($marker);
  $mapx = trim($mapx);
  $mapy = trim($mapy);
  $mapzoom = trim($mapzoom);
  $meta_url = trim($meta_url);
  $meta_kwd = trim($meta_kwd);
  $meta_desc = trim($meta_desc);
  $meta_mstr = trim($meta_mstr);
  
  $query_siteinfo = "
    UPDATE adm_siteinfo SET
      `open`      = $open,
      `temp`      = $temp,
      `version`   = $version,
      `title`     = '$title',
      `company`   = '$company',
      `owner`     = '$owner',
      `tel`       = '$tel',
      `email`     = '$email',
      `account`   = '$account',
      `biznum1`   = '$biznum1',
      `biznum2`   = '$biznum2',
      `address`   = '$address',
      `address2`  = '$address2',
      `map_key`   = '$map_key',
      `marker`    = '$marker',
      `mapx`      = '$mapx',
      `mapy`      = '$mapy',
      `mapzoom`   = '$mapzoom',
      `meta_url`  = '$meta_url',
      `meta_kwd`  = '$meta_kwd',
      `meta_desc` = '$meta_desc',
      `meta_mstr` = '$meta_mstr',
      `as_1`      = '$as_1',
      `as_2`      = '$as_2',
      `as_3`      = '$as_3',
      `as_4`      = '$as_4',
      `as_5`      = '$as_5',
      `as_6`      = '$as_6',
      `as_7`      = '$as_7',
      `as_8`      = '$as_8',
      `as_8`      = '$as_8',
      `as_10`     = '$as_10'
    ";
    $query_siteinfo_result = sql_query($query_siteinfo);
    if ($query_siteinfo_result) {
      $query = "UPDATE g5_config SET cf_title = '{$title}'";
      $result = sql_query($query);
    }

  versionUpdate();
  if ($query_siteinfo_result === true) alert('정상적으로 저장되었습니다.', './adm_siteinfo.php');
  else alert('저장을 실패했습니다.', './adm_siteinfo.php');
} else {
  alert('저장할 내용이 없어 저장되지 않았습니다.', './adm_siteinfo.php');
}
?>
