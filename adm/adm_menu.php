<?php
$sub_menu = "400200";
include_once('./_common.php');
include_once(G5_PATH.'/dings/config.php');
include_once(DINGS_PATH.'/dings.lib.php');

$sitemenu = getSitemenu();

auth_check($auth[$sub_menu], 'r');

$g5['title'] = "메뉴관리";
include_once('./admin.head.php');

$templateObj = getDirList(TPL_PATH);
$menutypeObj = array(
  'page' => '일반',
  // 'room' => '객실',
  'board' => '게시판',
  // 'calendar' => '실시간달력'
);
add_javascript('<script src="'.DINGS_JS.'/jquery-ui/jquery-ui.min.js"></script>', 0);

?>
<section class="adm-menu">
  <form name="adm_site" id="form-menu" action="./adm_menu_update.php" method="post">
    <table class="table-menu table-menu-title noselect">
      <colgroup>
        <col class="col1">
        <col class="col2">
        <col class="col3">
        <col class="col4">
        <col class="col5">
        <col class="col12">
        <col class="col6">
        <col class="col7">
        <col class="col8">
        <col class="col9">
        <col class="col10">
        <col class="col11">
        <col class="col13">
        <col class="col14">
        <col class="col15">
      </colgroup>
      <thead>
        <tr>
          <th rowspan="2">
            이동
          </th>
          <th rowspan="2">
            순서
          </th>
          <th rowspan="2">
            메뉴ID(이미지폴더)
          </th>
          <th rowspan="2">
            메뉴제목
          </th>
          <th rowspan="2">
            메뉴종류
          </th>
          <th rowspan="2">
            메뉴 템플릿(스킨)
          </th>
          <th colspan="3">
            PC 환경 설정
          </th>
          <th colspan="3">
            모바일 환경 설정
          </th>

          <th rowspan="2">
            추가
          </th>
          <th rowspan="2">
            삭제
          </th>
          <th rowspan="2" class="add add-menu-main">
            <span class="tm-btn">
              <i class="fas fa-plus"></i>
            </span>
          </th>
        </tr>
        <tr>
          <th>
            사용 여부
          </th>
          <th>
            새창 사용
          </th>
          <th>
            연결 URL
          </th>
          <th>
            사용 여부
          </th>
          <th>
            새창 사용
          </th>
          <th>
            연결 URL
          </th>
        </tr>
      </thead>
    </table>
    <div class="menu-list">
      <table class="empty-menu-table">
        <colgroup>
          <col class="col1">
          <col class="col2">
          <col class="col3">
          <col class="col4">
          <col class="col5">
          <col class="col12">
          <col class="col6">
          <col class="col7">
          <col class="col8">
          <col class="col9">
          <col class="col10">
          <col class="col11">
          <col class="col13">
          <col class="col14">
          <col class="col15">
        </colgroup>
        <tbody>
          <tr>
            <td colspan="13" class="td-empty">
              등록된 메뉴가 없습니다. 메뉴를 등록해주세요.
            </td>
          </tr>
        </tbody>
      </table>
      <?php
      if (isset($sitemenu)) {
        foreach($sitemenu['main'] as $key_root => $menuArr) { // 메뉴 변수 반복
          foreach($menuArr as $key_main => $main_item) { // 메인메뉴 배열 반복 
            $mpk = $main_item['id'];
          ?>
            <table class="table-menu table-menu-list">
              <colgroup>
                <col class="col1">
                <col class="col2">
                <col class="col3">
                <col class="col4">
                <col class="col5">
                <col class="col12">
                <col class="col6">
                <col class="col7">
                <col class="col8">
                <col class="col9">
                <col class="col10">
                <col class="col11">
                <col class="col13">
                <col class="col14">
                <col class="col15">
              </colgroup>
              <thead>
                <tr class="original">
                  <th class="grip grip-main">
                    <i class="fas fa-grip-lines"></i>
                  </th>
                  <th class="order">
                    <input type="hidden" name="id[]" value="<?php echo $mpk ?>" class="pk">
                    <input type="hidden" name="todo[]" value="nothing" class="todo">
                    <input type="hidden" name="old[]" value="<?php echo $main_item['m_order'] ?>" class="old">
                    <input type="hidden" name="m_order[]" class="current_order" value="<?php echo $main_item['m_order'] ?>" >
                    <input type="hidden" name="parent_order[]" class="parent_order" value="<?php echo $main_item['parent_order'] ?>" >
                    <span><?php echo $main_item['m_order'] ?></span>
                  </th>
                  <th>
                    <input type="text" name="mid[]" value="<?php echo $main_item['mid'] ?>" class="tm-input mid-input" placeholder="메뉴ID">
                  </th>
                  <th>
                    <input type="text" name="m_title[]" value="<?php echo $main_item['m_title'] ?>" class="tm-input" placeholder="메뉴제목"></th>
                  <th>
                    <select name="m_type[]" class="tm-select menu-type">
                      <?php foreach($menutypeObj as $key => $value) { ?>
                      <option value="<?php echo $key ?>"<?php if ($main_item['m_type'] === $key) echo ' selected' ?>><?php echo $value ?></option>
                      <?php } ?>
                    </select>
                  </th>
                  <th>
                    <select name="template[]" class="tm-select">
                      <option value="">미선택</option>
                      <?php foreach($templateObj as $key => $value) { ?>
                      <option value="<?php echo $key ?>"<?php if ($main_item['template'] === $key) echo ' selected' ?>><?php echo $value ?></option>
                      <?php } ?>
                    </select>
                  </th>
                  <th class="check">
                    <input type="hidden" name="m_use[]" value="<?php echo $main_item['m_use'] ?>">
                    <input type="checkbox" id="m_use" value="1" class="tm-checkbox"<?php if ($main_item['m_use'] === '1') echo ' checked' ?>>
                    <label for="m_use" class="tm-cb-view noselect">
                      <span class="tm-cb-view-inner">
                        <span class="status off">끔</span>
                        <span class="status on">켬</span>
                      </span>
                    </label>
                  </th>
                  <th class="check">
                    <input type="hidden" name="m_nw[]" value="<?php echo $main_item['m_nw'] ?>">
                    <input type="checkbox" id="m_nw" value="1" class="tm-checkbox"<?php if ($main_item['m_nw'] === '1') echo ' checked' ?>>
                    <label for="m_nw" class="tm-cb-view noselect">
                      <span class="tm-cb-view-inner">
                        <span class="status off">끔</span>
                        <span class="status on">켬</span>
                      </span>
                    </label>
                  </th>
                  <th>
                    <input type="text" name="m_url[]" value="<?php echo $main_item['m_url'] ?>" class="tm-input input-url" placeholder="연결URL">
                  </th>
                  <th class="check">
                    <input type="hidden" name="mb_use[]" value="<?php echo $main_item['mb_use'] ?>">
                    <input type="checkbox" id="mb_use" value="1" class="tm-checkbox"<?php if ($main_item['mb_use'] === '1') echo ' checked' ?>>
                    <label for="mb_use" class="tm-cb-view noselect">
                      <span class="tm-cb-view-inner">
                        <span class="status off">끔</span>
                        <span class="status on">켬</span>
                      </span>
                    </label>
                  </th>
                  <th class="check">
                    <input type="hidden" name="mb_nw[]" value="<?php echo $main_item['mb_nw'] ?>">
                    <input type="checkbox" id="mb_nw" value="1" class="tm-checkbox"<?php if ($main_item['mb_nw'] === '1') echo ' checked' ?>>
                    <label for="mb_nw" class="tm-cb-view noselect">
                      <span class="tm-cb-view-inner">
                        <span class="status off">끔</span>
                        <span class="status on">켬</span>
                      </span>
                    </label>
                  </th>
                  <th>
                    <input type="text" name="mb_url[]" value="<?php echo $main_item['mb_url'] ?>" class="tm-input input-url" placeholder="연결URL">
                  </th>

                  <th class="add add-menu-sub">
                    <span class="tm-btn">
                      <i class="fas fa-plus"></i>
                    </span>
                  </th>
                  <th class="row-remove">
                    <span class="tm-btn">
                      <i class="fas fa-minus"></i>
                    </span>
                  </th>
                  <th class="grip grip-main">
                    <i class="fas fa-grip-lines"></i>
                  </th>
                </tr>
              </thead>
              <tbody class="sub-area">
                <?php
                if (isset($sitemenu['sub'][$key_root])) {
                  foreach($sitemenu['sub'][$key_root] as $key_sub => $sub_item) { // 서브메뉴 배열 반복 ?>
                    <tr class="original">
                      <td class="grip grip-sub">
                        <i class="fas fa-grip-lines"></i>
                      </td>
                      <td class="order">
                        <input type="hidden" name="id[]" value="<?php echo $sub_item['id'] ?>" class="pk">
                        <input type="hidden" name="todo[]" value="nothing" class="todo">
                        <input type="hidden" name="old[]" value="<?php echo $sub_item['m_order'] ?>" class="old">
                        <input type="hidden" name="m_order[]" class="current_order" value="<?php echo $sub_item['m_order'] ?>">
                        <input type="hidden" name="parent_order[]" class="parent_order" value="<?php echo $sub_item['parent_order'] ? $sub_item['parent_order'] : $main_item['m_order'] ?>">
                        <span><?php echo $sub_item['m_order'] ?></span>
                      </td>
                      <td>
                        <input type="text" name="mid[]" value="<?php echo $sub_item['mid'] ?>" class="tm-input mid-input" placeholder="메뉴ID">
                      </td>
                      <td>
                        <input type="text" name="m_title[]" value="<?php echo $sub_item['m_title'] ?>" class="tm-input" placeholder="메뉴제목">
                      </td>
                      <td>
                        <select name="m_type[]" class="tm-select menu-type">
                        <?php foreach($menutypeObj as $key => $value) { ?>
                        <option value="<?php echo $key ?>"<?php if ($sub_item['m_type'] === $key) echo ' selected' ?>><?php echo $value ?></option>
                        <?php } ?>
                        </select>
                      </td>
                      <td>
                        <select name="template[]" class="tm-select">
                          <option value="">미선택</option>
                          <?php foreach($templateObj as $key => $value) { ?>
                          <option value="<?php echo $key ?>"<?php if ($sub_item['template'] === $key) echo ' selected' ?>><?php echo $value ?></option>
                          <?php } ?>
                        </select>
                      </td>
                      <td class="check">
                        <input type="hidden" name="m_use[]" value="<?php echo $sub_item['m_use'] ?>">
                        <input type="checkbox" id="m_use" value="1" class="tm-checkbox"<?php if ($sub_item['m_use'] === '1') echo ' checked' ?>>
                        <label for="m_use" class="tm-cb-view noselect">
                          <span class="tm-cb-view-inner">
                            <span class="status off">끔</span>
                            <span class="status on">켬</span>
                          </span>
                        </label>
                      </td>
                      <td class="check">
                        <input type="hidden" name="m_nw[]" value="<?php echo $sub_item['m_nw'] ?>">
                        <input type="checkbox" id="m_nw" value="1" class="tm-checkbox"<?php if ($sub_item['m_nw'] === '1') echo ' checked' ?>>
                        <label for="m_nw" class="tm-cb-view noselect">
                          <span class="tm-cb-view-inner">
                            <span class="status off">끔</span>
                            <span class="status on">켬</span>
                          </span>
                        </label>
                      </td>
                      <td>
                        <input type="text" name="m_url[]" value="<?php echo $sub_item['m_url'] ?>" class="tm-input input-url" placeholder="연결URL">
                      </td>
                      <td class="check">
                        <input type="hidden" name="mb_use[]" value="<?php echo $sub_item['mb_use'] ?>">
                        <input type="checkbox" id="mb_use" value="1" class="tm-checkbox"<?php if ($sub_item['mb_use'] === '1') echo ' checked' ?>>
                        <label for="mb_use" class="tm-cb-view noselect">
                          <span class="tm-cb-view-inner">
                            <span class="status off">끔</span>
                            <span class="status on">켬</span>
                          </span>
                        </label>
                      </td>
                      <td class="check">
                        <input type="hidden" name="mb_nw[]" value="<?php echo $sub_item['mb_nw'] ?>">
                        <input type="checkbox" id="mb_nw" value="1" class="tm-checkbox"<?php if ($sub_item['mb_nw'] === '1') echo ' checked' ?>>
                        <label for="mb_nw" class="tm-cb-view noselect">
                          <span class="tm-cb-view-inner">
                            <span class="status off">끔</span>
                            <span class="status on">켬</span>
                          </span>
                        </label>
                      </td>
                      <td>
                        <input type="text" name="mb_url[]" value="<?php echo $sub_item['mb_url'] ?>" class="tm-input input-url" placeholder="연결URL">
                      </td>

                      <td class="add empty">&nbsp;</td>
                      <td class="row-remove"><span class="tm-btn"><i class="fas fa-minus"></i></span></td>
                      <td class="grip grip-sub"><i class="fas fa-grip-lines"></i>
                      </td>
                    </tr>
                <?php }
                } ?>
              </tbody>
            </table>
        <?php }
        }
      }
      ?>
    </div>
    <div class="btn_fixed_top">
      <input type="submit" name="menu_submit" value="저장" class="btn_01 btn menu_submit">
    </div>
  </form>
  <?php
  $query = "SELECT * FROM adm_menu";
  $result = sql_query($query);
  while($row = sql_fetch_array($result)) {
    $oldmenu[] = $row;
  }
  ?>
  <div class="btn_fixed_top2">
    <?php if (count($oldmenu) > 0 && !empty($oldmenu) && isset($oldmenu)) { ?>
    <form name="make_menu_sitemap" id="form-menu-sitemap" action="./adm_menu_update_sitemap.php" method="post">
      <input type="submit" name="menu_submit" value="사이트맵 생성(PC기준)" class="btn_03 btn menu_submit">
    </form>
    <?php } ?>
  </div>

