$(document).ready(function () {
  // 페이지 로드 시 search 매개변수의 상태를 확인하여 검색창을 표시하거나 숨깁니다.
  var searchParam = new URLSearchParams(window.location.search).get("search");
  if (searchParam === "active") {
    $("#karaoke_list").hide();
    $("#searchbox").show();
  } else {
    $("#searchbox").hide();
    $("#karaoke_list").show();
  }

  $(".year_label").click(function () {
    $(this).children().toggle();
    $(this).siblings().children().hide();
  });

  $(".search").click(function () {
    showSearchBox();
  });

  $(".searchoff").click(function () {
    hideSearchBox();
  });

  $(".chart_content").scroll(function () {
    console.log(5);
  });

  $(".top").click(function () {
    $(".chart_content").animate({ scrollTop: 0 }, 500);
  });

  $(".modalbg").click(function () {
    $(this).css("display", "none");
    $(".modalcontents").css("display", "none");
  });

  // $(".charttable")
  //   .children("tbody")
  //   .children("tr")
  //   .click(function () {
  //     $(".modalbg").css("display", "block");
  //     $(".modalcontents").css("display", "grid");
  //     var height = $(".modalinfo").children().innerHeight();
  //     $(".modalinfo").children().animate({ scrollTop: height }, 0);
  //     $(".modalinfo").children().css("overflow", "hidden");
  //   });

  $(".charttable tbody tr").click(function () {
    $(".modalbg").css("display", "block");
    $(".modalcontents").css("display", "grid");
    console.log("Row clicked");

    var songId = $(this).find("td:first-child").text(); // Song_ID 추출
    console.log("songId:", songId);
    $.ajax({
      url: "getImagePath.php",
      type: "GET",
      data: { songId: songId },
      success: function (imgSrc) {
        // 콘솔에 imgSrc 값 로그
        console.log(imgSrc);

        // 콘솔에 새로 생성된 img 태그 로그
        console.log($("<img>").attr("src", imgSrc).attr("alt", "Album Image"));

        if ($(".modalalbum img").length === 0) {
          $(".modalalbum").append($("<img>").attr("alt", "Album Image"));
        }
        $(".modalalbum img").attr("src", imgSrc);
      },
    });

    // 나머지 정보를 가져오는 AJAX 요청 (예: Info.php)
    $.ajax({
      url: "Info.php", // 나머지 정보를 제공하는 PHP 스크립트
      type: "GET",
      data: { songId: songId },
      success: function (infoResponse) {
        $(".modalinfoval ul").html(infoResponse);
        // 모달 표시
      },
    });

    $(".modalinfohead").animate({ scrollTop: height }, 0);
    $(".modalinfoval").animate({ scrollTop: height }, 0);
    $(".modalinfoval").css("overflow", "hidden");
    $(".modalinfohead").css("overflow", "hidden");
  });
});

function showSearchBox() {
  $("#karaoke_list").hide();
  $("#searchbox").show();
  updateQueryStringParam("search", "active");
}

function hideSearchBox() {
  $("#searchbox").hide();
  $("#karaoke_list").show();
  updateQueryStringParam("search", null);
}
