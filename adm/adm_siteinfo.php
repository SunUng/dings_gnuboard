<?php
$sub_menu = "400100";
include_once('./_common.php');
include_once(G5_PATH.'/dings/config.php');
include_once(DINGS_PATH.'/dings.lib.php');

auth_check($auth[$sub_menu], 'r');

$siteinfo = sql_fetch("SELECT * FROM adm_siteinfo");


$g5['title'] = "사이트정보";
include_once('./admin.head.php');

$tabHtml = '<ul class="section-tab">
      <li><a href="#tab-default">사이트 기본 설정</a></li>
      <li><a href="#tab-map">지도 설정</a></li>
      <li><a href="#tab-meta">사이트 메타정보</a></li>
  </ul>';

// DB가 없을 때 기본 좌표 데이터 세팅
$existdbcheck_query = "SELECT * FROM adm_siteinfo";
$existdbcheck = sql_query($existdbcheck_query);
if (!$existdbcheck) {
  $siteinfo['mapx'] = '127.7058976686673811';
  $siteinfo['mapy'] = '37.8657233024994310';
  $siteinfo['mapzoom'] = '2';
}

// 오픈그래프 이미지
if (file_exists(DINGS_IMG_PATH.'/og_image.png')) {
  $og_image = DINGS_IMG.'/og_image.png';
} else {
  if (file_exists(DINGS_IMG_PATH.'/og_image.jpg')) {
    $og_image = DINGS_IMG.'/og_image.jpg';
  } else {
    $og_image = DINGS_IMG.'/og_image_default.png';
  }
}
?>

