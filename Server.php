<?php

require_once "Mirror.php";
require_once "Mirrorlist.php";

$MirrorList = new MirrorList();
$MirrorList->add(new Mirror("https://ftp.belnet.be/mirror/endeavouros/repo/state", "https://ftp.belnet.be/mirror/endeavouros/iso/state","Belgium"));
$MirrorList->add(new Mirror("https://ca.gate.endeavouros.com/endeavouros/repo/state","https://ca.gate.endeavouros.com/endeavouros/iso/state","Canada"));
$MirrorList->add(new Mirror("https://mirrors.tuna.tsinghua.edu.cn/endeavouros/repo/state","https://mirrors.tuna.tsinghua.edu.cn/endeavouros/iso/state","China"));
$MirrorList->add(new Mirror("https://mirrors.jlu.edu.cn/endeavouros/repo/state", "https://mirrors.jlu.edu.cn/endeavouros/iso/state","China"));
$MirrorList->add(new Mirror("https://mirror.sjtu.edu.cn/endeavouros/repo/state", "https://mirror.sjtu.edu.cn/endeavouros/iso/state","China"));
$MirrorList->add(new Mirror("https://mirror.alpix.eu/endeavouros/repo/state", "https://mirror.alpix.eu/endeavouros/iso/state","Germany"));
$MirrorList->add(new Mirror("https://de.freedif.org/EndeavourOS/repo/state", "https://de.freedif.org/EndeavourOS/iso/state","Germany"));
$MirrorList->add(new Mirror("https://mirror.moson.org/endeavouros/repo/state", "https://mirror.moson.org/endeavouros/iso/state","Germany"));
$MirrorList->add(new Mirror("https://fosszone.csd.auth.gr/endeavouros/repo/state", "https://fosszone.csd.auth.gr/endeavouros/iso/state","Greece"));
$MirrorList->add(new Mirror("https://endeavour.remi.lu/repo/state", "https://endeavour.remi.lu/iso/state","France"));
$MirrorList->add(new Mirror("https://mirror.albony.xyz/endeavouros/repo/state","https://mirror.albony.xyz/endeavouros/iso/state","India"));
$MirrorList->add(new Mirror("https://mirrors.nxtgen.com/endeavouros-mirror/repo/state", "https://mirrors.nxtgen.com/endeavouros-mirror/iso/state","India"));
$MirrorList->add(new Mirror("https://md.mirrors.hacktegic.com/endeavouros/repo/state", "https://md.mirrors.hacktegic.com/endeavouros/iso/state","Moldova "));
$MirrorList->add(new Mirror("https://mirror.jingk.ai/endeavouros/repo/state", "https://mirror.jingk.ai/endeavouros/iso/state","Singapore"));
$MirrorList->add(new Mirror("https://mirror.freedif.org/EndeavourOS/repo/state", "https://mirror.freedif.org/EndeavourOS/iso/state","Singapore"));
$MirrorList->add(new Mirror("https://mirrors.urbanwave.co.za/endeavouros/repo/state", "https://mirrors.urbanwave.co.za/endeavouros/iso/state","South Africa"));
$MirrorList->add(new Mirror("https://mirror.funami.tech/endeavouros/repo/state", "https://mirror.funami.tech/endeavouros/iso/state","South Korea"));
$MirrorList->add(new Mirror("https://ftp.acc.umu.se/mirror/endeavouros/repo/state", "https://ftp.acc.umu.se/mirror/endeavouros/iso/state","Sweden"));
$MirrorList->add(new Mirror("https://mirror.archlinux.tw/EndeavourOS/repo/state", "https://mirror.archlinux.tw/EndeavourOS/iso/state","Taiwan"));
$MirrorList->add(new Mirror("https://fastmirror.pp.ua/endeavouros/repo/state", "https://fastmirror.pp.ua/endeavouros/iso/state","Ukraine"));
$MirrorList->add(new Mirror("https://endeavouros.ip-connect.info/repo/state", "https://endeavouros.ip-connect.info/iso/state","Ukraine"));
$MirrorList->add(new Mirror("https://mirrors.gigenet.com/endeavouros/repo/state", "https://mirrors.gigenet.com/endeavouros/iso/state","United States"));

function getWebsiteContent($url): bool|string
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $content = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
        return $content;
    } else {
        return "Seite nicht erreichbar (HTTP-Code: " . $httpCode . ")";
    }
}


$comparisonValue = getWebsiteContent($comparisonUrl);

echo '<table border="1">
        <tr>
            <th>Repo URL</th>
            <th>ISO URL</th>
            <th>State</th>
            <th>Repo Check</th>
            <th>ISO Check</th>
        </tr>';

foreach ($MirrorList->getMirrors() as $mirror) {
    $contentRepo = getWebsiteContent($mirror->getRepo());
    $comparisonResultRepo = ($contentRepo == $comparisonUrl) ? 'Up to date' : 'Not up to date';

    $contentISO = getWebsiteContent($mirror->getISO());
    $comparisonResultISO = ($contentISO == $comparisonUrl) ? 'Up to date' : 'Not up to date';

    echo '<tr>
            <td>' . $mirror-> getRepo() . '</td>
            <td>' . $mirror-> getISO() . '</td>
            <td>' . htmlspecialchars($contentRepo) . ' - ' . $mirror-> getLand() . '</td>
            <td>' . $comparisonResultRepo . '</td>
            <td>' . $comparisonResultISO . '</td>
          </tr>';
}

echo '</table>';
?>