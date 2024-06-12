<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mirror Status</title>
</head>
<body>

<?php

function getWebsiteContent($url): bool|string
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 7);
    $content = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $lines = explode("\n", $content);
    if ($httpCode == 200) {
        return $lines[0];
    } else {
        if ($httpCode == 0) {
            $httpCode = "Timeout";
        }
        return "ERROR-HTTP-Code: " . $httpCode;
    }
}

//The cache is updated and updated if necessary
function updateCacheIfNeeded($url, $cacheFile)
{
    $lastFetchingTime = file_exists($cacheFile) ? intval(filemtime($cacheFile)) : 0;
    $time = time();
    $fetchInterval = 15*60;

    if (($time - $lastFetchingTime > $fetchInterval) || !$lastFetchingTime) {
        $content = getWebsiteContent($url);
        file_put_contents($cacheFile, $content);
        return $content;
    } else {
        return file_get_contents($cacheFile);
    }
}

// Creation of the outlines of the table
function generateTable($mirrorList, $comparisonUrlRepoCache, $comparisonUrlIsoCache)
{
    $table = '<table id="mirrorTable" border="1">';
    $table .= '<tr>';
    $table .= '<th>Name</th>';
    $table .= '<th>Land</th>';
    $table .= '<th>Repo URL</th>';
    $table .= '<th>Repo State</th>';
    $table .= '<th>Repo Check</th>';
    $table .= '<th>ISO URL</th>';
    $table .= '<th>ISO State</th>';
    $table .= '<th>ISO Check</th>';
    $table .= '</tr>';

    foreach ($mirrorList->getMirrors() as $mirror) {
        $contentIso = getWebsiteContent($mirror->getIso());
        $contentRepo = getWebsiteContent($mirror->getRepo());
        $repoCheck = ($contentRepo === $comparisonUrlRepoCache) ? '<span class="up-to-date"> Up to date</span>' : '<span class="not-up-to-date"> Not up to date</span>';
        $isoCheck = ($contentIso === $comparisonUrlIsoCache) ? '<span class="up-to-date"> Up to date</span>' : '<span class="not-up-to-date"> Not up to date</span>';

        $countryClass = 'country-' . str_replace(' ', '-', $mirror->getLand());
        // Here the data is inserted into the table
        $table .= '<tr>';
        $table .= '<td>' . $mirror->getName() . '</td>';
        $table .= '<td>' . $mirror->getLand() . '</td>';
        $table .= '<td>' . $mirror->getRepo() . '</td>';
        $table .= '<td>' . htmlspecialchars($contentRepo) . '</td>';
        $table .= '<td>' . $repoCheck . '</td>';
        $table .= '<td>' . $mirror->getIso() . '</td>';
        $table .= '<td>' . htmlspecialchars($contentIso) . '</td>';
        $table .= '<td>' . $isoCheck . '</td>';
    }
    $table .= '</table>';
    return $table;
}

// here the data is created as Json
function generateJson($mirrorList, $comparisonUrlRepoCache, $comparisonUrlIsoCache)
{
    $mirrorData = [];
    foreach ($mirrorList->getMirrors() as $mirror) {
        $contentRepo = getWebsiteContent($mirror->getRepo());
        $contentIso = getWebsiteContent($mirror->getIso());
        $repoCheck = ($contentRepo === $comparisonUrlRepoCache) ? 'Up to date' : 'Not up to date';
        $isoCheck = ($contentIso === $comparisonUrlIsoCache) ? 'Up to date' : 'Not up to date';

        $mirrorData[] = [
            'Name' => $mirror->getName(),
            'Land' => $mirror->getLand(),
            'Repo URL' => $mirror->getRepo(),
            'Repo State' => htmlspecialchars($contentRepo),
            'Repo Check' => $repoCheck,
            'ISO URL' => $mirror->getIso(),
            'ISO State' => htmlspecialchars($contentIso),
            'ISO Check' => $isoCheck
        ];
    }

    return json_encode($mirrorData, JSON_PRETTY_PRINT);
}

require_once "Mirrorlist.php";
require_once "Mirror.php";