</section>

<?php // print_r2($sitemenu) ?>

<script>
  // 메뉴 드래그 시작 ------
  function sortableMenu(){
    $('.menu-list').sortable({
      handle: '.grip-main',
      axis: 'y',
      helper:'clone',
      scroll: true,
      start: function(e, ui){
        ui.placeholder.height(ui.helper.outerHeight());
      },
      update: function( event, ui ) {
        menuRowDataAdjust();
        detectChangedOrder();
      }
    }).disableSelection();
    $('.sub-area').sortable({
      handle: '.grip-sub',
      axis: 'y',
      connectWith: '.sub-area',
      start: function(e, ui){
        ui.placeholder.height(ui.helper.outerHeight());
      },
      helper: function(e, tr){
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index){
          $(this).width($originals.eq(index).outerWidth());
        });
        return $helper;
      },
      scroll: true,
      update: function( event, ui ) {
        menuRowDataAdjust();
        detectChangedOrder();
      }
    }).disableSelection();
  };
  sortableMenu();
  // 메뉴 드래그 끝 ------

  // 객실 셀렉트 데이터 항목 종류 자바스크립트 변수로 사전 정의 시작 ------
  var templateObj = <?php echo json_encode($templateObj, JSON_UNESCAPED_UNICODE); ?>; //디렉토리에서 템플릿을 읽어와 배열에 정리함
  var menutypeObj = <?php echo json_encode($menutypeObj, JSON_UNESCAPED_UNICODE); ?>;
  // 객실 셀렉트 데이터 항목 종류 자바스크립트 변수로 사전 정의 시작 ------

  // 메뉴 정렬값 (1000, 1001, 1002... 등) 재정렬, 그 값을 이용한 체크박스 id, for 문자열 재정리 시작 ------
  function pad(n, width) {
    n = n + '';
    return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
  }

  function menuRowDataAdjust(){
    var $main = $('.table-menu-list');
    $main.each(function(i,v){
      var $main = $(this);
      var $mainTarget = $main.find('thead').find('tr').not('.removed').find('.order');
      var mainOrder = pad((i + 1),2);
      var mainOrderStr = mainOrder + '00';
      $mainTarget.find('span').text(mainOrderStr);
      $mainTarget.find('input.current_order').val(mainOrderStr);
      var $mainCheck = $main.find('thead tr').find('.check');
      $mainCheck.each(function(i,v){
        var mainIptId = $(this).find('input[type="checkbox"]').attr('id');
        mainIptId = mainIptId.split('-')[0];
        $(this).find('input[type="checkbox"]').attr('id', mainIptId + '-' + mainOrderStr);
        $(this).find('label').attr('for', mainIptId + '-' + mainOrderStr);
      });
      var $sub = $main.find('.sub-area').find('tr').not('.removed');
      $sub.each(function(i,v){
        var $sub = $(this);
        var $subTarget = $sub.find('.order');
        var subOrder = pad((i + 1),2);
        var subOrderStr = mainOrder + subOrder;
        $subTarget.find('span').text(subOrderStr);
        $subTarget.find('input.current_order').val(subOrderStr);
        var $subCheck = $sub.find('.check');
        $subCheck.each(function(i,v){
          var subIptId = $(this).find('input[type="checkbox"]').attr('id');
          subIptId = subIptId.split('-')[0];
          $(this).find('input[type="checkbox"]').attr('id', subIptId + '-' + subOrderStr);
          $(this).find('label').attr('for', subIptId + '-' + subOrderStr);
        });
      });
    });
  };
  menuRowDataAdjust();
  // 메뉴 정렬값 (1000, 1001, 1002... 등) 재정렬, 그 값을 이용한 체크박스 id, for 문자열 재정리 끝 ------

  // 메인 추가 시작 ------
  // 메뉴 생성 개수 제한 시작 ------

  function addMenuLimit(count, limit){
    if (count >= limit) {
      alert('메뉴는 ' + limit + '개를 초과하여 생성할 수 없습니다.');
      return false;
    }
  }
  // 메뉴 생성 개수 제한 끝 ------

  // 메인 메뉴 추가 시작 ------
  var mainMenuMaxLimit = 99;
  $(document).on('click', '.add-menu-main', function(){ //메인메뉴 추가
    var $container = $(this).closest('table');
    var $target = $container.next('.menu-list');
    var beforeMenuLength = $target.find('.table-menu-list').length;
    if (addMenuLimit(beforeMenuLength, mainMenuMaxLimit) === false) return;
    var menutypeOptions = '';
    $.each(menutypeObj, function(k,v){
      var source = '<option value="' + k + '">' + v + '</option>';
      menutypeOptions += source;
    });
    var templateOptions = '';
    $.each(templateObj, function(k,v){
      var source = '<option value="' + k + '">' + v + '</option>';
      templateOptions += source;
    });
    var dom = '<table class="table-menu table-menu-list"><colgroup><col class="col1"><col class="col2"><col class="col3"><col class="col4"><col class="col5"><col class="col12"><col class="col6"><col class="col7"><col class="col8"><col class="col9"><col class="col10"><col class="col11"><col class="col13"><col class="col14"><col class="col15"></colgroup><thead><tr class="new"><th class="grip grip-main"><i class="fas fa-grip-lines"></i></th><th class="order"><input type="hidden" name="id[]" value="created" class="pk"><input type="hidden" name="old[]" value="created" class="old"><input type="hidden" name="todo[]" value="created" class="todo"><input type="hidden" name="m_order[]" class="current_order" value=""><input type="hidden" name="parent_order[]" class="parent_order" value=""><span></span></th><th><input type="text" name="mid[]" value="" class="tm-input mid-input" placeholder="메뉴ID"></th><th><input type="text" name="m_title[]" value="" class="tm-input" placeholder="메뉴제목"></th><th><select name="m_type[]" class="tm-select menu-type">' + menutypeOptions + '</select></th><th><select name="template[]" class="tm-select"><option value="">미선택</option>' + templateOptions + '</select></th><th class="check"><input type="hidden" name="m_use[]" value="1"><input type="checkbox" id="m_use" value="1" class="tm-checkbox" checked><label for="m_use" class="tm-cb-view noselect"><span class="tm-cb-view-inner"><span class="status off">끔</span><span class="status on">켬</span></span></label></th><th class="check"><input type="hidden" name="m_nw[]" value="0"><input type="checkbox" id="m_nw" value="1" class="tm-checkbox"><label for="m_nw" class="tm-cb-view noselect"><span class="tm-cb-view-inner"><span class="status off">끔</span><span class="status on">켬</span></span></label></th><th><input type="text" name="m_url[]" value="" class="tm-input input-url" placeholder="연결URL"></th><th class="check"><input type="hidden" name="mb_use[]" value="1"><input type="checkbox" id="mb_use" value="1" class="tm-checkbox" checked><label for="mb_use" class="tm-cb-view noselect"><span class="tm-cb-view-inner"><span class="status off">끔</span><span class="status on">켬</span></span></label></th><th class="check"><input type="hidden" name="mb_nw[]" value="0"><input type="checkbox" id="mb_nw" value="1" class="tm-checkbox"><label for="mb_nw" class="tm-cb-view noselect"><span class="tm-cb-view-inner"><span class="status off">끔</span><span class="status on">켬</span></span></label></th><th><input type="text" name="mb_url[]" value="" class="tm-input input-url" placeholder="연결URL"></th><th class="add add-menu-sub"><span class="tm-btn"><i class="fas fa-plus"></i></span></th><th class="row-remove"><span class="tm-btn"><i class="fas fa-minus"></i></span></th><th class="grip grip-main"><i class="fas fa-grip-lines"></i></th></tr></thead><tbody class="sub-area"></tbody></table>';
    $target.append(dom);
    menuRowDataAdjust();
    $('.menu-list').sortable('destroy');
    sortableMenu();
    emptyTableWork();
  });
  // 메인 메뉴 추가 끝 ------

  // 서브 메뉴 추가 시작 ------
  var subMenuMaxLimit = 99;
  $(document).on('click', '.add-menu-sub', function(){ //서브메뉴 추가
    var $container = $(this).closest('.table-menu-list');
    var $target = $container.find('.sub-area');
    var beforeMenuLength = $target.find('tr').length;
    if (addMenuLimit(beforeMenuLength, subMenuMaxLimit) === false) return;
    var menutypeOptions = '';
    $.each(menutypeObj, function(k,v){
      var source = '<option value="' + k + '">' + v + '</option>';
      menutypeOptions += source;
    });
    var templateOptions = '';
    $.each(templateObj, function(k,v){
      var source = '<option value="' + k + '">' + v + '</option>';
      templateOptions += source;
    });
    var dom = '<tr class="new"><td class="grip grip-sub"><i class="fas fa-grip-lines"></i></td><td class="order"><input type="hidden" name="id[]" value="created" class="pk"><input type="hidden" name="old[]" value="created" class="old"><input type="hidden" name="todo[]" value="created" class="todo"><input type="hidden" name="m_order[]" class="current_order" value=""><input type="hidden" name="parent_order[]" class="parent_order" value=""><span>< /span></td><td><input type="text" name="mid[]" value="" class="tm-input mid-input" placeholder="메뉴ID"></td><td><input type="text" name="m_title[]" value="" class="tm-input" placeholder="메뉴제목"></td><td><select name="m_type[]" class="tm-select menu-type">' + menutypeOptions + '</select></td><td><select name="template[]" class="tm-select"><option value="">미선택</option>' + templateOptions + '</select></td><td class="check"><input type="hidden" name="m_use[]" value="1"><input type="checkbox" id="m_use" value="1" class="tm-checkbox" checked><label for="m_use" class="tm-cb-view noselect"><span class="tm-cb-view-inner"><span class="status off">끔</span><span class="status on">켬</span></span></label></td><td class="check"><input type="hidden" name="m_nw[]" value="0"><input type="checkbox" id="m_nw" value="1" class="tm-checkbox"><label for="m_nw" class="tm-cb-view noselect"><span class="tm-cb-view-inner"><span class="status off">끔</span><span class="status on">켬</span></span></label></td><td><input type="text" name="m_url[]" value="" class="tm-input input-url" placeholder="연결URL"></td><td class="check"><input type="hidden" name="mb_use[]" value="1"><input type="checkbox" id="mb_use" value="1" class="tm-checkbox" checked><label for="mb_use" class="tm-cb-view noselect"><span class="tm-cb-view-inner"><span class="status off">끔</span><span class="status on">켬</span></span></label></td><td class="check"><input type="hidden" name="mb_nw[]" value="0"><input type="checkbox" id="mb_nw" value="1" class="tm-checkbox"><label for="mb_nw" class="tm-cb-view noselect"><span class="tm-cb-view-inner"><span class="status off">끔</span><span class="status on">켬</span></span></label></td><td><input type="text" name="mb_url[]" value="" class="tm-input input-url" placeholder="연결URL"></td><td class="add empty">&nbsp;</td><td class="row-remove"><span class="tm-btn"><i class="fas fa-minus"></i></span></td><td class="grip grip-sub"><i class="fas fa-grip-lines"></i></td></tr>';
    $target.append(dom);
    menuRowDataAdjust();
    $target.sortable('destroy');
    sortableMenu();
    emptyTableWork();
  });
  // 서브 메뉴 추가 끝 ------
  // 메인 추가 끝 ------

  // 메뉴 삭제 시작 ------
  function cancelRemoveRow($target){
    $target.removeClass('selected selected-main');
    return false;
  }
  function confimedRemoveRow($target, $targetTr){
    if ($targetTr.hasClass('original')) {
      $targetTr.addClass('removed');
      $target.find('input.todo').val('removed');
    } else {
      $target.remove();
    }
    menuRowDataAdjust();
    emptyTableWork();

    $('.table-menu').each(function(){ // 테이블 삭제할 때 아무 빈 테이블이 남아 공간을 차지하는데, 클래스를 붙여 공간이 뜨지 않도록 처리함.
      if ($(this).find('tr').not('.removed').length > 0) $(this).removeClass('empty-menu');
      else $(this).addClass('empty-menu');
    });
    return false;
  }
  $(document).on('click', '.row-remove', function(){ //서브메뉴 추가
    var $this = $(this);
    var $childContainer = $this.closest('.sub-area');
    var $parentContainer = $this.closest('.table-menu-list');
    var countChildren = $parentContainer.find('.sub-area').find('tr').not('.removed').length;
    var isSubMenu = $childContainer.length > 0;
    var $targetTr = $this.closest('tr');
    var $target = isSubMenu ? $targetTr : $this.closest('.table-menu-list');
    var $cells = $this.closest('tr').find('td, th').addClass('selected selected-main');
    if (!isSubMenu && countChildren > 0) {
      setTimeout(function(){
        alert('이 메뉴에 연결된 서브메뉴가 있어 삭제할 수 없습니다.\n연결된 서브 메뉴를 모두 삭제해야 합니다.');
        return cancelRemoveRow($cells);
      }, 20);
      return false;
    } else {
      setTimeout(function(){
        var removeConfirm = confirm('선택한 메뉴를 정말 삭제하시겠습니까?\n삭제 후 저장하시면 복구할 수 없습니다.');
        if (removeConfirm) confimedRemoveRow($target, $targetTr);
        else return cancelRemoveRow($cells);
      }, 20);
    }
    // 메뉴 삭제 끝 ------
    menuRowDataAdjust();
  });

  // 내용 변경이 있을 경우 상태값 변경 시작 ------
  function detectChangedField($ele){
    var $wrapper = $ele.closest('tr').not('.new');
    var status = $wrapper.find('input.todo');
    status.val('changed');
  }
  // 내용 변경이 있을 경우 상태값 변경 끝 ------
  // 순서 변경이 있을 경우 상태값 변경 시작 ------
  function detectChangedOrder(){
    var oldEle = $('#form-menu tr.original').not('.removed').find('.old');
    oldEle.each(function(i, v){
      var currentOrder = $(this).next('.current_order').val();
      if ($(this).val() !== currentOrder) {
         var parentOrder = $(this).closest('.table-menu-list').find('thead input.current_order').val();
         parentOrder = parentOrder.length > 0 ? parentOrder : '';
        $(this).closest('tr').not('.new').find('input.parent_order').val(parentOrder);
        $(this).closest('tr').not('.new').find('input.todo').val('changed');
      }
    });
  }
  // 순서 변경이 있을 경우 상태값 변경 끝 ------

  // 메뉴 UI 테이블 상단 고정 시작 (csscalc가 지원될 때에만 작동) ------
  // if (Modernizr.csscalc) {
  //   $(window).load(function(){
  //       // $(window).on('scroll', _.throttle(function(){
  //       //   var scroll = $(window).scrollTop(), $fixed = $('.table-menu-title');
  //       //   scroll > 0 ? $fixed.addClass('fixed') : $fixed.removeClass('fixed');
  //       // }, 100));
  //       $(window).on('scroll', function(){
  //         var scroll = $(window).scrollTop(), $fixed = $('.table-menu-title');
  //         scroll > 20 ? $fixed.addClass('fixed') : $fixed.removeClass('fixed');
  //       });
  //   });
  // }
  // 메뉴 UI 테이블 상단 고정 끝 (csscalc가 지원될 때에만 작동) ------

  //테이블 비었을 때 대체 출력 시작 ------
  function emptyTableWork(){
    var $emptyDom = $('.empty-menu-table'), $container = $('.menu-list');
    $container.find('.table-menu-list').length > 0 ? $emptyDom.removeClass('view') : $emptyDom.addClass('view');
  }
  emptyTableWork();
  //테이블 비었을 때 대체 출력 끝 ------

  //체크박스 unchecked 상태일 때 값을 form으로 넘기지 못하므로, hidden 인풋에 값 복제 시작  ------
  $(document).on('change', '.original .tm-checkbox, .new .tm-checkbox', function(){
    var $this = $(this), tagname = $this.prop('tagName').toLowerCase();
    if (tagname === 'input') {
      $this.is(':checked') ? $this.prev('input').val('1') : $this.prev('input').val('0');
      detectChangedField($(this));
    }
  });
  //체크박스 unchecked 상태일 때 값을 form으로 넘기지 못하므로, hidden 인풋에 값 복제 끝  ------

  $('#form-menu').submit(function(e){
    // e.preventDefault();
    var $form = $(this);
    var $row = $form.find('.table-menu-list tr').not('.removed');
    var $ipt = $row.find('input[type="hidden"], input[type="text"], select');
    // var $mids = $row.find('input.mid-input');
    var submit_flag = true;
    $ipt.each(function(i,v){ //메뉴의 ID, 제목, 종류가 비었는지 검사함
      var $this = $(this);
      var name = $this.attr('name');
      if (name === 'mid[]' || name === 'm_title[]' || name === 'm_type[]') {
        if ($this.val() === '' || $this.val() === null || typeof ($this.val()) === 'undefined') {
          var box = $this.closest('td, th');
          var idx = $this.closest('tr').find('td, th').index(box);
          var text = $.trim($('.table-menu-title').find('thead tr').find('th').eq(idx).text());
          alert(text + '이 입력되어 있는지 확인해주세요.');
          $this.focus();
          submit_flag = false;
          return false;
        }
      }
    });

    //메뉴ID 중복검사
    $.each($('input.mid-input'), function(i, v){
      var valid = true;
      var focusing;
      $.each($('input.mid-input').not(this), function(i2, v2){
        if ($(v).val() === $(v2).val()) {
          focusing = $(v2);
          valid = false;
        }
      });
      if (valid === false) {
        alert('메뉴ID는 중복될 수 없습니다.\n삭제할 메뉴ID와 중복되는 메뉴가 있다면 우선 삭제 작업을 먼저 진행해주세요.');
        focusing.focus();
        submit_flag = false;
        return false;
      } 
    });
    // //메뉴ID 중복검사
    // $.each($('input.mid-input'), function(i, v){
    //   if (!$(this).closest('tr').hasClass('removed')) {
    //     var valid = true;
    //     var focusing;
    //     $.each($('input.mid-input').not(this), function(i2, v2){
    //       if (!$(this).closest('tr').hasClass('removed')) {
    //         if ($(v).val() === $(v2).val()) {
    //           focusing = $(v2);
    //           valid = false;
    //         }
    //       }
    //     });
    //     if (valid === false) {
    //       alert('메뉴ID는 중복될 수 없습니다.');
    //       focusing.focus();
    //       submit_flag = false;
    //       return false;
    //     } 
    //   }
    // });
    if (submit_flag === false) return false;


  });

  $(document).on('change', '.original input[type="text"], .original select', function(){
    detectChangedField($(this));
  });

  //메뉴 타입 변경시 데이터 변경 경고창 시작 ------
  $(document).on('click', '.menu-type', function(){
    var old = $(this).val();
    $(this).data('old', old);
  });
  // $(document).on('change', '.menu-type', function(){
  //   var oldValue = $(this).data('old');
  //   var newValue = $(this).val();
  //   if (oldValue !== newValue) {
  //     if (oldValue === 'room') {
  //       alert('객실 타입의 메뉴를 다른 타입으로 변경하면 연결된 요금표와 구성 내용 등 관련 데이터가 삭제됩니다.');
  //     } else if (newValue === 'room') {
  //       alert('해당 메뉴를 객실 타입으로 변경하면 관련 요금표와 구성 내용 데이터가 생성됩니다. 해당 변경 페이지에서 설정하실 수 있습니다.');
  //     }
  //   }
  // });
  //메뉴 타입 변경시 데이터 변경 경고창 끝 ------


  //인터페이스 우선순위에 따라 사용가능한 폼 컨트롤하는 부분... 이 부분은 중요한 다른 부분이 완료된 후에 남는 시간에 작업  ------
  // $(document).ready(function(){
  //   var mtypeSelects = $('select.menu-type');
  //   mtypeSelects.each(function(){
  //     var $this = $(this);
  //     var $conteiner = $this.closest('tr');
  //     var selectedValue = $this.val();
  //     if (selectedValue === 'room') {
  //       $conteiner.find('input.input-url').prop('disabled', true);
  //     } else if (selectedValue === 'board') {

  //     } else if (selectedValue === 'calendar') {

  //     }
  //   });
  // })
  // $(document).on('load', 'select.menu-type option:selected', function(){
  //   console.log($(this).val())
  // });

</script>
<?php include_once('./admin.tail.php'); ?>
