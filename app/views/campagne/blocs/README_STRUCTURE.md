# Structure des vues Formation - Documentation

## Blocs partagés créés

### 1. `blocs/titreFormation.php`
**Usage:** Titre standardisé pour les pages de formation
**Variables requises:**
- `$imgUrl` : Chemin vers l'image du logo
- `$titre` : Titre de la campagne 
- `$icon` : Icône HTML (FontAwesome)

**Exemple d'utilisation:**
```php
$imgUrl = '/public/img/logo_Cabinet_Bruno.png';
$titre = 'Campagne formation B2B CABINET BRUNO -';
$icon = '<i class="fas fa-fw fa-scroll" style="color: #eb7f15;"></i>';
include_once dirname(__FILE__) . '/blocs/titreFormation.php';
```

### 2. `blocs/stylesFormation.php`
**Usage:** Styles CSS communs pour les formations
**Contient:**
- Styles pour les étapes (.step, .step.active)
- Animations (fadeIn)
- Styles des boutons (.btn-prev, .btn-next, .btn-finish)
- Styles des tooltips

### 3. `blocs/sidebarFormation.php` (B2B)
**Usage:** Sidebar complète pour formation B2B
**Contient:**
- Boutons d'action (Détails, Liste des Notes, Envoi Doc)
- Textarea pour les notes
- Modal pour liste des notes
- Modal pour envoi documentation
- Fonctions JavaScript complètes

**Variables utilisées:**
- `$company` : Objet company pour les liens
- `$gerant` : Objet gerant pour l'email par défaut
- `$questScript` : Objet questScript pour les notes

### 4. `blocs/sidebarFormationB2C.php` (B2C)
**Usage:** Sidebar complète pour formation B2C (adaptation de B2B)
**Différences avec B2B:**
- Utilise `$contact` au lieu de `$gerant`
- Messages spécifiques B2C dans les fonctions
- Logs de débogage marqués "B2C"

**Variables utilisées:**
- `$company` : Objet company pour les liens
- `$contact` : Objet contact pour l'email par défaut
- `$questScript` : Objet questScript pour les notes

## Structure avant/après

### Avant
```
indexFormationCbB2B.php (3000+ lignes)
├── Styles CSS intégrés
├── Modals intégrés
├── Sidebar intégrée
├── Scripts JS séparés dans blocs/scriptsFormation/
└── Variables dispersées

indexFormationCbB2C.php (5800+ lignes)
├── Styles CSS intégrés
├── Modals intégrés
├── Sidebar intégrée
└── Scripts JS dans le fichier principal
```

### Après
```
indexFormationCbB2B.php (~2000 lignes)
├── Variables centralisées
├── Include titre partagé
├── Include styles partagés
├── Include sidebar B2B
└── Scripts modulaires

indexFormationCbB2C.php (~5600 lignes)  
├── Variables centralisées
├── Include titre partagé
├── Include styles partagés
├── Include sidebar B2C
└── Script de débogage simple

blocs/
├── titreFormation.php (titre partagé)
├── stylesFormation.php (styles partagés)
├── sidebarFormation.php (sidebar B2B + modals + JS)
└── sidebarFormationB2C.php (sidebar B2C + modals + JS)
```

## Avantages de cette structure

1. **Réduction de la duplication de code**
   - Titre : partagé entre B2B et B2C
   - Styles : réutilisés
   - Structure des modals : similaire

2. **Maintenabilité améliorée**
   - Modifications centralisées dans les blocs
   - Code plus lisible
   - Responsabilités séparées

3. **Débogage facilité**
   - Fonctions JavaScript dans le même fichier que les boutons
   - Messages de console spécifiques B2B/B2C
   - Gestion d'erreurs cohérente

4. **Flexibilité**
   - Variables configurables
   - Blocs réutilisables pour d'autres types de formation
   - Adaptation facile pour nouveaux contextes

## API Backend

Les fonctions JavaScript communiquent avec `/public/json/campagneSociete.php` via les actions :
- `loadNotes` : Charger la liste des notes
- `getNoteDetail` : Détail d'une note
- `saveNote` : Sauvegarder une note
- `envoiDocumentation` : Envoyer un email avec documentation

## Migration d'autres pages

Pour migrer d'autres pages de formation vers cette structure :

1. **Extraire les variables** au début du fichier
2. **Remplacer le titre** par l'include du bloc partagé
3. **Remplacer les styles** par l'include stylesFormation.php
4. **Adapter la sidebar** en créant une version spécifique si nécessaire
5. **Tester les fonctionnalités** (modals, AJAX, etc.)
