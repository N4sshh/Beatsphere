<?php
// About Us page content (Hardcoded for now)
$teamMembers = [
    ["name" => "Yully", "description" => "A bright soul full of passion.", "image" => "https://n4sshh.github.io/Nash/Final%20Project%20Images/yully.jpg"],
    ["name" => "Amiel", "description" => "A thinker and a dreamer.", "image" => "https://n4sshh.github.io/Nash/Final%20Project%20Images/amiel.jpg"],
    ["name" => "Zam", "description" => "The one who shines in every way.", "image" => "https://n4sshh.github.io/Nash/Final%20Project%20Images/zam.jpg"],
    ["name" => "Nash", "description" => "Strength and determination in one.", "image" => "https://n4sshh.github.io/Nash/Final%20Project%20Images/Nash.jpg"]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="CSS/AboutUs.css">
</head>
<body>

    <div class="main-container">

        <main class="content">
            <header>
                <h1>About Us</h1>
            </header>

            <!-- Display all team members in a grid -->
            <div class="team-grid">
                <?php foreach ($teamMembers as $index => $member): ?>
                    <div class="team-member-item">
                        <p><?php echo htmlspecialchars($member['name']); ?> - <?php echo htmlspecialchars($member['description']); ?></p>
                        <img src="<?php echo htmlspecialchars($member['image']); ?>" alt="<?php echo htmlspecialchars($member['name']); ?>">
                    </div>
                <?php endforeach; ?>
            </div>

            <footer>
                
            </footer>
        </main>
    </div>

</body>
</html>
