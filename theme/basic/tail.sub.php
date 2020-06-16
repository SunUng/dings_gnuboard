<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<?php if ($is_admin == 'super') {  ?><!-- <div style='float:left; text-align:center;'>RUN TIME : <?php echo get_microtime()-$begin_time; ?><br></div> --><?php }  ?>

<script src="<?php echo G5_THEME_URL ?>/js/common.min.js?ver=<?php echo G5_JS_VER ?>"></script>
<?php if (file_exists(G5_THEME_PATH.'/js/'.$mid.'.min.js')) { ?>
<script src="<?php echo G5_THEME_URL ?>/js/<?php echo $mid ?>.min.js?ver=<?php echo G5_JS_VER ?>"></script>
<?php } ?>
<?php if (!defined('_INDEX_')) { ?>
<script src="<?php echo G5_THEME_URL ?>/js/subpage.min.js?ver=<?php echo G5_JS_VER ?>"></script>
<?php } ?>
<?php run_event('tail_sub'); ?>

</body>
</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다. ?>