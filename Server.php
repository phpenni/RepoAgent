<?php
$comparisonUrl = 'https://mirror.alpix.eu/endeavouros/repo/state';

$serverlist = new MirrorList();
$serverlist->add(new Mirror("https://ftp.belnet.be/mirror/endeavouros/repo/state", "https://ftp.belnet.be/mirror/endeavouros/iso/state","BEL"));
$serverlist->add(new Mirror("https://ca.gate.endeavouros.com/endeavouros/repo/state","https://ca.gate.endeavouros.com/endeavouros/iso/state","CAN"));
$serverlist->add(new Mirror("https://mirrors.tuna.tsinghua.edu.cn/endeavouros/repo/state","https://mirrors.tuna.tsinghua.edu.cn/endeavouros/iso/state","CHN"));
$serverlist->add(new Mirror("https://mirrors.jlu.edu.cn/endeavouros/repo/state", "https://mirrors.jlu.edu.cn/endeavouros/iso/state","CHN"));
$serverlist->add(new Mirror("https://mirror.sjtu.edu.cn/endeavouros/repo/state", "https://mirror.sjtu.edu.cn/endeavouros/iso/state","CHN"));
$serverlist->add(new Mirror("https://mirror.alpix.eu/endeavouros/repo/state", "https://mirror.alpix.eu/endeavouros/iso/state","DEU"));
$serverlist->add(new Mirror("https://de.freedif.org/EndeavourOS/repo/state", "https://de.freedif.org/EndeavourOS/iso/state","DEU"));
$serverlist->add(new Mirror("https://mirror.moson.org/endeavouros/repo/state", "https://mirror.moson.org/endeavouros/iso/state","DEU"));
$serverlist->add(new Mirror("https://fosszone.csd.auth.gr/endeavouros/repo/state", "https://fosszone.csd.auth.gr/endeavouros/iso/state","GRC"));
$serverlist->add(new Mirror("https://endeavour.remi.lu/repo/state", "https://endeavour.remi.lu/iso/state","FRA"));
$serverlist->add(new Mirror("https://mirror.albony.xyz/endeavouros/repo/state","https://mirror.albony.xyz/endeavouros/iso/state","IND"));
$serverlist->add(new Mirror("https://mirrors.nxtgen.com/endeavouros-mirror/repo/state", "https://mirrors.nxtgen.com/endeavouros-mirror/iso/state","IND"));
$serverlist->add(new Mirror("https://md.mirrors.hacktegic.com/endeavouros/repo/state", "https://md.mirrors.hacktegic.com/endeavouros/iso/state","MDA "));
$serverlist->add(new Mirror("https://mirror.jingk.ai/endeavouros/repo/state", "https://mirror.jingk.ai/endeavouros/iso/state","SGP"));
$serverlist->add(new Mirror("https://mirror.freedif.org/EndeavourOS/repo/state", "https://mirror.freedif.org/EndeavourOS/iso/state","SGP"));
$serverlist->add(new Mirror("https://mirrors.urbanwave.co.za/endeavouros/repo/state", "https://mirrors.urbanwave.co.za/endeavouros/iso/state","ZAF"));
$serverlist->add(new Mirror("https://mirror.funami.tech/endeavouros/repo/state", "https://mirror.funami.tech/endeavouros/iso/state","KOR"));
$serverlist->add(new Mirror("https://ftp.acc.umu.se/mirror/endeavouros/repo/state", "https://ftp.acc.umu.se/mirror/endeavouros/iso/state","SWE"));
$serverlist->add(new Mirror("https://mirror.archlinux.tw/EndeavourOS/repo/state", "https://mirror.archlinux.tw/EndeavourOS/iso/state","TWN"));
$serverlist->add(new Mirror("https://fastmirror.pp.ua/endeavouros/repo/state", "https://fastmirror.pp.ua/endeavouros/iso/state","UKR"));
$serverlist->add(new Mirror("https://endeavouros.ip-connect.info/repo/state", "https://endeavouros.ip-connect.info/iso/state","UKR"));
$serverlist->add(new Mirror("https://mirrors.gigenet.com/endeavouros/repo/state", "https://mirrors.gigenet.com/endeavouros/iso/state","US"));

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

// Den zu vergleichenden Wert einmal abrufen
$comparisonValue = getWebsiteContent($comparisonUrl);

echo '<table border="1">
        <tr>
            <th>Repo URL</th>
            <th>ISO URL</th>
            <th>State</th>
            <th>Repo Check</th>
            <th>ISO Check</th>
        </tr>';

foreach ($serverlist->getMirrors() as $mirror) {
    $mirror->checkRepo();
    $mirror->checkISO();

    $contentRepo = getWebsiteContent($mirror->getrepo());
    $comparisonResultRepo = ($contentRepo == $comparisonValue) ? 'Up to date' : 'Not up to date';

    $contentISO = getWebsiteContent($mirror->getISO());
    $comparisonResultISO = ($contentISO == $comparisonValue) ? 'Up to date' : 'Not up to date';

    echo '<tr>
            <td>' . $mirror->getrepo() . '</td>
            <td>' . $mirror->getISO() . '</td>
            <td>' . htmlspecialchars($contentRepo) . ' - ' . $mirror->getLand() . '</td>
            <td>' . $comparisonResultRepo . '</td>
            <td>' . $comparisonResultISO . '</td>
          </tr>';
}

echo '</table>';
?>
