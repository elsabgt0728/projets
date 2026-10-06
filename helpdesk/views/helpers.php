<?php
function badge_statut($statut)
{
    $labels = ['ouvert' => 'Ouvert', 'en_cours' => 'En cours', 'resolu' => 'Résolu'];
    $classes = ['ouvert' => 'badge-ouvert', 'en_cours' => 'badge-encours', 'resolu' => 'badge-resolu'];

    $classe = $classes[$statut] ?? 'badge-ouvert';
    $label  = $labels[$statut] ?? htmlspecialchars($statut);

    return "<span class=\"badge {$classe}\">{$label}</span>";
}

function badge_priorite($priorite)
{
    $labels = ['basse' => 'Basse', 'moyenne' => 'Moyenne', 'haute' => 'Haute'];
    $classes = ['basse' => 'badge-basse', 'moyenne' => 'badge-moyenne', 'haute' => 'badge-haute'];

    $classe = $classes[$priorite] ?? 'badge-moyenne';
    $label  = $labels[$priorite] ?? htmlspecialchars($priorite);

    return "<span class=\"badge {$classe}\">{$label}</span>";
}

function badge_action($action)
{
    $labels = [
        'creation'        => 'Ticket créé',
        'prise_en_charge' => 'Pris en charge',
        'cloture'         => 'Clôturé',
    ];

    // Réutilise les couleurs déjà définies pour les statuts : logique, une création
    // "ouvre" le ticket (bleu), une prise en charge le met "en cours" (orange),
    // une clôture le "résout" (vert).
    $classes = [
        'creation'        => 'badge-ouvert',
        'prise_en_charge' => 'badge-encours',
        'cloture'         => 'badge-resolu',
    ];

    $classe = $classes[$action] ?? 'badge-ouvert';
    $label  = $labels[$action] ?? htmlspecialchars($action);

    return "<span class=\"badge {$classe}\">{$label}</span>";
}