<?php

include_once 'CUP_dbconfig.php'; // DB 설정 파일

if (isset($_GET['songId'])) {
    $songId = $_GET['songId'];

    // 여기에 songId에 따른 이미지 경로 로직
    $imagePath = "./img/37855.jpg"; // 기본 이미지 경로

    if ($songId == 37854) {
        $imagePath = "./img/37855.jpg";
    } elseif ($songId == 10594) {
        $imagePath = "./img/10594.jpg";
    }
    elseif ($songId == 14260) {
        $imagePath = "./img/14260.jpg";
    }
    elseif ($songId == 46009) {
        $imagePath = "./img/46009.jpg";
    }                        
    elseif ($songId == 89224) {
        $imagePath = "./img/89224.webp";
    }
    elseif ($songId == 99781 || $songId == 99783) {
        $imagePath = "./img/99781.jpg";
    }
    

    echo $imagePath;

} else {
    echo "./img/37855.jpg"; // 기본 이미지 경로 반환
}
?>
