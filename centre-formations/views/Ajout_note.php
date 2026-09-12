<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une note</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Inter:wght@400;500;600&display=swap');

        :root {
            --clay: #F2EAE0;
            --clay-dark: #E6D9C8;
            --ink: #2B241E;
            --ink-soft: #6B5F53;
            --terracotta: #B4522F;
            --terracotta-dark: #8F3F22;
        }

        * { box-sizing: border-box; }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 40px 20px;
            background: var(--clay);
            font-family: 'Inter', sans-serif;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 16px;
            width: 100%;
            max-width: 360px;
            padding: 32px;
            background: #FFFDF9;
            border-radius: 6px;
            border: 1px solid var(--clay-dark);
            box-shadow: 0 12px 28px rgba(43, 36, 30, 0.10);
            color: var(--ink);
        }

        label {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            color: var(--ink-soft);
            margin-bottom: -8px;
        }

        input[type="number"], select {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid var(--clay-dark);
            border-radius: 6px;
            font-size: 0.95rem;
            color: var(--ink);
            background-color: #FAF4EC;
            font-family: inherit;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input[type="number"]:focus, select:focus {
            outline: none;
            border-color: var(--terracotta);
            box-shadow: 0 0 0 3px rgba(180, 82, 47, 0.15);
            background-color: #ffffff;
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236B5F53' stroke-width='2'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            cursor: pointer;
        }

        button[type="submit"] {
            margin-top: 8px;
            padding: 11px 18px;
            border: none;
            border-radius: 100px;
            background: var(--terracotta);
            color: #FBF3E9;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        button[type="submit"]:hover {
            background: var(--terracotta-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(180, 82, 47, 0.25);
        }
    </style>
</head>
<body>
    <form action="../controller/ajout_controller.php" method="POST">
        <label for="grade">Note</label>
        <input type="number" id="grade" name="grade" step="0.5" min="0" max="20" required>

        <label for="nom_cours">Cours</label>
        <select name="cours_id" id="nom_cours" required>
            <option value="" disabled selected>Sélectionner un cours</option>
            <?php
            require_once '../config/db_connect.php';
            require_once '../models/cours_models.php';
            $courses = all_cours();
            foreach ($courses as $course) {
                echo "<option value='" . htmlspecialchars($course['cours_id']) . "'>" . htmlspecialchars($course['nom_cours']) . "</option>";
            }
            ?>
        </select>

        <input type="hidden" name="cadet_id" value="<?php echo htmlspecialchars($_GET['cadet_id']); ?>">
        <button type="submit">Ajouter la note</button>
    </form>
</body>
</html>