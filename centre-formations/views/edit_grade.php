<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la note</title>
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
            max-width: 340px;
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

        input[type="number"] {
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

        input[type="number"]:focus {
            outline: none;
            border-color: var(--terracotta);
            box-shadow: 0 0 0 3px rgba(180, 82, 47, 0.15);
            background-color: #ffffff;
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
    <?php
    require_once '../models/grade_models.php';
    $cours_id = $_GET['id'];
    $cadet_id = $_GET['cadet_id'];
    $grade = get_grade($cadet_id, $cours_id);
    ?>
    <form action="../controller/edit_controller.php" method="POST">
        <input type="hidden" name="cours_id" value="<?php echo htmlspecialchars($cours_id); ?>">
        <input type="hidden" name="cadet_id" value="<?php echo htmlspecialchars($cadet_id); ?>">
        <label for="grade">Note</label>
        <input type="number" id="grade" name="grade" step="0.5" min="0" max="20" value="<?php echo htmlspecialchars($grade); ?>" required>
        <button type="submit">Mettre à jour la note</button>
    </form>
</body>
</html>