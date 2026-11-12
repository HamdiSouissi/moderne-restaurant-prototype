# CORTILE — Ristorante, Parma

Site vitrine **one-page** pour un restaurant italien contemporain, pensé comme une
démonstration commerciale haut de gamme : identité lumineuse, typographie éditoriale,
animations discrètes et parcours complets (réservation, commande, newsletter).

> **Stack** — PHP 8 natif · HTML5 · CSS3 · JavaScript Vanilla (ES modules)
> **Librairies** — GSAP + ScrollTrigger · Lenis · SwiperJS · Google Fonts
> **Aucune** base de données, administration, authentification, ni framework (React/Vue/Laravel…).

---

## 1. Lancer le site

PHP 8.1+ suffit. Aucune dépendance à installer, aucun build.

```bash
# à la racine du projet
php -S localhost:8000
```

Puis ouvrir <http://localhost:8000>.

Sur un hébergement mutualisé classique (Apache, OVH, PlanetHoster…), il suffit de
déposer les fichiers à la racine du domaine : `index.php` est détecté automatiquement.

> Le site charge GSAP, Lenis, Swiper et les polices depuis des CDN publics.
> Sans connexion, le contenu reste parfaitement lisible et navigable (dégradation
> progressive prévue dans `assets/js/app.js`).

---

## 2. Structure du projet

```
cortile/
├── index.php                  # Assemble la page (une seule page, sections incluses)
├── config/
│   └── site.php               # ★ TOUT le contenu éditorial (identité, menu, horaires, FAQ…)
├── includes/
│   ├── functions.php          # Helpers : e(), asset(), img(), icon(), stars(), price()
│   ├── icons.php              # Jeu d'icônes SVG inline (aucune icon-font)
│   ├── head.php               # Meta, Open Graph, polices, CSS, JSON-LD Restaurant
│   ├── header.php             # Header + navigation mobile
│   ├── footer.php             # Footer + newsletter
│   ├── ui.php                 # Loader, curseur, tiroir panier, lightbox, modales, toast
│   └── sections/              # 1 fichier = 1 section (ordre libre)
│       ├── hero.php           experience/story.php   menu.php
│       ├── chef.php           signature.php          gallery.php
│       ├── reservation.php    order.php              testimonials.php
│       └── faq.php            contact.php
├── assets/
│   ├── css/
│   │   ├── base.css           # Tokens, reset, typographie, utilitaires
│   │   ├── components.css     # Header, boutons, loader, curseur, formulaires, panier…
│   │   ├── sections.css       # Mise en page de chaque section
│   │   └── responsive.css     # Laptop → tablette → mobile → ultra-wide + print
│   ├── js/
│   │   ├── app.js             # Point d'entrée (modules natifs)
│   │   └── modules/           # smooth, loader, header, cursor, animations, menu,
│   │                          # gallery, accordion, reservation, cart, testimonials, newsletter
│   └── img/
│       ├── src/               # Photos originales (sources)
│       ├── manifest.json      # Variantes réellement disponibles par image
│       └── *.jpg              # Variantes générées : 480 / 768 / 1024 / 1440 / 1800 px
└── tools/
    └── build-images.sh        # Pipeline ImageMagick (recadrage, étalonnage, srcset)
```

---

## 3. Personnaliser pour un vrai restaurant

**Tout se passe dans `config/site.php`.** Aucun contenu n'est écrit en dur dans les
templates : nom, adresse, téléphone, horaires, plats, prix, badges, avis, FAQ,
réseaux sociaux, textes du footer.

Exemples :

- changer un plat → tableau `menu.categories.<catégorie>.items`
- changer les horaires → `hours` (et `hours_short` pour le hero)
- changer les photos → remplacer les fichiers dans `assets/img/src/` puis relancer le pipeline
- retirer une section → commenter la ligne correspondante dans `index.php`

Les prix, avis, horaires et l'ensemble des données sont **fictifs** et conçus pour la démonstration.

### Images

```bash
bash tools/build-images.sh
```

Le script recadre, rechauffe légèrement l'étalonnage, génère les variantes responsives
et met à jour `assets/img/manifest.json`. Aucune image n'est agrandie au-delà de sa
résolution native. Le helper `img()` s'appuie sur ce manifeste pour produire
`src`, `srcset`, `sizes`, `width/height` (anti-CLS) et le lazy-loading.

---

## 4. Fonctionnalités

### Navigation & expérience
- Loader premium avec compteur et levée de rideau
- Scroll fluide (Lenis) synchronisé avec GSAP
- Curseur personnalisé avec libellés contextuels
- Header transparent → verre dépoli au scroll, masquage intelligent
- Navigation mobile plein écran, barre de progression de lecture
- Lien actif détecté par `IntersectionObserver` + `aria-current`

### Sections
- **Hero** plein écran, parallaxe souris + scroll, titre révélé ligne par ligne
- **Histoire / expérience** asymétrique, compteurs animés, citation
- **Menu** filtrable par catégorie (7 catégories, 12 plats, badges Chef's choice / Signature)
- **Chef** portrait en arche, citation, signature tracée
- **Signature** plat emblématique plein cadre, plaque flottante
- **Galerie** magazine (3 colonnes masonry) + lightbox zoomée (clavier, swipe, compteur)
- **Réservation** validation complète, fermeture le lundi, popup de confirmation
- **Commande** livraison / à emporter, panier persistant (localStorage), tiroir latéral,
  quantités, suppression, sous-total, frais de livraison offerts dès 45 €, checkout simulé
- **Avis** carrousel Swiper, médaillons monogrammes, notation
- **FAQ** accordéon accessible (aria-expanded)
- **Contact** carte SVG dessinée à la main, horaires, Call / Get directions
- **Footer** newsletter simulée, navigation, réseaux, retour en haut

### Micro-interactions
Boutons magnétiques, survols lumineux, inclinaison 3D des cartes, images qui se
dézooment lentement, révélations au scroll, parallaxe, grain papier, pulsation du pin.

---

## 5. Accessibilité & performances

- Structure sémantique : `header`, `main`, `section`, `footer`, titres hiérarchisés, un seul `h1`
- `skip-link`, focus visible, `aria-expanded`, `aria-modal`, `aria-current`, piège de focus
  dans les modales et le tiroir, fermeture par `Échap`
- `prefers-reduced-motion` : toutes les animations sont neutralisées, contenu visible
- Images `alt` renseignées, dimensions intrinsèques, `loading="lazy"` hors hero
- Hero préchargé (`preload` + `fetchpriority="high"`)
- Animations GPU (`transform` / `opacity` uniquement), `will-change` ciblé
- Si un CDN est indisponible, la page reste lisible (classe `no-gsap`)

---

## 6. Notes

- Toutes les fonctionnalités (réservation, commande, newsletter) sont **simulées côté
  front-end** : aucune requête serveur, aucune donnée envoyée, aucun stockage distant.
- Le formulaire de réservation valide les champs, refuse les dates passées et les lundis
  (jour de fermeture), puis affiche un récapitulatif.
- Le panier est conservé dans `localStorage` sous la clé `cortile.order.v1`.
- Restaurant, chef, adresse, avis et prix sont **fictifs** — le site est un prototype
  commercial prêt à être adapté à un véritable établissement.

---

## 7. Crédits

Design & développement — prototype sur mesure.
Photographies — visuels de démonstration.
Polices — Cormorant Garamond & Manrope (Google Fonts, SIL Open Font License).
