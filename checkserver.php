<?php

$urls = [
    'https://ftp.belnet.be/mirror/endeavouros/repo/state Belgium',
    'https://ca.gate.endeavouros.com/endeavouros/repo/state Canada',
    'https://mirrors.tuna.tsinghua.edu.cn/endeavouros/repo/state China',
    'https://mirrors.jlu.edu.cn/endeavouros/repo/state China',
    'https://mirror.sjtu.edu.cn/endeavouros/repo/state China',
    'https://mirror.alpix.eu/endeavouros/repo/state Germany',
    'https://de.freedif.org/EndeavourOS/repo/state Germany',
    'https://mirror.moson.org/endeavouros/repo/state Germany',
    'https://fosszone.csd.auth.gr/endeavouros/repo/state Greece',
    'https://endeavour.remi.lu/repo/state France',
    'https://mirror.albony.xyz/endeavouros/repo/state India',
    'https://mirrors.nxtgen.com/endeavouros-mirror/repo/state India',
    'https://md.mirrors.hacktegic.com/endeavouros/repo/state Moldova',
    'https://mirror.jingk.ai/endeavouros/repo/state Singapore',
    'https://mirror.freedif.org/EndeavourOS/repo/state Singapore',
    'https://mirrors.urbanwave.co.za/endeavouros/repo/state South Africa',
    'https://mirror.funami.tech/endeavouros/repo/state South Korea',
    'https://ftp.acc.umu.se/mirror/endeavouros/repo/state Sweden',
    'https://mirror.archlinux.tw/EndeavourOS/repo/state Taiwan',
    'https://fastmirror.pp.ua/endeavouros/repo/state Ukraine',
    'https://endeavouros.ip-connect.info/repo/state Ukraine',
    'https://mirrors.gigenet.com/endeavouros/repo/state United States'
];

function getWebsiteContent($url) {
    $ch = curl_init($url);
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

echo '<table border="1">
        <tr>
            <th>URL</th>
            <th>State</th>
        </tr>';

foreach ($urls as $url) {
    list($serverUrl, $country) = explode(' ', $url, 2);

    $content = getWebsiteContent($serverUrl);

    echo '<tr>
            <td>' . $serverUrl . '</td>
            <td>' . htmlspecialchars($content) . ' - ' . $country . '</td>
          </tr>';
}

echo '</table>';

?>
