<?php
    include_once 'CUP_dbconfig.php'; // DB 설정 파일
    $dbname = "noraebang";
    mysqli_select_db($conn, $dbname) or die('DB selection failed');

        function ratingStars($avgScore, $maxRating) {
        // Round the average score to the nearest whole number
        $score = round($avgScore);
        $filled = str_repeat('★', $score);
        $empty = str_repeat('☆', $maxRating - $score);
        return $filled . $empty;
    }

    function ratingCircles($avgDifficulty, $maxRating) {
        // Round the average difficulty to the nearest whole number
        $difficulty = round($avgDifficulty);
        $filled = str_repeat('●', $difficulty);
        $empty = str_repeat('○', $maxRating - $difficulty);
        return $filled . $empty;
    }

// songId가 URL에 포함되어 있는지 확인
                if (isset($_GET['songId'])) {
                    $songId = $conn->real_escape_string($_GET['songId']);

                    // 뷰가 존재하는지 확인
                    $checkViewQuery = "SELECT COUNT(*) AS view_exists FROM information_schema.views WHERE table_schema = 'noraebang' AND table_name = 'song_view'";
                    $checkResult = $conn->query($checkViewQuery);
                    $viewExistsRow = $checkResult->fetch_assoc();
                    
                    // 뷰가 존재하지 않으면 생성
                    if ($viewExistsRow['view_exists'] == 0) {
                        $createViewQuery = "CREATE VIEW song_view AS
                                            SELECT
                                                s.Song_ID AS 'ID',
                                                s.Title,
                                                GROUP_CONCAT(DISTINCT a.Name ORDER BY a.Name SEPARATOR ', ') AS 'Artist',
                                                s.type AS 'Type',
                                                GROUP_CONCAT(DISTINCT g.Genre_Name ORDER BY g.Genre_Name SEPARATOR ', ') AS 'Genre',
                                                s.Lowest,
                                                s.Highest,
                                                COALESCE(AVG(r.Score), 0) / 2 AS 'AvgScore',
                                                COALESCE(AVG(r.Difficulty), 0) / 2 AS 'AvgDifficulty'
                                            FROM
                                                song s
                                                JOIN sings si ON s.Song_ID = si.Song_ID
                                                JOIN artist a ON si.Artist_Name = a.Name
                                                JOIN belongs b ON s.Song_ID = b.Song_ID
                                                JOIN genre g ON b.Genre_ID = g.Genre_ID
                                                LEFT JOIN rates r ON s.Song_ID = r.Song_ID
                                            GROUP BY
                                                s.Song_ID";
                        $conn->query($createViewQuery);
                    }

                    // 뷰를 사용하여 데이터 조회
                    $Viewquery = "SELECT s.ID, s.Title, a.Album_Name as Album, s.Artist, s.Type, s.Genre, s.Lowest, s.Highest, s.AvgScore, s.AvgDifficulty
                                FROM song_view s, song ss, releases r, album a
                                WHERE s.ID = $songId 
                                AND ss.Song_ID = s.ID 
                                AND s.Artist = r.Artist_Name 
                                AND r.Album_ID = ss.Album_ID 
                                AND r.Album_ID = a.Album_ID;";

                    $result = $conn->query($Viewquery);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc(); // 결과 행 가져오기

                        echo "<li>" . htmlspecialchars($row['ID']) . "</li>
                            <li>" . htmlspecialchars($row['Title']) . "</li>
                            <li>" . htmlspecialchars($row['Album']) . "</li>
                            <li>" . htmlspecialchars($row['Artist']) . "</li>
                            <li>" . htmlspecialchars($row['Type']) . "</li>
                            <li>" . htmlspecialchars($row['Genre']) . "</li>
                            <li class='AvgS'>" . ratingStars(isset($row['AvgScore']) ? $row['AvgScore'] : 0, 5) . "</li>
                            <li class='AvgD'>" . ratingCircles(isset($row['AvgDifficulty']) ? $row['AvgDifficulty'] : 0, 5) . "</li>";
                    } else {
                        echo "<li>No details found for this song.</li>";
                    }
                } else {
                    echo "No song ID provided.";
                }

$conn->close();
?>