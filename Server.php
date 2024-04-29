

<!DOCTYPE html>
<head>
<table>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mirror Status</title>
    <link rel="stylesheet" type="text/css" href="CSS.css">
</table>
</head>
<body>

<?php
function getWebsiteContent($url): bool|string
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $content = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $lines = explode("\n", $content);
    return $lines[0];
    if ($httpCode == 200) {
        return $content;
    } else {
        return "Seite nicht erreichbar (HTTP-Code: " . $httpCode . ")";
    }

}

$comparisonUrl1 = 'https://mirror.alpix.eu/endeavouros/repo/state';
$comparisonUrl = 'https://mirror.alpix.eu/endeavouros/iso/state';

require_once "Mirrorlist.php";
require_once "Mirror.php";
$MirrorList = new MirrorList();
$MirrorList->add(new Mirror("https://ftp.belnet.be/mirror/endeavouros/repo/state", "https://ftp.belnet.be/mirror/endeavouros/iso/state","Belgium", "belnet"));
$MirrorList->add(new Mirror("https://ca.gate.endeavouros.com/endeavouros/repo/state","https://ca.gate.endeavouros.com/endeavouros/iso/state","Canada", "CA.gate"));
$MirrorList->add(new Mirror("https://mirrors.tuna.tsinghua.edu.cn/endeavouros/repo/state","https://mirrors.tuna.tsinghua.edu.cn/endeavouros/iso/state","China", "Tuna"));
$MirrorList->add(new Mirror("https://mirrors.jlu.edu.cn/endeavouros/repo/state", "https://mirrors.jlu.edu.cn/endeavouros/iso/state","China", "jlu"));
$MirrorList->add(new Mirror("https://mirror.sjtu.edu.cn/endeavouros/repo/state", "https://mirror.sjtu.edu.cn/endeavouros/iso/state","China", "sjtu"));
$MirrorList->add(new Mirror("https://mirror.alpix.eu/endeavouros/repo/state", "https://mirror.alpix.eu/endeavouros/iso/state","Germany", "alpix"));
$MirrorList->add(new Mirror("https://de.freedif.org/EndeavourOS/repo/state", "https://de.freedif.org/EndeavourOS/iso/state","Germany", "freedif"));
$MirrorList->add(new Mirror("https://mirror.moson.org/endeavouros/repo/state", "https://mirror.moson.org/endeavouros/iso/state","Germany", "moson"));
$MirrorList->add(new Mirror("https://fosszone.csd.auth.gr/endeavouros/repo/state", "https://fosszone.csd.auth.gr/endeavouros/iso/state","Greece", "fosszone"));
$MirrorList->add(new Mirror("https://mirrors.nxtgen.com/endeavouros-mirror/repo/state", "https://mirrors.nxtgen.com/endeavouros-mirror/iso/state","India", "nxtgen"));
$MirrorList->add(new Mirror("https://md.mirrors.hacktegic.com/endeavouros/repo/state", "https://md.mirrors.hacktegic.com/endeavouros/iso/state","Moldova", "hacktegic"));
$MirrorList->add(new Mirror("https://mirror.jingk.ai/endeavouros/repo/state", "https://mirror.jingk.ai/endeavouros/iso/state","Singapore", "jingk"));
$MirrorList->add(new Mirror("https://mirror.freedif.org/EndeavourOS/repo/state", "https://mirror.jingk.ai/endeavouros/iso/state","Singapore", "mirror.freedif"));
$MirrorList->add(new Mirror("https://mirrors.urbanwave.co.za/endeavouros/repo/state", "https://mirrors.urbanwave.co.za/endeavouros/iso/state","South Africa", "urbanwave"));
$MirrorList->add(new Mirror("https://mirror.funami.tech/endeavouros/repo/state", "https://mirror.funami.tech/endeavouros/iso/state","South Korea", "funami"));
$MirrorList->add(new Mirror("https://ftp.acc.umu.se/mirror/endeavouros/repo/state", "https://ftp.acc.umu.se/mirror/endeavouros/iso/state","Sweden", "acc"));
$MirrorList->add(new Mirror("https://mirror.archlinux.tw/EndeavourOS/repo/state", "https://mirror.archlinux.tw/EndeavourOS/iso/state","Taiwan", "archlinux"));
$MirrorList->add(new Mirror("https://fastmirror.pp.ua/endeavouros/repo/state", "https://fastmirror.pp.ua/endeavouros/iso/state","Ukraine", "fastmirror"));
$MirrorList->add(new Mirror("https://endeavouros.ip-connect.info/repo/state", "https://endeavouros.ip-connect.info/iso/state","Ukraine", "endeavouros"));
$MirrorList->add(new Mirror("https://mirrors.gigenet.com/endeavouros/repo/state", "https://mirrors.gigenet.com/endeavouros/iso/state","United States", "gigenet"));

echo '<table border="1">
        <tr>
              <th>Name</th>
              <th>Land</th>
              <th>Repo URL</th>
              <th>Repo State</th>              
              <th>Repo Check</th>
              <th>ISO URL</th>
              <th>ISO State</th>         
              <th>ISO Check</th>
        </tr>';


foreach ($MirrorList->getMirrors() as $mirror) {
    $contentRepo = getWebsiteContent($mirror->getrepo());
    $contentISO = getWebsiteContent($mirror->getISO());

    $getResultRepoCheck = ($contentRepo === getWebsiteContent($comparisonUrl1)) ? 'Up to date' : 'Not up to date';
    $getResultISOCheck = ($contentISO === getWebsiteContent($comparisonUrl)) ? 'Up to date' : 'Not up to date';

    echo '<tr>
            <td>' . $mirror->getname() . '</td>
            <td>' . $mirror->getLand() . '</td>   
            <td>' . $mirror->getrepo() . '</td>          
            <td>' . htmlspecialchars($contentRepo) . '</td>                      
            <td>' . $getResultRepoCheck . '</td>
            <td>' . $mirror->getISO() . '</td> 
            <td>' . htmlspecialchars($contentISO) . '</td>        
            <td>' . $getResultISOCheck . '</td>
          </tr>';
}
?>
