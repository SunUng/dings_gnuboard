<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
    </main>
    <!-- / .main -->

    <!-- .footer -->
    <footer class="footer">
    </footer>
    <!-- / .footer -->
</div>
<!-- / .wrap -->


<?php
if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>


<?php include_once(G5_THEME_PATH."/tail.sub.php"); ?>