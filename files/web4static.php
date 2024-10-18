<?php

$fileRun = 'web4static/run4Static.php';
$url = 'http://192.168.1.1:88/ext-ui/addons/web4static.php';

$ipsetPath = rtrim(shell_exec("readlink /opt/etc/init.d/S03ipset-table | sed 's/scripts.*/lists/'"));
$birdPath = rtrim(shell_exec("readlink /opt/etc/init.d/S02bird-table | sed 's/scripts.*/lists/'"));

$ipsetFiles = [];
$birdFiles = [];

if (is_dir($ipsetPath)) {
    $ipsetFiles = explode("\n", trim(shell_exec("ls $ipsetPath/*.list 2>/dev/null")));
}

if (is_dir($birdPath)) {
    $birdFiles = explode("\n", trim(shell_exec("ls $birdPath/*.list 2>/dev/null")));
}

$files = [];

if (!empty($ipsetFiles)) {
    $files = array_merge(
        $files,
        array_combine(array_map(fn($file) => basename($file, '.list'), $ipsetFiles), $ipsetFiles)
    );
}

if (!empty($birdFiles)) {
    $files = array_merge(
        $files,
        array_combine(array_map(fn($file) => basename($file, '.list'), $birdFiles), $birdFiles)
    );
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $content) {
        $file = $files[$key];
        file_put_contents($file, $content);
    }
    http_response_code(200);
    exit();
}

$texts = array_map('file_get_contents', $files);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>web4static</title>
    <!-- Для iOS -->
    <link rel="apple-touch-icon" href="https://raw.githubusercontent.com/spatiumstas/web4static/refs/heads/main/files/apple-touch-icon.png">

    <!-- Для иконки в формате .ico для браузеров -->
    <link rel="icon" href="https://img.icons8.com/external-vectorslab-flat-vectorslab/48/external-Vpn-ai-security-and-security-vectorslab-flat-vectorslab-2.png" alt="external-Vpn-ai-security-and-security-vectorslab-flat-vectorslab-2" sizes="48x48" type="image/x-icon">

    <!-- Для Android и других платформ -->
    <link rel="icon" href="https://img.icons8.com/external-vectorslab-flat-vectorslab/192/external-Vpn-ai-security-and-security-vectorslab-flat-vectorslab-2.png" alt="external-Vpn-ai-security-and-security-vectorslab-flat-vectorslab-2" sizes="192x192">

    <link rel="stylesheet" href="web4static/styles.css">
    <script src="web4static/script.js" defer></script>
     <script>
         var fileRun = '<?php echo $fileRun; ?>';
     </script>
</head>
<body>

<header>
    <pre>
        <?php echo htmlspecialchars(file_get_contents('web4static/ascii.txt')); ?>
    </pre>
</header>
<body>
    <main>
        <form id="mainForm" action="" method="post">
            <?php foreach ($files as $key => $path): ?>
                <input type="button" onclick="showSection('<?php echo $key; ?>')" value="<?php echo $key; ?>" />
            <?php endforeach; ?>

            <?php foreach ($files as $key => $path): ?>
                <div id="<?php echo $key; ?>" class="form-section" style="display:none;">
                    <div class="textarea-container">
                        <textarea name="<?php echo $key; ?>"><?php echo htmlspecialchars($texts[$key]); ?></textarea>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="button-container">
                <input type="submit" value="Save & Restart" />
            </div>
        </form>
    </main>
</body>
<footer>
<button onclick="toggleTheme()" id="theme-toggle" aria-label="Toggle Dark Mode">
    <svg id="sun-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="5"></circle>
        <line x1="12" y1="1" x2="12" y2="3"></line>
        <line x1="12" y1="21" x2="12" y2="23"></line>
        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
        <line x1="1" y1="12" x2="3" y2="12"></line>
        <line x1="21" y1="12" x2="23" y2="12"></line>
        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
    </svg>
    <svg id="moon-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
        <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
    </svg>
</button>
<a href="https://github.com/spatiumstas/web4static" target="_blank">
    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0 0 30 30">
        <path d="M15,3C8.373,3,3,8.373,3,15c0,5.623,3.872,10.328,9.092,11.63C12.036,26.468,12,26.28,12,26.047v-2.051
            c-0.487,0-1.303,0-1.508,0c-0.821,0-1.551-0.353-1.905-1.009c-0.393-0.729-0.461-1.844-1.435-2.526
            c-0.289-0.227-0.069-0.486,0.264-0.451c0.615,0.174,1.125,0.596,1.605,1.222c0.478,0.627,0.703,0.769,1.596,0.769
            c0.433,0,1.081-0.025,1.691-0.121c0.328-0.833,0.895-1.6,1.588-1.962c-3.996-0.411-5.903-2.399-5.903-5.098
            c0-1.162,0.495-2.286,1.336-3.233C9.053,10.647,8.706,8.73,9.435,8c1.798,0,2.885,1.166,3.146,1.481
            C13.477,9.174,14.461,9,15.495,9c1.036,0,2.024,0.174,2.922,0.483C18.675,9.17,19.763,8,21.565,8
            c0.732,0.731,0.381,2.656,0.102,3.594c0.836,0.945,1.328,2.066,1.328,3.226c0,2.697-1.904,4.684-5.894,5.097
            C18.199,20.49,19,22.1,19,23.313v2.734c0,0.104-0.023,0.179-0.035,0.268C23.641,24.676,27,20.236,27,15C27,8.373,21.627,3,15,3z">
        </path>
    </svg>
</a>
</footer>
</html>