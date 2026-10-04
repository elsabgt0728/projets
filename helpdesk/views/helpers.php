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