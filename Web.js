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

  $(".chart_content").scroll(function(){
    console.log(5);
  });

  $(".top").click(function(){
    $(".chart_content").animate({scrollTop: 0}, 500);
  });

  $(".modalbg").click(function(){
    $(this).css("display","none");
    $(".modalcontents").css("display","none");
  })

  $(".charttable").children('tbody').children('tr').click(function(){
    $('.modalbg').css("display","block");
    $('.modalcontents').css("display","grid");
    var height = $('.modalinfo').children().innerHeight();
    $('.modalinfo').children().animate({scrollTop: height},0);
    $('.modalinfo').children().css("overflow","hidden");
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
