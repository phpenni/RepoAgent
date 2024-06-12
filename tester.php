<?php
echo "Generäting..."; // Zeigt "Generäting..." sofort an
flush(); // Leitet den Pufferausgang sofort an den Browser weiter
ob_flush(); // Löscht den Ausgabepuffer und leitet den Inhalt sofort an den Browser weiter
?>
