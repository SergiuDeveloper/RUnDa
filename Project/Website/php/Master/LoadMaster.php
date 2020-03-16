<?php

require 'MasterLoader/MasterLoader.php';

$masterLoader = new MasterLoader();

$callerFile = get_included_files()[0];
$callerFileHTMLContent = file_get_contents($callerFile);

$callerFileHTMLContent = preg_replace('%(require|include) ((\'Master(/|\\\)LoadMaster.php\')|(\"Master(/|\\\)LoadMaster.php\"))(;?)%', '', $callerFileHTMLContent);

$callerFileHTMLContent = str_replace('<html>', $masterLoader->BeginHTML(), $callerFileHTMLContent);
$callerFileHTMLContent = str_replace('<head>', $masterLoader->BeginHead(), $callerFileHTMLContent);
$callerFileHTMLContent = str_replace('</head>', $masterLoader->EndHead(), $callerFileHTMLContent);
$callerFileHTMLContent = str_replace('</html>', $masterLoader->EndHTML(), $callerFileHTMLContent);

eval('?>' . $callerFileHTMLContent . '<?php');
exit();

?>