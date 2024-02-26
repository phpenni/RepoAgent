<?php

$comparisonUrl = 'https://mirror.alpix.eu/endeavouros/repo/state';
$serverliste = new serverliste();
$serverliste->hinzufügen(new Server("https://ftp.belnet.be/mirror/endeavouros/repo/state", "Belgium"));
$serverliste->hinzufügen(new Server("https://ca.gate.endeavouros.com/endeavouros/repo/state","Canada"));
$serverliste->hinzufüger(new Server("https://mirrors.tuna.tsinghua.edu.cn/endeavouros/repo/state","China"));
$serverliste->hinzufüger(new Server("https://mirrors.jlu.edu.cn/endeavouros/repo/state", "China"));
$serverliste->hinzufügen(new Server("https://mirror.sjtu.edu.cn/endeavouros/repo/state", "China"));
$serverliste->hinzufügen(new Server("https://mirror.alpix.eu/endeavouros/repo/state", "Germany"));
$serverliste->hinzufügen(new Server("https://de.freedif.org/EndeavourOS/repo/state", "Germany"));
$serverliste->hinzufügen(new Server("https://mirror.moson.org/endeavouros/repo/state", "Germany"));
$serverliste->hinzufügen(new Server("https://fosszone.csd.auth.gr/endeavouros/repo/state", "Greece"));
$serverliste->hinzufügen(new Server("https://endeavour.remi.lu/repo/state", "France"));
$serverliste->hinzufügen(new Server("https://mirror.albony.xyz/endeavouros/repo/state","India"));
$serverliste->hinzufügen(new Server("https://mirrors.nxtgen.com/endeavouros-mirror/repo/state", "India"));
$serverliste->hinzufügen(new Server("https://md.mirrors.hacktegic.com/endeavouros/repo/state", "Moldova"));
$serverliste->hinzufügen(new Server("https://mirror.jingk.ai/endeavouros/repo/state", "Singapore"));
$serverliste->hinzufügen(new Server("https://mirror.freedif.org/EndeavourOS/repo/state", "Singapore"));
$serverliste->hinzufügen(new Server("https://mirrors.urbanwave.co.za/endeavouros/repo/state", "South Africa"));
$serverliste->hinzufügen(new Server("https://mirror.funami.tech/endeavouros/repo/state", "South Korea"));
$serverliste->hinzufügen(new Server("https://ftp.acc.umu.se/mirror/endeavouros/repo/state", "Sweden"));
$serverliste->hinzufügen(new Server("https://mirror.archlinux.tw/EndeavourOS/repo/state", "Taiwan"));
$serverliste->hinzufügen(new Server("https://fastmirror.pp.ua/endeavouros/repo/state", "Ukraine"));
$serverliste->hinzufügen(new Server("https://endeavouros.ip-connect.info/repo/state", "Ukraine"));
$serverliste->hinzufügen(new Server("https://mirrors.gigenet.com/endeavouros/repo/state", "United States"));

function getWebsiteContent($serverlist) {
    $ch = curl_init($serverlist);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Setze Timeout auf 10 Sekunden
    $content = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
        return $content;
    } else {
        return "Seite nicht erreichbar (HTTP-Code: " . $httpCode . ")";
    }
}

// Den zu vergleichenden Wert einmal abrufen
$comparisonValue = getWebsiteContent($comparisonUrl);

echo '<table border="1">
        <tr>
            <th>URL</th>
            <th>State</th>
            <th>Vergleich mit Referenz</th>
        </tr>';

foreach ($serverliste as $url) {
    list($serverUrl, $country) = explode(' ', $url, 2);

    $content = getWebsiteContent($serverUrl);

    // Vergleiche den abgerufenen Inhalt mit dem Referenzwert
    $comparisonResult = ($content == $comparisonValue) ? 'Übereinstimmung' : 'Keine Übereinstimmung';

    echo '<tr>
            <td>' . $serverUrl . '</td>
            <td>' . htmlspecialchars($content) . ' - ' . $country . '</td>
            <td>' . $comparisonResult . '</td>
          </tr>';
}

echo '</table>';

?>