$mirrorList = new MirrorList();
$mirrorList->add(new Mirror("https://ftp.belnet.be/mirror/endeavouros/repo/state", "https://ftp.belnet.be/mirror/endeavouros/iso/state", "Belgium", "belnet"));
$mirrorList->add(new Mirror("https://ca.gate.endeavouros.com/endeavouros/repo/state", "https://ca.gate.endeavouros.com/endeavouros/iso/state", "Canada", "CA.gate"));
$mirrorList->add(new Mirror("https://mirrors.tuna.tsinghua.edu.cn/endeavouros/repo/state", "https://mirrors.tuna.tsinghua.edu.cn/endeavouros/iso/state", "China", "Tuna"));
$mirrorList->add(new Mirror("https://mirrors.jlu.edu.cn/endeavouros/repo/state", "https://mirrors.jlu.edu.cn/endeavouros/iso/state", "China", "jlu"));
$mirrorList->add(new Mirror("https://mirror.sjtu.edu.cn/endeavouros/repo/state", "https://mirror.sjtu.edu.cn/endeavouros/iso/state", "China", "sjtu"));
$mirrorList->add(new Mirror("https://mirror.alpix.eu/endeavouros/repo/state", "https://mirror.alpix.eu/endeavouros/iso/state", "Germany", "alpix"));
$mirrorList->add(new Mirror("https://de.freedif.org/EndeavourOS/repo/state", "https://de.freedif.org/EndeavourOS/iso/state", "Germany", "freedif"));
$mirrorList->add(new Mirror("https://mirror.moson.org/endeavouros/repo/state", "https://mirror.moson.org/endeavouros/iso/state", "Germany", "moson"));
$mirrorList->add(new Mirror("https://fosszone.csd.auth.gr/endeavouros/repo/state", "https://fosszone.csd.auth.gr/endeavouros/iso/state", "Greece", "fosszone"));
$mirrorList->add(new Mirror("https://mirrors.nxtgen.com/endeavouros-mirror/repo/state", "https://mirrors.nxtgen.com/endeavouros-mirror/iso/state", "India", "nxtgen"));
$mirrorList->add(new Mirror("https://md.mirrors.hacktegic.com/endeavouros/repo/state", "https://md.mirrors.hacktegic.com/endeavouros/iso/state", "Moldova", "hacktegic"));
$mirrorList->add(new Mirror("https://mirror.jingk.ai/endeavouros/repo/state", "https://mirror.jingk.ai/endeavouros/iso/state", "Singapore", "jingk"));
$mirrorList->add(new Mirror("https://mirror.freedif.org/EndeavourOS/repo/state", "https://mirror.freedif.org/EndeavourOS/iso/state", "Singapore", "mirror.freedif"));
$mirrorList->add(new Mirror("https://mirrors.urbanwave.co.za/endeavouros/repo/state", "https://mirrors.urbanwave.co.za/endeavouros/iso/state", "South Africa", "urbanwave"));
$mirrorList->add(new Mirror("https://mirror.funami.tech/endeavouros/repo/state", "https://mirror.funami.tech/endeavouros/iso/state", "South Korea", "funami"));
$mirrorList->add(new Mirror("https://ftp.acc.umu.se/mirror/endeavouros/repo/state", "https://ftp.acc.umu.se/mirror/endeavouros/iso/state", "Sweden", "acc"));
$mirrorList->add(new Mirror("https://mirror.archlinux.tw/EndeavourOS/repo/state", "https://mirror.archlinux.tw/EndeavourOS/iso/state", "Taiwan", "archlinux"));
$mirrorList->add(new Mirror("https://fastmirror.pp.ua/endeavouros/repo/state", "https://fastmirror.pp.ua/endeavouros/iso/state", "Ukraine", "fastmirror"));
$mirrorList->add(new Mirror("https://endeavouros.ip-connect.info/repo/state", "https://endeavouros.ip-connect.info/iso/state", "Ukraine", "endeavouros"));
$mirrorList->add(new Mirror("https://mirrors.gigenet.com/endeavouros/repo/state", "https://mirrors.gigenet.com/endeavouros/iso/state", "United States", "gigenet"));

$filenameHtml = "mirror_table.html";
$filenameJson = "mirror_info.json";
$time = time();
$cacheTime = 1;

//Here you will be asked whether the cache file is still there or whether it needs to be regenerated
$fileEditTimeHtml = file_exists($filenameHtml) ? filemtime($filenameHtml) : 0;
if (file_exists($filenameHtml) && ($time - $fileEditTimeHtml < $cacheTime)) {
    $tableString = file_get_contents($filenameHtml);
} else {
    $comparisonUrlRepoCache = updateCacheIfNeeded("https://mirror.alpix.eu/endeavouros/repo/state", "comparison_urlrepo_cache.txt");
    $comparisonUrlIsoCache = updateCacheIfNeeded("https://mirror.alpix.eu/endeavouros/iso/state", "comparison_urliso_cache.txt");

    $tableString = generateTable($mirrorList, $comparisonUrlRepoCache, $comparisonUrlIsoCache);
    $tableString = "<style>" . file_get_contents("CSS.css") . "</style>" . $tableString;

    file_put_contents($filenameHtml, $tableString);
}

$fileEditTimeJson = file_exists($filenameJson) ? filemtime($filenameJson) : 0;
if (!file_exists($filenameJson) || ($time - $fileEditTimeJson >= $cacheTime)) {
    $comparisonUrlRepoCache = updateCacheIfNeeded("https://mirror.alpix.eu/endeavouros/repo/state", "comparison_urlrepo_cache.txt");
    $comparisonUrlIsoCache = updateCacheIfNeeded("https://mirror.alpix.eu/endeavouros/iso/state", "comparison_urliso_cache.txt");

    $jsonString = generateJson($mirrorList, $comparisonUrlRepoCache, $comparisonUrlIsoCache);
    file_put_contents($filenameJson, $jsonString);
}

echo ('Erfolgreich abgespeichert');
?>

</body>
</html>
