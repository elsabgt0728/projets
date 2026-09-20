<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Bibliothèque</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root{
            --cream: #f6efe3;
            --cream-2: #fffdf8;
            --wood: #6b4226;
            --wood-dark: #4a2c1a;
            --maroon: #7c2a2a;
            --maroon-dark: #5e1f1f;
            --ink: #2b241b;
            --ink-soft: #7a6f5f;
            --gold: #c9a227;
            --gold-light: #e6c565;
        }
        * { box-sizing: border-box; }

        body{
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--ink);
            background: radial-gradient(circle at 50% 0%, #fbf6ec, var(--cream) 70%);
        }

        .auth{
            width: 100%;
            max-width: 920px;
            min-height: 560px;
            display: flex;
            background: var(--cream-2);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 30px 70px rgba(74,44,26,0.25), 0 4px 12px rgba(74,44,26,0.12);
        }

        /* ---------- Panneau gauche : identité ---------- */
        .auth-brand{
            position: relative;
            flex: 1.05 1 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 56px 44px;
            color: var(--cream);
            background:
                linear-gradient(160deg, rgba(74,44,26,0.94), rgba(94,31,31,0.94)),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='240' viewBox='0 0 400 240'%3E%3Crect width='400' height='240' fill='%233a2415'/%3E%3Cg%3E%3Crect x='0' y='40' width='400' height='10' fill='%232b1a0f'/%3E%3Crect x='0' y='130' width='400' height='10' fill='%232b1a0f'/%3E%3Crect x='0' y='220' width='400' height='10' fill='%232b1a0f'/%3E%3C/g%3E%3Cg opacity='0.85'%3E%3Crect x='10' y='10' width='16' height='30' fill='%23c9a227'/%3E%3Crect x='28' y='6' width='14' height='34' fill='%237c2a2a'/%3E%3Crect x='44' y='14' width='18' height='26' fill='%236b4226'/%3E%3Crect x='64' y='8' width='12' height='32' fill='%23c9a227'/%3E%3Crect x='78' y='12' width='20' height='28' fill='%237c2a2a'/%3E%3Crect x='100' y='4' width='14' height='36' fill='%236b4226'/%3E%3Crect x='116' y='10' width='16' height='30' fill='%23c9a227'/%3E%3Crect x='134' y='6' width='18' height='34' fill='%237c2a2a'/%3E%3Crect x='154' y='14' width='12' height='26' fill='%236b4226'/%3E%3Crect x='168' y='8' width='16' height='32' fill='%23c9a227'/%3E%3Crect x='186' y='12' width='20' height='28' fill='%237c2a2a'/%3E%3Crect x='208' y='6' width='14' height='34' fill='%236b4226'/%3E%3Crect x='224' y='10' width='16' height='30' fill='%23c9a227'/%3E%3Crect x='242' y='4' width='18' height='36' fill='%237c2a2a'/%3E%3Crect x='262' y='12' width='12' height='28' fill='%236b4226'/%3E%3Crect x='276' y='8' width='20' height='32' fill='%23c9a227'/%3E%3Crect x='298' y='14' width='14' height='26' fill='%237c2a2a'/%3E%3Crect x='314' y='6' width='16' height='34' fill='%236b4226'/%3E%3Crect x='332' y='10' width='18' height='30' fill='%23c9a227'/%3E%3Crect x='352' y='4' width='12' height='36' fill='%237c2a2a'/%3E%3Crect x='366' y='12' width='20' height='28' fill='%236b4226'/%3E%3Crect x='388' y='8' width='10' height='32' fill='%23c9a227'/%3E%3C/g%3E%3C/svg%3E");
            background-size: cover, 400px 240px;
        }

        .auth-brand::before{
            content:"";
            position: absolute;
            inset: 18px;
            border: 1px solid rgba(230,197,101,0.35);
            border-radius: 10px;
            pointer-events: none;
        }

        .brand-icon{
            font-size: 2.6rem;
            margin-bottom: 18px;
            filter: drop-shadow(0 4px 10px rgba(0,0,0,0.35));
        }

        .auth-brand h1{
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 800;
            margin: 0 0 14px;
            letter-spacing: 0.3px;
        }

        .brand-divider{
            width: 46px;
            height: 2px;
            background: var(--gold-light);
            margin: 0 0 18px;
            position: relative;
        }
        .brand-divider::after{
            content:"◆";
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%,-50%);
            font-size: 8px;
            color: var(--gold-light);
            background: var(--wood-dark);
            padding: 0 4px;
        }

        .auth-brand p{
            font-size: 0.95rem;
            line-height: 1.6;
            color: rgba(246,239,227,0.82);
            max-width: 280px;
        }

        /* ---------- Panneau droit : formulaire ---------- */
        .auth-form{
            flex: 1 1 0;
            padding: 56px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-form h2{
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--wood-dark);
            margin: 0 0 6px;
        }

        .auth-form .subtitle{
            font-size: 0.88rem;
            color: var(--ink-soft);
            margin: 0 0 32px;
        }

        .field{
            margin-bottom: 20px;
        }

        .field label{
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            color: var(--wood-dark);
            margin-bottom: 7px;
        }

        .input-wrap{
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrap .icon{
            position: absolute;
            left: 14px;
            font-size: 0.95rem;
            opacity: 0.55;
            pointer-events: none;
        }

        .input-wrap input{
            width: 100%;
            font-family: inherit;
            font-size: 0.98rem;
            padding: 13px 14px 13px 40px;
            border: 1.5px solid #e2d5b8;
            border-radius: 9px;
            background: #fffef9;
            color: var(--ink);
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .input-wrap input::placeholder{ color: #b9ac8f; }

        .input-wrap input:focus{
            outline: none;
            border-color: var(--gold);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(201,162,39,0.18);
        }

        .field-row{
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: -6px 0 26px;
            font-size: 0.82rem;
        }

        .remember{
            display: flex;
            align-items: center;
            gap: 7px;
            color: var(--ink-soft);
        }
        .remember input{ accent-color: var(--maroon); width: 14px; height: 14px; }

        .forgot{
            color: var(--wood);
            text-decoration: none;
        }
        .forgot:hover{ color: var(--maroon); text-decoration: underline; }

        .error-msg{
            background: #fbe9e7;
            border: 1px solid rgba(124,42,42,0.3);
            color: var(--maroon-dark);
            font-size: 0.85rem;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        button{
            cursor: pointer;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 0.01em;
            color: var(--cream);
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            border: none;
            border-radius: 9px;
            padding: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: transform 0.15s, box-shadow 0.15s, background 0.2s;
        }

        button:hover{
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(124,42,42,0.32);
            background: linear-gradient(135deg, #8f3232, var(--maroon-dark));
        }

        .back-link{
            display: block;
            text-align: center;
            margin-top: 26px;
            font-size: 0.85rem;
            color: var(--ink-soft);
            text-decoration: none;
        }
        .back-link:hover{ color: var(--maroon); text-decoration: underline; }

        @media (max-width: 760px){
            .auth{ flex-direction: column; }
            .auth-brand{ padding: 40px 32px; }
            .auth-brand p{ display: none; }
            .auth-form{ padding: 40px 32px; }
        }
    </style>
</head>
<body>

    <div class="auth">

        <div class="auth-brand">
            <div class="brand-icon">📖</div>
            <h1>Bibliothèque</h1>
            <div class="brand-divider"></div>
            <p>Gérez le catalogue, les emprunts et les retours en toute simplicité.</p>
        </div>

        <div class="auth-form">
            <h2>Connexion</h2>
            <p class="subtitle">Entrez vos identifiants pour accéder à l'espace de gestion.</p>

            <!-- erreur de connexion -->
             <p class="error-msg">Identifiant ou mot de passe incorrect.</p> 

            <form action="../controller/connexion_controller.php" method="POST">
                <div class="field">
                    <label for="identifiant">Identifiant</label>
                    <div class="input-wrap">
                        <span class="icon">👤</span>
                        <input type="text" id="email" name="email" placeholder="votre identifiant" required autofocus>
                    </div>
                </div>

                <div class="field">
                    <label for="password">Mot de passe</label>
                    <div class="input-wrap">
                        <span class="icon">🔒</span>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="field-row">
                    <label class="remember">
                        <input type="checkbox" name="remember">
                        Se souvenir de moi
                    </label>
                    <a class="forgot" href="#">Mot de passe oublié ?</a>
                </div>

                <button type="submit">Se connecter →</button>
            </form>

            <a class="back-link" href="menu.php">← Retour au catalogue</a>
        </div>

    </div>

</body>
</html>