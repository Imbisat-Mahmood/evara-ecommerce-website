<?php
// search.php

// Get search query
$query = $_GET['query'] ?? $_GET['q'] ?? '';
$query = strtolower(trim($query));

// If empty, stop here
if ($query === '') {
    goto page;
}

// keyword → file mapping (ALL LOWERCASE)
$pages = [
    'marker'        => 'Markers and Highlighters.php',
    'markers'       => 'Markers and Highlighters.php',
    'highlighter'   => 'Markers and Highlighters.php',
    'highlighters'  => 'Markers and Highlighters.php',

    'pen'           => 'Pen and Pencils.php',
    'pens'          => 'Pen and Pencils.php',
    'pencil'        => 'Pen and Pencils.php',
    'pencils'       => 'Pen and Pencils.php',

    'paint'         => 'Paints and Colors.php',
    'paints'        => 'Paints and Colors.php',
    'colors'        => 'Paints and Colors.php',

    'notebook'      => 'Notebooks and Diaries.php',
    'notebooks'     => 'Notebooks and Diaries.php',
    'diary'         => 'Notebooks and Diaries.php',
    'diaries'       => 'Notebooks and Diaries.php',

    'bag'           => 'tote-bags.php',
    'bags'          => 'tote-bags.php',
    'shoulder bag'  => 'shoulder-bags.php',
    'shoulder bags' => 'shoulder-bags.php',

    'tumbler'       => 'Tumbler.php',
    'tumblers'      => 'Tumbler.php',

    'water bottle'  => 'Water Bottle.php',
    'water bottles' => 'Water Bottle.php',

    'pouch'         => 'Pouches and Storage.php',
    'pouches'       => 'Pouches and Storage.php',

    'cutter'        => 'Cutters and Staplers.php',
    'cutters'       => 'Cutters and Staplers.php',
    'stapler'       => 'Cutters and Staplers.php',
    'staplers'      => 'Cutters and Staplers.php',
];

// SMART redirect (supports "blue pens", "cheap water bottles", etc.)
foreach ($pages as $keyword => $file) {
    if (str_contains($query, $keyword)) {
        header("Location: $file");
        exit;
    }
}

page:
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search - Evara</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="search-page">
    <h1>Search</h1>

    <?php if ($query === ''): ?>
        <p>Please enter a search keyword.</p>
    <?php else: ?>
        <p>No matching category found for <b><?= htmlspecialchars($query) ?></b>.</p>
    <?php endif; ?>

    <form method="GET" action="search.php" style="margin-top: 20px;">
        <input type="text" name="query" placeholder="Search again..."
               value="<?= htmlspecialchars($query) ?>">
        <button type="submit">Search</button>
    </form>
</div>

</body>
</html>
