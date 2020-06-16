<?php if (isvar($gnb['main'])) { ?>
<ul class="gnb gnb-pc depth1">
  <?php foreach($gnb['main'] as $key => $depth1) { ?>
  <li class="depth1-li<?php if ($depth1['m_order'] === $current['parent_order']) echo ' current' ?>">
    <a href="<?php echo $depth1['m_url'] ?>"<?php if ($depth1['m_nw'] === '1') echo ' target="_blank"' ?> class="depth1-li-a">
      <?php echo $depth1['m_title'] ?>
    </a>
    <?php if (isvar($gnb['sub'][$key])) { ?>
    <ul class="depth2">
      <?php foreach($gnb['sub'][$key] as $key2 => $depth2) { ?>
      <li class="depth2-li<?php if ($depth2['m_order'] === $current['m_order']) echo ' current' ?>">
        <a href="<?php echo $depth2['m_url'] ?>"<?php if ($depth2['m_nw'] === '1') echo ' target="_blank"' ?> class="depth2-li-a">
          <?php echo $depth2['m_title'] ?>
        </a>
      </li>
      <?php } ?>
    </ul>
    <?php } ?>
  </li>
  <?php } ?>
</ul>
<?php } ?>