<?php
  if (!isset($templateName)) $templateName = getPageMenuValue($mid, 'template');
  $menuType = getPageMenuValue($mid, 'm_type');
  if (empty($templateName) && $menuType === 'board') $templateName = $mid;

  define('PAGE',             TPL.'/'.$templateName);
  define('PAGE_IMG',         PAGE.'/images');
  define('PAGE_JS',          PAGE.'/js');
  define('PAGE_CSS',         PAGE.'/css');

  define('PAGE_PATH',        TPL_PATH.'/'.$templateName);
  define('PAGE_IMG_PATH',    PAGE_PATH.'/images');
  define('PAGE_JS_PATH',     PAGE_PATH.'/js');
  define('PAGE_CSS_PATH',    PAGE_PATH.'/css');
?>