<?php if ($config['cf_bbs_rewrite'] !== '2') { ?>
<div class="site-warning">
  <div class="strong-red bullet">
    <i class="fas fa-exclamation-triangle"></i>
  </div>
  '짧은 주소 설정'이 '글 이름'으로 되어있지 않아 사이트 링크가 원활히 작동되지 않을 수 있습니다.<br>
  [관리자] -> [환경설정] -> [<a href="<?php echo G5_ADMIN_URL.'/config_form.php#anc_cf_url' ?>" class="strong-blue">기본환경설정</a>] 페이지에서 '짧은 주소 설정' 항목을 찾아 '<span class="strong-blue">글 이름</span>' 으로 적용하시기 바랍니다.
</div>
<?php } ?>
<form name="adm_site" id="adm_site" action="./adm_siteinfo_update.php" method="post" enctype="multipart/form-data" autocomplete="off">
  <section class="section-adm" id="tab-default">
    <h3 class="section-title">사이트 기본 설정</h3>
    <?php echo $tabHtml?>
    <div class="section-contents">
      <div class="section-row">
        <div class="section-cell col col-title">
          사이트 오픈 여부
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            홈페이지의 온라인 공개 여부를 결정합니다. 네이버, 구글 등 포털 사이트의 웹페이지 수집과 관련이 있습니다.
          </span>
          <input type="checkbox" value="1" name="open" id="open"<?php if ($siteinfo['open'] === '1') echo " checked" ?>>
          <label for="open">포털사이트에 공개</label>
        </div>
      </div>

      <div class="section-row" style="display:none;">
        <div class="section-cell col col-title">
          임시 홈페이지 사용 여부
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            임시 홈페이지로 전환합니다.
          </span>
          <input type="checkbox" value="1" name="temp" id="temp"<?php if ($siteinfo['temp'] === '1') echo " checked" ?>>
          <label for="temp">임시 홈페이지 사용</label>
        </div>
      </div>

      <div class="section-row">
        <div class="section-cell col col-title">
          <label for="title">홈페이지 제목</label>
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            브라우저의 제목&lt;title&gt;과 홈페이지 내의 사이트 명칭으로 사용됩니다.
          </span>
          <input type="text" value="<?php checkSetReturnEmpty($siteinfo['title']) ?>" name="title" id="title" class="text width1">
        </div>
      </div>

      <div class="section-row">
        <div class="section-cell col col-title">
          <label for="company">상호명</label>
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            홈페이지 하단 사업자 관련 정보 영역 등에 사용됩니다.
          </span>
          <input type="text" value="<?php checkSetReturnEmpty($siteinfo['company']) ?>" name="company" id="company" class="text width1">
        </div>
      </div>

      <div class="section-row">
        <div class="section-cell col col-title">
          <label for="owner">대표자 성명</label>
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            홈페이지 하단 사업자 관련 정보 영역 등에 사용됩니다.
          </span>
          <input type="text" value="<?php checkSetReturnEmpty($siteinfo['owner']) ?>" name="owner" id="owner" class="text width1">
        </div>
      </div>

      <div class="section-row">
        <div class="section-cell col col-title">
          <label for="tel">대표 전화번호</label>
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            모든 전화번호 안내, 전화 링크 등에서 사용됩니다.
          </span>
          <input type="text" value="<?php checkSetReturnEmpty($siteinfo['tel']) ?>" name="tel" id="tel" class="text width1">
        </div>
      </div>

      <div class="section-row">
        <div class="section-cell col col-title">
          <label for="account">계좌번호</label>
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            모든 계좌번호 안내 영역에서 사용됩니다.
          </span>
          <input type="text" value="<?php checkSetReturnEmpty($siteinfo['account']) ?>" name="account" id="account" class="text width1">
        </div>
      </div>

      <div class="section-row">
        <div class="section-cell col col-title">
          <label for="biznum1">사업자등록번호</label>
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            홈페이지 하단 사업자 관련 정보 영역 등에 사용됩니다.
          </span>
          <input type="text" value="<?php checkSetReturnEmpty($siteinfo['biznum1']) ?>" name="biznum1" id="biznum1" class="text width1">
        </div>
      </div>

      <div class="section-row">
        <div class="section-cell col col-title">
          <label for="biznum2">통신판매업 신고번호</label>
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            홈페이지 하단 사업자 관련 정보 영역 등에 사용됩니다.
          </span>
          <input type="text" value="<?php checkSetReturnEmpty($siteinfo['biznum2']) ?>" name="biznum2" id="biznum2" class="text width1">
        </div>
      </div>

      <div class="section-row">
        <div class="section-cell col col-title">
          <label for="address">사업장 주소</label>
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            홈페이지 하단 사업자 관련 정보 영역과 오시는 길 안내 등에 사용됩니다.
          </span>
          <input type="text" value="<?php checkSetReturnEmpty($siteinfo['address']) ?>" name="address" id="address" class="text width1">
        </div>
      </div>

    </div>
  </section>

  <section class="section-adm" id="tab-map">
    <h3 class="section-title">지도 설정</h3>
    <?php echo $tabHtml?>
    <div class="section-contents">
      <?php if (isset($siteinfo['map_key']) && !empty($siteinfo['map_key'])) { ?>
      <div class="section-row">
        <div class="section-cell col col-title">
          <label for="marker">지도마커 제목</label>
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            홈페이지 지도 상의 위치 마커에 나타납니다.
          </span>
          <input type="input" value="<?php checkSetReturnEmpty($siteinfo['marker']) ?>" name="marker" id="marker" class="text width1">
        </div>
      </div>
      <?php } ?>

      <div class="section-row">
        <div class="section-cell col col-title">
          <label for="marker">지도 API key</label>
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            카카오맵을 기본으로 사용합니다. 서비스할 URL에 연결된 API key를 입력해주세요. 
          </span>
          <span class="section-cell-memo">
            API key를 입력하지 않으면 지도와 관련된 모든 기능이 정상작동되지 않을 수 있습니다.
          </span>
          <span class="section-cell-memo">
            카카오맵 API키는 <a href="http://apis.map.kakao.com" target="_blank" class="link">http://apis.map.kakao.com</a>에서 발급받을 수 있습니다.
          </span>
          <input type="input" value="<?php checkSetReturnEmpty($siteinfo['map_key']) ?>" name="map_key" id="map_key" class="text width1">
        </div>
      </div>

      <?php if (isset($siteinfo['map_key']) && !empty($siteinfo['map_key'])) { ?>
      <div class="section-row">
        <div class="section-cell col col-title">
          좌표설정
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            보여질 지도의 좌표를 설정합니다.
          </span>
          <span class="section-cell-memo">
            <span class="rollback" data-y="<?php checkSetReturnEmpty($siteinfo['mapy']) ?>" data-x="<?php checkSetReturnEmpty($siteinfo['mapx']) ?>" data-zoom="<?php checkSetReturnEmpty($siteinfo['mapzoom']) ?>">
              원상태로 복원하시려면 클릭해주세요. 
              위도(y) - <?php checkSetReturnEmpty($siteinfo['mapy']) ?>, 경도(x) - <?php checkSetReturnEmpty($siteinfo['mapx']) ?>, 레벨 - <?php checkSetReturnEmpty($siteinfo['mapzoom']) ?>
            </span>
          </span>
          <label for="mapy" class="multi">위도</label>
          <input type="text" value="<?php checkSetReturnEmpty($siteinfo['mapy']) ?>" name="mapy" id="mapy" class="text width2 multi">
          <label for="mapx" class="multi">경도</label>
          <input type="text" value="<?php checkSetReturnEmpty($siteinfo['mapx']) ?>" name="mapx" id="mapx" class="text width2 multi">
          <label for="mapzoom" class="multi">레벨</label>
          <select name="mapzoom" id="mapzoom">
            <?php for($i = 1; $i < 15; $i++) { ?>
              <option value="<?php echo $i ?>"<?php if ((int)$siteinfo['mapzoom'] === $i) echo ' selected' ?>><?php echo $i ?>레벨</option>
            <?php } ?>
          </select>
          <!-- <input type="text" value="<?php checkSetReturnEmpty($siteinfo['mapzoom']) ?>" name="mapzoom" id="mapzoom" class="text width2 multi"> -->
        </div>
      </div>
      <?php } ?>

      <div class="section-row">
        <div class="section-cell col col-title">
          좌표 설정 도구
        </div>
        <div class="section-cell col col-content">
          <?php if (isset($siteinfo['map_key']) && !empty($siteinfo['map_key'])) { ?>
          <span class="section-cell-memo">
            마커를 드래그하여 좌표를 구할 수도 있습니다.
          </span>
          <div class="kakaomap-area">
            <div class="map-search">
              <div class="search-head">
                <div class="kakaomap-control">
                  <input type="text" class="kakaomap-search" placeholder="지도에서 검색할 주소를 입력해주세요.">
                  <a href="#search" class="kakaomap-search-submit">지도 검색</a>
                </div>
              </div>
              <div class="search-body">
                <div class="search-body-inner">
                  <div class="result-empty">
                    <div class="result-empty-inner">
                      검색된 결과가 없습니다.
                    </div>
                  </div>
                  <div class="result-exist">
                    <ul></ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="map-viewer">
              <div id="map" style="width:500px;height:400px;"></div>
            </div>
          </div>
          <?php } else { ?>
            <span class="section-cell-memo">
              <span class="warn">현재 사용 불가</span>
            </span>
            <span class="section-cell-memo">
              유효한 '지도 API key'를 저장하시면 좌표 설정 도구를 사용하실 수 있습니다.
            </span>
          <?php } ?>
        </div>
      </div>

    </div>
  </section>

  <section class="section-adm" id="tab-meta">
    <input type="hidden" value="" name="version" id="version">
    <h3 class="section-title">사이트 메타정보</h3>
    <?php echo $tabHtml?>
    <div class="section-contents">
      <div class="section-row">
        <div class="section-cell col col-title">
          <label for="meta_url">사이트 URL</label>
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            홈페이지의 대표 도메인을 입력해주세요.
          </span>
          <input type="input" value="<?php checkSetReturnEmpty($siteinfo['meta_url']) ?>" name="meta_url" id="meta_url" class="text width1">
        </div>
      </div>

      <div class="section-row">
        <div class="section-cell col col-title">
          <label for="meta_kwd">키워드(keyword)</label>
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            포털 사이트에서 수집하는 정보이므로 최대한 관련된 단어를 쉼표로 구분하여 나열해주세요.
          </span>
          <input type="input" value="<?php checkSetReturnEmpty($siteinfo['meta_kwd']) ?>" name="meta_kwd" id="meta_kwd" class="text width1">
        </div>
      </div>

      <div class="section-row">
        <div class="section-cell col col-title">
          <label for="meta_desc">설명(description)</label>
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            예약 시스템 달력 주소(URL)를 입력해주세요.
          </span>
          <input type="input" value="<?php checkSetReturnEmpty($siteinfo['meta_desc']) ?>" name="meta_desc" id="meta_desc" class="text width0">
        </div>
      </div>

      <div class="section-row">
        <div class="section-cell col col-title">
          <label for="meta_desc">오픈 그래프 이미지</label>
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            가로 800px , 세로 800px, PNG 타입의 이미지를 권장합니다.
          </span>
          <span class="section-cell-memo">
            워드마크나 로고 작업시 800px * 800px 이미지 정중앙에 워드마크의 경우 600px * 120px 크기로, 로고의 경우 160px * 160px 크기로 작업하시길 권장합니다.
          </span>
          <span class="section-cell-memo">
            수동 변경시 이미지 경로 : <?php echo DINGS_IMG ?>/og_image.png (수동 변경시 이미지 권한을 777로 설정해야 합니다.)
          </span>
          <div class="og_display">
            <img src="<?php echo $og_image ?>" alt="" id="og_image">
          </div>
          <input type="file" value="" name="og_image" id="og_image_input" accept="image/jpg, image/png" class="blind">
        </div>
      </div>
      <script>
        function readImageUrl(e, s) {
            var fileObj = e.files;
            var file = fileObj[0];
            if (fileObj && file) {
              var fileSize = file.size;
              var fileType = file.type.toLowerCase();
              var allowFormat = ['jpg', 'jpeg', 'png'];
              var sizeRegex = (fileSize < 5242880) && (fileSize != 0) ? true : false;
              var typeRegex = function(){
                var nameArray = fileType.split('/');
                if ($.inArray(nameArray[1], allowFormat) == -1){
                  return false;
                }
                return true;
              }();
              if (sizeRegex && typeRegex) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    s.attr('src', e.target.result);
                }
                reader.readAsDataURL(e.files[0]);
              } else if (!sizeRegex && typeRegex) {
                alert('업로드 가능한 용량은 5mb 미만입니다.');
              } else if (sizeRegex && !typeRegex) {
                alert('jpg, jpeg 파일만 업로드할 수 있습니다.');
              } else {
                alert('용량 5mb 이하, jpg, jpeg 파일만 업로드할 수 있습니다.');
              }
            }
        }
        var old_src = $('#og_image').attr('src');
        $(document).on('change', '#og_image_input', function(){
          var selected_file_name = $(this).val();
          var thumbnail = $('#og_image');
          if ( selected_file_name.length > 0 ) {
            readImageUrl(this, thumbnail);
            return;
          } else {
            thumbnail.attr('src', old_src);
          }
        });
        $('.og_display').click(function(){
          $('#og_image_input').trigger('click');
        });
      </script>

      <div class="section-row">
        <div class="section-cell col col-title">
          <label for="meta_mstr">소유인증 메타태그</label>
        </div>
        <div class="section-cell col col-content">
          <span class="section-cell-memo">
            네이버 웹마스터 등 소유 인증을 위해 메타태그를 입력해야 하는 경우 작성해주세요.
          </span>
          <input type="input" value="<?php checkSetReturnEmpty(trim(htmlspecialchars($siteinfo['meta_mstr']))) ?>" name="meta_mstr" id="meta_mstr" class="text width0">
        </div>
      </div>

    </div>
  </section>

  <div class="control-btn">
      <input type="submit" value="확인" class="btn-submit btns" accesskey="s">
  </div>
