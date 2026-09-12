<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche cadet</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Inter:wght@400;500;600&display=swap');

        :root {
            --clay: #F2EAE0;
            --clay-dark: #E6D9C8;
            --ink: #2B241E;
            --ink-soft: #6B5F53;
            --terracotta: #B4522F;
            --terracotta-dark: #8F3F22;
            --celadon: #5F7D63;
            --oxide: #9C3B3B;
            --slip: #C6952E;
        }

        * { box-sizing: border-box; }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 24px;
            min-height: 100vh;
            margin: 0;
            padding: 56px 20px;
            background: var(--clay);
            font-family: 'Inter', sans-serif;
            color: var(--ink);
        }

        .cadet-card {
            width: 100%;
            max-width: 620px;
            background: linear-gradient(135deg, var(--terracotta), var(--terracotta-dark));
            color: #FBF3E9;
            border-radius: 6px;
            padding: 28px 32px;
            box-shadow: 0 12px 28px rgba(43, 36, 30, 0.15);
        }

        .cadet-card h2 {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 1.5rem;
            margin: 0 0 12px 0;
        }

        .cadet-card p {
            margin: 4px 0;
            font-size: 0.92rem;
            opacity: 0.95;
        }

        .statut {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 14px;
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            max-width: 620px;
            background: #FFFDF9;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(43,36,30,0.06), 0 12px 28px rgba(43,36,30,0.10);
            border: 1px solid var(--clay-dark);
        }

        thead th {
            background: var(--ink);
            color: #FBF3E9;
            text-align: left;
            padding: 14px 18px;
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 0.9rem;
        }

        tbody td {
            padding: 14px 18px;
            border-bottom: 1px solid var(--clay-dark);
            font-size: 0.9rem;
        }

        tbody tr:last-child td { border-bottom: none; }

        tbody tr {
            position: relative;
            transition: background-color 0.2s ease;
        }

        tbody tr::before {
            content: "";
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: transparent;
            transition: background-color 0.2s ease;
        }

        tbody tr:hover { background-color: #FAF4EC; }
        tbody tr:hover::before { background-color: var(--slip); }

        .btn {
            display: inline-block;
            color: #FBF3E9;
            text-decoration: none;
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            padding: 7px 14px;
            border-radius: 100px;
            background: var(--ink);
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn:hover {
            background: var(--terracotta-dark);
            transform: translateY(-1px);
        }

        .btn-delete {
            background: var(--oxide);
        }

        .btn-delete:hover {
            background: #7A2C2C;
        }

        .btn-add {
            background: var(--celadon);
            margin-top: 4px;
        }

        .btn-add:hover {
            background: #4A6650;
        }
    </style>
</head>
<body>
    <?php
    require_once '../config/db_connect.php';
    require_once '../models/cadet_models.php';
    require_once '../models/cours_models.php';
    require_once '../models/grade_models.php';

    $cadet_id = $_GET["id"];
    $cadet = cadet_info($cadet_id);
    $result = each_cadet_result($cadet_id);
    ?>

    <div class="cadet-card">
        <h2>Fiche cadet</h2>
        <p>Nom : <?php echo htmlspecialchars($cadet['nom']); ?></p>
        <p>Promo : <?php echo htmlspecialchars($cadet['promo']); ?></p>
        <p>Moyenne générale : <?php echo $result['average_grade'] === null ? 'N/A' : htmlspecialchars(number_format($result['average_grade'], 2)); ?></p>
        <span class="statut">
            <?php
            if ($result['average_grade'] === null) { echo 'NON ÉVALUÉ'; }
            elseif ($result['average_grade'] < 10) { echo 'RECALÉ'; }
            elseif ($result['average_grade'] < 14) { echo 'ADMIS'; }
            elseif ($result['average_grade'] < 17) { echo 'MENTION'; }
            else { echo 'ÉLITE'; }
            ?>
        </span>
    </div>

    <table>
        <thead>
            <tr>
                <th>Cours</th>
                <th>Note</th>
                <th>Coefficient</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cadet_courses = each_cadet_cours($cadet_id);
            foreach ($cadet_courses as $course) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($course['nom_cours']) . "</td>";
                echo "<td>" . htmlspecialchars($course['grade']) . "</td>";
                echo "<td>" . htmlspecialchars($course['coefficient']) . "</td>";
                echo "<td>
                    <a href='edit_grade.php?id=" . urlencode($course['cours_id']) . "&cadet_id=" . urlencode($cadet_id) . "' class='btn'>Modifier</a>
                    <a href='../controller/delete_grade_controller.php?id=" . urlencode($course['cours_id']) . "&cadet_id=" . urlencode($cadet_id) . "' class='btn btn-delete'>Supprimer</a>
                </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="Ajout_note.php?cadet_id=<?php echo urlencode($cadet_id); ?>" class="btn btn-add">Ajouter une note</a>
</body>
</html>