<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        margin: 0;
        min-height: 100vh;
        padding: 56px 20px;
        background: var(--clay);
        background-image:
            radial-gradient(circle at 15% 20%, rgba(180, 82, 47, 0.05), transparent 40%),
            radial-gradient(circle at 85% 80%, rgba(95, 125, 99, 0.06), transparent 40%);
        font-family: 'Inter', sans-serif;
        color: var(--ink);
    }

    table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        max-width: 920px;
        background: #FFFDF9;
        border-radius: 4px;
        overflow: hidden;
        box-shadow:
            0 1px 2px rgba(43, 36, 30, 0.06),
            0 12px 28px rgba(43, 36, 30, 0.10);
        border: 1px solid var(--clay-dark);
    }

    thead th {
        background: linear-gradient(135deg, var(--terracotta), var(--terracotta-dark));
        color: #FBF3E9;
        text-align: left;
        padding: 18px 20px;
        font-family: 'Fraunces', serif;
        font-weight: 500;
        font-size: 1rem;
        letter-spacing: 0.01em;
    }

    thead th:first-child { border-top-left-radius: 4px; }
    thead th:last-child { border-top-right-radius: 4px; }

    tbody td {
        padding: 16px 20px;
        border-bottom: 1px solid var(--clay-dark);
        font-size: 0.92rem;
        color: var(--ink);
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

    tbody tr:hover {
        background-color: #FAF4EC;
    }

    tbody tr:hover::before {
        background-color: var(--slip);
    }

    /* Badges de statut, façon tampon d'émail */
    .statut {
        display: inline-block;
        padding: 5px 14px;
        border-radius: 100px;
        font-family: 'Inter', sans-serif;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.04em;
    }

    .statut-elite {
        background: #F4E9CE;
        color: #8A6A16;
        border: 1px solid #D9B65C;
    }

    .statut-mention {
        background: #EAF0E6;
        color: var(--celadon);
        border: 1px solid #A7C0AB;
    }

    .statut-admis {
        background: #F1EAE2;
        color: var(--ink-soft);
        border: 1px solid #D8CBBB;
    }

    .statut-recale {
        background: #F5E5E1;
        color: var(--oxide);
        border: 1px solid #D9A9A0;
    }

    .statut-non-evalue {
        background: transparent;
        color: var(--ink-soft);
        border: 1px dashed #C9BBA9;
    }

    .btn {
        display: inline-block;
        color: #FBF3E9;
        text-decoration: none;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        padding: 8px 18px;
        border-radius: 100px;
        background: var(--ink);
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .btn:hover {
        background: var(--terracotta-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(180, 82, 47, 0.25);
    }

    @media (max-width: 640px) {
        table { font-size: 0.8rem; }
        thead th, tbody td { padding: 12px 10px; }
    }
</style>

</head>

<body>
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Promo</th>
            <th>Moyenne</th>
            <th>Rang</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php
        require_once '../models/grade_models.php';
        require_once '../config/db_connect.php';
        $grades = grade_cadet_cours();
        foreach ($grades as $grade) { ?>
            <tr>
            <td><?php echo htmlspecialchars($grade['nom']); ?></td>
            <td><?php echo htmlspecialchars($grade['promo']); ?></td>
            <td> <?= $grade['average_grade'] === null  ? 'N/A'  : htmlspecialchars(number_format($grade['average_grade'], 2)) ?></td>
            <td> <?php if ($grade['average_grade'] === null) {
                echo '<span class="statut statut-non-evalue">NON ÉVALUÉ</span>';
            } elseif ($grade['average_grade'] < 10) {
                echo '<span class="statut statut-recale">RECALÉ</span>';
            } elseif ($grade['average_grade'] < 14) {
                echo '<span class="statut statut-admis">ADMIS</span>';
            } elseif ($grade['average_grade'] < 17) {
                echo '<span class="statut statut-mention">MENTION</span>';
            } else {
                echo '<span class="statut statut-elite">ÉLITE</span>';
            }
            ?></td>
            <td> 
                <a href="../views/cadet_view.php?id=<?php echo $grade['cadet_id'] ?>" class="btn">Voir plus</a> 
            </td>
            </tr>
             <?php } ?>  
    </tbody>
</table>
</body>
</html>