</form>
<?php if (isset($siteinfo['map_key']) && !empty($siteinfo['map_key'])) { ?>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?php checkSetReturnEmpty($siteinfo['map_key']) ?>&libraries=services"></script>
<script>
  //초기 맵 설정
  var mapY = '<?php checkSetReturnEmpty($siteinfo['mapy']) ?>';
  var mapX = '<?php checkSetReturnEmpty($siteinfo['mapx']) ?>';
  var mapzoom = '<?php checkSetReturnEmpty($siteinfo['mapzoom']) ?>';
  var container = document.getElementById('map');
  var options = {
    center: new kakao.maps.LatLng(mapY, mapX),
    level: mapzoom
  };
  var map = new kakao.maps.Map(container, options);
  var geocoder = new kakao.maps.services.Geocoder();

  //마커 세팅
  var markerPosition  = new kakao.maps.LatLng(mapY, mapX); 
  var marker = new kakao.maps.Marker({
      position: markerPosition,
      draggable: true,
  });
  marker.setMap(map);
  draggableMarker(marker);

  //주소 검색
  var oldAddr = '';
  function callAddressSearch(){
    var $searchField = $('.kakaomap-search');
    var addr = $searchField.val();
    if (addr.length < 1) {
      alert('입력된 주소가 없습니다.');
      return false;
    }
    if (oldAddr === addr) {
      alert('이미 검색된 주소입니다.')
      return false;
    }
    var $target = $('.result-exist ul');
    var $wrapper = $('.search-body');
    $target.find('li').remove();
    geocoder.addressSearch(addr, function(result, status){
      if (status === kakao.maps.services.Status.OK) {
        $wrapper.addClass('searched');
        $.each(result, function(i, arr){
          var source = '<li class="coords_update" data-y="' + arr['y'] + '" data-x="' + arr['x'] + '">' + arr['address_name'] + '</li>';
          $target.append(source);
        })
        oldAddr = addr;
      } else {
        alert('검색된 내용이 없습니다.');
        $wrapper.removeClass('searched');
      }
    });
  }
  $('.kakaomap-search-submit').click(function(e){
    e.preventDefault();
    callAddressSearch();
  });
  $('.kakaomap-search').keydown(function(e){
    var code = e.keyCode || e.which;
    if(code == 13) { 
      callAddressSearch();
    }
  });

  //좌표 갱신
  function panTo(y, x) {
    var moveLatLon = new kakao.maps.LatLng(y, x);      
    map.panTo(moveLatLon);            
  }
  function markerUpdate(y,x){
    marker.setMap(null);
    var markerPosition  = new kakao.maps.LatLng(y, x); 
    marker = new kakao.maps.Marker({
        position: markerPosition,
        draggable: true,
    });
    marker.setMap(map);
    draggableMarker(marker);
  }
  function updateInputCoords(y, x){
    $('#mapy').val(y);
    $('#mapx').val(x);
  }

  function updateCoords(y, x){
    panTo(y, x);
    markerUpdate(y, x);
    updateInputCoords(y, x);
  }
  $(document).on('click', '.coords_update', function(){
    var y = $(this).data('y');
    var x = $(this).data('x');
    updateCoords(y, x);
  });

  function setZoom(zoom){
    map.setLevel(zoom);
  }
  //좌표 복원
  $(document).on('click', '.rollback', function(){
    var confirmQ = confirm('기존에 저장된 원래 좌표로 복원하시겠습니까?');
    if (confirmQ) {
      var y = $(this).data('y');
      var x = $(this).data('x');

      var zoom = $(this).data('zoom');
      $('#mapzoom').val(zoom);

      setZoom(zoom);
      updateInputCoords(y, x);
      $('.search-body').removeClass('searched');
      $('.kakaomap-search').val('');
      oldAddr = '';
      updateCoords(y, x);
    }
  });

  //드래그 마커 이동 완료 후 처리 
  function draggableMarker(newMarker){
    kakao.maps.event.addListener(newMarker, 'dragend', function(easter_date) {
      var updatedCoords = newMarker.getPosition();
      updateCoords(updatedCoords['Ha'], updatedCoords['Ga']);
    });
  }
  $(document).on('change keydown', '#mapzoom', function(){
    var level = $(this).val();
    setZoom(level);
  });
  kakao.maps.event.addListener(map, 'zoom_changed', function() {        
      var level = map.getLevel();
      $('#mapzoom').val(level);
  });



  //폼에서 엔터로 저장 방지
  $(document).ready(function() {
    $(window).keydown(function(event){
      if(event.keyCode == 13) {
        event.preventDefault();
        return false;
      }
    });
  });
</script>
<?php } ?>
<?php include_once('./admin.tail.php'); ?>
