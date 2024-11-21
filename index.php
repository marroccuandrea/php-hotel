<?php

$hotels = [
    [
        'name' => 'Hotel Belvedere',
        'description' => 'Hotel Belvedere Descrizione',
        'parking' => true,
        'vote' => 4,
        'distance_to_center' => 10.4
    ],
    [
        'name' => 'Hotel Futuro',
        'description' => 'Hotel Futuro Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 2
    ],
    [
        'name' => 'Hotel Rivamare',
        'description' => 'Hotel Rivamare Descrizione',
        'parking' => false,
        'vote' => 1,
        'distance_to_center' => 1
    ],
    [
        'name' => 'Hotel Bellavista',
        'description' => 'Hotel Bellavista Descrizione',
        'parking' => false,
        'vote' => 5,
        'distance_to_center' => 5.5
    ],
    [
        'name' => 'Hotel Milano',
        'description' => 'Hotel Milano Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 50
    ],
];

// Filtra gli hotel in base ai parametri
if (isset($_GET['has_parking']) || isset($_GET['min_vote'])) {
    $min_vote = isset($_GET['min_vote']) && is_numeric($_GET['min_vote']) ? (int)$_GET['min_vote'] : 0;
    $has_parking = isset($_GET['has_parking']) && $_GET['has_parking'] === '1';

    $hotels = array_filter($hotels, function ($hotel) use ($has_parking, $min_vote) {
        $parking_condition = !$has_parking || $hotel['parking'] === true;
        $vote_condition = $hotel['vote'] >= $min_vote;
        return $parking_condition && $vote_condition;
    });
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        form {
            margin-bottom: 20px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            margin-top: 0;
        }

        .card p {
            margin: 10px 0;
        }

        .card .parking {
            font-weight: bold;
            color: <?php echo isset($_GET['has_parking']) ? '#4caf50' : '#f44336'; ?>;
        }
    </style>
</head>

<body>
    <!-- Form per il filtro -->
    <form method="GET" action="">
        <label>
            <input type="checkbox" name="has_parking" value="1" <?php echo isset($_GET['has_parking']) ? 'checked' : ''; ?>>
            Mostra solo hotel con parcheggio
        </label>
        <label>
            Min. voto:
            <input type="number" name="min_vote" min="1" max="5" value="<?php echo isset($_GET['min_vote']) ? htmlspecialchars($_GET['min_vote']) : ''; ?>">
        </label>
        <button type="submit">Filtra</button>
    </form>

    <!-- Elenco degli hotel -->
    <h1>Elenco Hotel</h1>
    <div class="cards">
        <?php foreach ($hotels as $hotel): ?>
            <div class="card">
                <h2><?php echo $hotel['name']; ?></h2>
                <p><?php echo $hotel['description']; ?></p>
                <p>Voto: <?php echo $hotel['vote']; ?></p>
                <p>Distanza dal centro: <?php echo $hotel['distance_to_center']; ?> km</p>
                <p class="parking">Parcheggio: <?php echo $hotel['parking'] ? 'Sì' : 'No'; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>