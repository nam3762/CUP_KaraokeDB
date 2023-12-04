<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Web.css" type="text/css">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"
    />
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
  />
    <script  src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="./Web.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="containera">
    <div class="headera">
        <p id="pageTitle" onclick="window.location.href='CUP_select.php?company=tj&year=2023';" style="cursor:pointer;">CUP</p>
    </div>
        <div class="bodya">
            <div class="navbar" id="karaoke_list">
                <i class="search fas fa-search fa-2x"></i>
                <div></div>
                <div class="navbar_content">
                    <p class="karaoke_label">CHART</p>
                    <ul>
                        <li class="year_label">TJ
                            <ul class="year_list">
                                <li><a href="CUP_select.php?company=tj&year=2018">2018</a></li>
                                <li><a href="CUP_select.php?company=tj&year=2019">2019</a></li>
                                <li><a href="CUP_select.php?company=tj&year=2020">2020</a></li>
                                <li><a href="CUP_select.php?company=tj&year=2021">2021</a></li>
                                <li><a href="CUP_select.php?company=tj&year=2022">2022</a></li>
                                <li><a href="CUP_select.php?company=tj&year=2023">2023</a></li>
                            </ul>
                        </li>
                        <li class="year_label">GY
                            <ul class="year_list">
                                <li><a href="">2018</a></li>
                                <li><a href="">2019</a></li>
                                <li><a href="">2020</a></li>
                                <li><a href="">2021</a></li>
                                <li><a href="">2022</a></li>
                                <li><a href="">2023</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div></div>
            </div>
            <div class="navbar" id="searchbox">
                <i class="searchoff fas fa-search fa-2x"></i>
                <form class="searchform" action="CUP_select.php" method="post">
                    <label for="song">Song</label>
                    <input type="text" name="song">
                    <label for="artist">Artist</label>
                    <input type="text" name="artist">
                    <label for="pitch">Highest Pitch</label>
                    <select name="lowOct" id="">
                        <option value="-">-</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="3">4</option>
                    </select>
                    <select name="low" id="">
                        <option value="-">-</option>
                        <option value="Do">Do</option>
                        <option value="Re">Re</option>
                        <option value="Mi">Mi</option>
                        <option value="Fa">Fa</option>
                        <option value="Sol">Sol</option>
                        <option value="La">La</option>
                        <option value="Si">Si</option>
                    </select>
                    <p>~</p>
                    <select name="highOct" id="">
                        <option value="-">-</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="3">4</option>
                    </select>
                    <select name="high" id="">
                        <option value="-">-</option>
                        <option value="Do">Do</option>
                        <option value="Re">Re</option>
                        <option value="Mi">Mi</option>
                        <option value="Fa">Fa</option>
                        <option value="Sol">Sol</option>
                        <option value="La">La</option>
                        <option value="Si">Si</option>
                    </select>
                    <label for="Genre">Genre</label>
                    <div class="checkbox">
                        <input id="select1" class="genre" type="checkbox" name="genreCheck[]" value="R&B"><label for="select1">R&B</label>
                        <input id="select2" class="genre" type="checkbox" name="genreCheck[]" value="Dance"><label for="select2">Dance</label>
                        <input id="select3" class="genre" type="checkbox" name="genreCheck[]" value="Rock"><label for="select3">Rock</label>
                        <input id="select4" class="genre" type="checkbox" name="genreCheck[]" value="Balad"><label for="select4">Balad</label>
                    </div>
                    <div class="checkbox">
                        <input id="select5" class="genre" type="checkbox" name="genreCheck[]" value="Indie"><label for="select5">Indie</label>
                        <input id="select6" class="genre" type="checkbox" name="genreCheck[]" value="Trot"><label for="select6">Trot</label>
                        <input id="select7" class="genre" type="checkbox" name="genreCheck[]" value="Fork"><label for="select7">Fork</label>
                        <input id="select8" class="genre" type="checkbox" name="genreCheck[]" value="Hiphop"><label for="select8">Hiphop</label>
                    </div>
                    <button type="submit" class="searchbtn">Search</button>
                </form>
            </div>
            <div class="chart">
                <div></div>
                <div class="chart_content">
                    <!-- PHP 코드를 여기에 삽입 -->
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

                function pitchNumberToString($number) {
                    // Define the mapping from numbers to pitch names
                    $pitchMap = [
                        -12 => 'C1', -11 => 'C#1', -10 => 'D1', -9 => 'D#1',
                        -8 => 'E1', -7 => 'E#1', -6 => 'F1', -5 => 'G1',
                        -4 => 'G#1', -3 => 'A1', -2 => 'A#1', -1 => 'B1',
                        0 => 'C2', 1 => 'C#2', 2 => 'D2', 3 => 'D#2',
                        4 => 'E2', 5 => 'E#2', 6 => 'F2', 7 => 'G2',
                        8 => 'G#2', 9 => 'A2', 10 => 'A#2', 11 => 'B2',
                        12 => 'C3', 13 => 'C#3', 14 => 'D3', 15 => 'D#3',
                        16 => 'E3', 17 => 'E#3', 18 => 'F3', 19 => 'G3',
                        20 => 'G#3', 21 => 'A3', 22 => 'A#3', 23 => 'B3',
                        24 => 'C4', 25 => 'C#4', 26 => 'D4', 27 => 'D#4',
                        28 => 'E4', 29 => 'E#4', 30 => 'F4', 31 => 'G4',
                        32 => 'G#4', 33 => 'A4', 34 => 'A#4', 35 => 'B4'
                    ];

                    // Check if the number exists in the map and return the pitch name
                    if (array_key_exists($number, $pitchMap)) {
                        return $pitchMap[$number];
                    }

                    // Return a default value or handle the error as needed
                    return "Unknown";
                }

                function GenreToString($GenreName) {
                    // Define the mapping from genres to number
                    $GenreMap = [
                        'R&B' => 1, 'Dance' => 2, 'Rock' => 3, 'Balad' => 4, 
                        'Indie' => 5, 'Trot' => 6, 'Fork' => 7, 'Hiphop' => 8
                    ];

                    // Check if the number exists in the map and return the pitch name
                    if (array_key_exists($GenreName, $GenreMap)) {
                        return $GenreMap[$GenreName];
                    }

                    // Return a default value or handle the error as needed
                    return "Unknown";
                }

                
                ///////////////////////////////////////////// 년도별 차트 part ////////////////////////////////////////////

                // GET 요청으로부터 년도별 차트 조회
                if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['year']) && ctype_digit($_GET['year'])) {
                    $year = mysqli_real_escape_string($conn, $_GET['year']);
                    $companyId = 1; // TJ의 Company_ID

                    // 해당 연도와 회사 ID에 해당하는 순위를 찾기 위한 쿼리를 작성합니다.
                    $chartQuery = "SELECT 
                                    c.Ranking, 
                                    s.Title, 
                                    GROUP_CONCAT(DISTINCT ar.Name ORDER BY ar.Name SEPARATOR ', ') AS Artist, 
                                    c.Year
                                FROM 
                                    chart c
                                    INNER JOIN song s ON c.Song_ID = s.Song_ID
                                    INNER JOIN sings si ON s.Song_ID = si.Song_ID
                                    INNER JOIN artist ar ON si.Artist_Name = ar.Name
                                WHERE 
                                    c.Company_ID = {$companyId} 
                                    AND c.Year = {$year}
                                GROUP BY 
                                    s.Song_ID, c.Ranking, s.Title, c.Year
                                ORDER BY 
                                    c.Ranking ASC;";

                    // 쿼리 실행
                    $chartResult = $conn->query($chartQuery);


                    // 결과를 표로 출력합니다.
                    if ($chartResult->num_rows > 0) {
                        echo "<table class='charttable'>";
                        echo "<tr>
                                <th>Ranking</th>
                                <th>Title</th>
                                <th>Artist</th>
                                <th>Year</th>
                            </tr>";
                        while ($row = $chartResult->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['Ranking']) . "</td>
                                    <td>" . htmlspecialchars($row['Title']) . "</td>
                                    <td>" . htmlspecialchars($row['Artist']) . "</td>
                                    <td>" . htmlspecialchars($row['Year']) . "</td>
                                </tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "No results found for this year.";
                    }
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    ///////////////////////////////////////////// 검색 part ////////////////////////////////////////////
                    // 사용자 입력을 안전하게 처리
                    $songInput = mysqli_real_escape_string($conn, $_POST['song']);
                    $artistInput = mysqli_real_escape_string($conn, $_POST['artist']);

                    // 사용자가 선택한 장르가 있는지 확인합니다.
                    $genreSelections = isset($_POST['genreCheck']) ? $_POST['genreCheck'] : [];
                    $genreIds = [];

                    // 선택된 장르 이름을 숫자로 변환합니다.
                    foreach ($genreSelections as $genreName) {
                        // GenreToString 함수를 사용해 문자열 장르를 숫자 ID로 변환
                        $genreId = GenreToString($genreName);
                        if ($genreId !== "Unknown") { // "Unknown"은 유효하지 않은 장르를 나타냅니다.
                            $genreIds[] = $genreId;
                        }
                    }

                    // 음계를 숫자로 매핑합니다. 여기서는 2옥타브 도를 0으로 간주합니다.
                    $pitches = array(
                        'Do' => 0, 'Re' => 2, 'Mi' => 4, 'Fa' => 5,
                        'Sol' => 7, 'La' => 9, 'Si' => 11
                        // 반음을 추가하려면 여기에 '도#', '레#', ... 등을 추가합니다.
                    );

                    // 사용자가 옥타브와 음계를 선택하지 않았을 경우를 위한 기본값 설정 ('-')
                    $lowOct = isset($_POST['lowOct']) && $_POST['lowOct'] !== '-' ? (int)$_POST['lowOct'] : null;
                    $highOct = isset($_POST['highOct']) && $_POST['highOct'] !== '-' ? (int)$_POST['highOct'] : null;
                    $lowNote = isset($_POST['low']) && $_POST['low'] !== '-' ? $_POST['low'] : null;
                    $highNote = isset($_POST['high']) && $_POST['high'] !== '-' ? $_POST['high'] : null;
                    // low와 high pitch를 숫자로 변환합니다. 여기서 옥타브 수는 12개의 반음마다 1씩 증가합니다.
                    // $lowPitchNumber = (($lowOct - 2) * 12) + $pitches[$lowNote];
                    // $highPitchNumber = (($highOct - 2) * 12) + $pitches[$highNote];
                    $lowPitchNumber = $lowOct !== null && $lowNote !== null ? (($lowOct - 2) * 12) + $pitches[$lowNote] : null;
                    $highPitchNumber = $highOct !== null && $highNote !== null ? (($highOct - 2) * 12) + $pitches[$highNote] : null;

                    // WHERE 절 조건을 구성합니다.
                    $whereConditions = [];
                    
                    // song, artist where 절
                    // 노래 제목 또는 ID로 검색하는 조건을 추가합니다.
                    if (!empty($songInput)) {
                        // 입력이 숫자인지 확인하여 Song_ID로 검색할지 결정합니다.
                        if (ctype_digit($songInput)) {
                            // 사용자 입력이 숫자일 경우, Song_ID로 검색합니다.
                            $whereConditions[] = "s.Song_ID = $songInput";
                        } else {
                            // 사용자 입력이 숫자가 아닐 경우, 제목으로 검색합니다.
                            $whereConditions[] = "s.Title LIKE '%" . $songInput . "%'";
                        }
                    }

                    if (!empty($artistInput)) {
                        $whereConditions[] = "a.Name LIKE '%" . $artistInput . "%'";
                    }

                    // 음, 옥타브 where 절
                    if ($lowOct !== null && array_key_exists($lowNote, $pitches)) {
                        $whereConditions[] = "s.Highest >= $lowPitchNumber";
                    }
                    if ($highOct !== null && array_key_exists($highNote, $pitches)) {
                        $whereConditions[] = "s.Highest <= $highPitchNumber";
                    }

                    // 사용자가 하나 이상의 장르를 선택했을 경우에만 WHERE 절에 장르 조건을 추가합니다.
                    if (!empty($genreIds)) {
                        $whereConditions[] = "b.Genre_ID IN (" . implode(', ', $genreIds) . ")";
                    } else {
                        // 장르를 선택하지 않았을 경우, 모든 장르를 포함하는 조건을 설정합니다.
                        $genreIdsString = null;
                    }

                    // 조건이 하나도 없는 경우를 방지합니다.
                    if (empty($whereConditions)) {
                        $whereConditions[] = "1"; // 모든 결과를 반환하는 조건입니다.
                    }
                    
                    // WHERE 절을 조합합니다.
                    $whereClause = implode(' AND ', $whereConditions);

                    // SQL 쿼리를 준비합니다.
                    $sQuery = "SELECT
                                s.Song_ID AS '#',
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
                            WHERE
                                $whereClause
                            GROUP BY
                                s.Song_ID";


                    if (!empty($genreIds)) {
                        $genreIdsString = implode(',', $genreIds);
                        // 사용자가 선택한 장르 중 하나라도 일치하는 노래를 가져오기 위한 HAVING 절을 추가합니다.
                        $sQuery .= " HAVING SUM(b.Genre_ID IN ($genreIdsString)) > 0";
                    }

                    $sResult = $conn->query($sQuery);

                    // 입력받은거 출력
                    if ($sResult->num_rows > 0) {
                        echo "<table class='charttable'>";
                        echo "<tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Artist</th>
                                <th>Type</th>
                                <th>Genre</th>
                                <th>Lowest</th>
                                <th>Highest</th>
                                <th>Score</th>
                                <th>Difficulty</th>
                            </tr>";
                        while ($row = $sResult->fetch_assoc()) {
                            $score = isset($row['Score']) && is_numeric($row['Score']) ? $row['Score'] : 0;
                            $difficulty = isset($row['Difficulty']) && is_numeric($row['Difficulty']) ? $row['Difficulty'] : 0;
                            $lowestPitchString = pitchNumberToString($row['Lowest']);
                            $highestPitchString = pitchNumberToString($row['Highest']);
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['#']) . "</td>
                                    <td>" . htmlspecialchars($row['Title']) . "</td>
                                    <td>" . htmlspecialchars($row['Artist']) . "</td>
                                    <td>" . htmlspecialchars($row['Type']) . "</td>
                                    <td>" . htmlspecialchars($row['Genre']) . "</td>
                                    <td>" . htmlspecialchars($lowestPitchString) . "</td>
                                    <td>" . htmlspecialchars($highestPitchString) . "</td>
                                    <td>" . ratingStars(isset($row['AvgScore']) ? $row['AvgScore'] : 0, 5) . "</td>
                                    <td>" . ratingCircles(isset($row['AvgDifficulty']) ? $row['AvgDifficulty'] : 0, 5) . "</td>
                                </tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "No results found";
                    }
                    $conn->close();
                }
                ?>
                <!-- PHP 코드 끝 -->
                </div>
                <div></div>
            </div>
        </div>
    </div>
</body>
</html>