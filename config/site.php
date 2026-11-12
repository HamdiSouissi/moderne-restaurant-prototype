<?php
/**
 * -----------------------------------------------------------------------------
 *  CORTILE — Ristorante, Parma
 *  Central content file
 * -----------------------------------------------------------------------------
 *  Everything a real restaurant would need to change lives here: identity,
 *  contact details, opening hours, menu, testimonials, FAQ.
 *  No database: this file is the single source of truth.
 *
 *  @package Cortile
 * -----------------------------------------------------------------------------
 */

return [

    /* ---------------------------------------------------------------------
     * 1. IDENTITY
     * ------------------------------------------------------------------ */
    'brand' => [
        'name'        => 'Cortile',
        'descriptor'  => 'Ristorante · Parma',
        'tagline'     => 'Cucina italiana contemporanea',
        'since'       => 2019,
        'legal_name'  => 'Cortile S.r.l.',
        'vat'         => 'IT 0245 8812 043',
    ],

    'contact' => [
        'street'      => 'Via Farini 12',
        'city'        => 'Parma',
        'region'      => 'Emilia-Romagna',
        'postcode'    => '43121',
        'country'     => 'Italia',
        'phone'       => '+39 0521 24 18 90',
        'phone_href'  => '+390521241890',
        'email'       => 'ciao@cortileparma.it',
        'instagram'   => 'https://instagram.com',
        'facebook'    => 'https://facebook.com',
        'pinterest'   => 'https://pinterest.com',
        'handle'      => '@cortile.parma',
        'maps'        => 'https://maps.google.com/?q=Via+Farini+12,+Parma,+Italia',
    ],

    /* ---------------------------------------------------------------------
     * 2. NAVIGATION
     * ------------------------------------------------------------------ */
    'nav' => [
        ['label' => 'Home',        'href' => '#home',        'id' => 'home'],
        ['label' => 'Menu',        'href' => '#menu',        'id' => 'menu'],
        ['label' => 'Our Story',   'href' => '#story',       'id' => 'story'],
        ['label' => 'Gallery',     'href' => '#gallery',     'id' => 'gallery'],
        ['label' => 'Reservation', 'href' => '#reservation', 'id' => 'reservation'],
        ['label' => 'Delivery',    'href' => '#order',       'id' => 'order'],
        ['label' => 'Contact',     'href' => '#contact',     'id' => 'contact'],
    ],

    /* ---------------------------------------------------------------------
     * 3. OPENING HOURS
     * ------------------------------------------------------------------ */
    'hours' => [
        ['days' => 'Monday',                'time' => 'Chiuso',        'closed' => true],
        ['days' => 'Tuesday — Thursday',    'time' => '12:30 — 14:30 · 19:30 — 23:00'],
        ['days' => 'Friday — Saturday',     'time' => '12:30 — 15:00 · 19:00 — 23:30'],
        ['days' => 'Sunday',                'time' => '12:30 — 15:30'],
    ],

    'hours_short' => 'Tue — Sun · 12:30 — 23:00',

    /* ---------------------------------------------------------------------
     * 4. EXPERIENCE / STORY
     * ------------------------------------------------------------------ */
    'story' => [
        'eyebrow'   => '01 — La nostra storia',
        'title'     => 'A courtyard, a table,<br>a <em>ritual</em>.',
        'lead'      => 'Cortile opened in 2019 behind an unmarked door in Via Farini, in the courtyard of a seventeenth-century palazzo.',
        'body'      => [
            'The room is the courtyard itself: travertine, pale oak, linen and the light that falls through the arches from noon until it turns gold. We kept everything that time had already made beautiful, and added very little.',
            'In the kitchen, Luca cooks the food of his grandmother — tortelli folded one by one, broths that take two days, vegetables from the market at dawn. In the dining room, Chiara pours wines from small Emilian growers she has known for years.',
        ],
        'quote'     => 'We cook the way Parma taught us: with patience.',
        'image_one' => [
            'src'     => 'terrace',
            'alt'     => 'The courtyard terrace at Cortile, with olive trees and linen-covered tables',
            'caption' => 'Il cortile, 19:30',
        ],
        'image_two' => [
            'src'     => 'pasta-making',
            'alt'     => 'Fresh tagliatelle being shaped by hand on a marble worktop',
            'caption' => 'Le mani, ogni mattina',
        ],
        'stats' => [
            ['value' => '2019',  'label' => 'Anno di apertura', 'suffix' => ''],
            ['value' => '42',    'label' => 'Posti nel cortile', 'suffix' => ''],
            ['value' => '18',    'label' => 'Produttori emiliani', 'suffix' => ''],
            ['value' => '100',   'label' => 'Pasta fatta a mano', 'suffix' => '%'],
        ],
    ],

    /* ---------------------------------------------------------------------
     * 5. MENU
     *  Each category: key, label (EN), italian label, items.
     *  An item whose `feature` key is true is rendered on a wide card.
     * ------------------------------------------------------------------ */
    'menu' => [
        'intro' => 'Our menu follows the market and the season. These are the dishes we cook most often — finished, always, with olive oil from the hills above Parma.',

        'categories' => [

            'starters' => [
                'label'   => 'Starters',
                'italian' => 'Antipasti',
                'items'   => [
                    [
                        'name'  => 'Burrata di Andria',
                        'desc'  => 'Heirloom tomatoes, basil oil, warm grissini.',
                        'price' => '18',
                        'image' => 'dish-burrata',
                        'order_id' => 'burrata',
                        'alt'   => 'Burrata with heirloom tomatoes and basil oil',
                        'badge' => "Chef's choice",
                        'tags'  => ['Vegetarian'],
                    ],
                    [
                        'name'  => 'Carpaccio di Manzo',
                        'desc'  => 'Rocket, Parmigiano Reggiano 36 months, capers, lemon.',
                        'price' => '22',
                        'image' => 'dish-carpaccio',
                        'alt'   => 'Beef carpaccio with rocket and aged Parmigiano',
                        'badge' => '',
                        'tags'  => [],
                    ],
                ],
            ],

            'pasta' => [
                'label'   => 'Fresh Pasta',
                'italian' => 'Pasta Fresca',
                'items'   => [
                    [
                        'name'  => "Tortelli d’Erbette",
                        'desc'  => 'Brown butter, sage from the courtyard, Parmigiano 36 months.',
                        'price' => '24',
                        'image' => 'signature',
                        'order_id' => 'tortelli',
                        'alt'   => "Tortelli d’Erbette with sage butter and Parmigiano",
                        'badge' => 'Signature',
                        'tags'  => ['Vegetarian'],
                        'feature' => true,
                    ],
                    [
                        'name'  => 'Tagliolini al Tartufo',
                        'desc'  => 'Black truffle shaved at the table, butter emulsion.',
                        'price' => '32',
                        'image' => 'dish-tagliolini',
                        'order_id' => 'tagliolini',
                        'alt'   => 'Tagliolini pasta with shaved black truffle',
                        'badge' => "Chef's choice",
                        'tags'  => ['Vegetarian'],
                    ],
                ],
            ],

            'pizza' => [
                'label'   => 'Pizza',
                'italian' => 'Forno a Legna',
                'items'   => [
                    [
                        'name'  => 'Margherita Sbagliata',
                        'desc'  => 'San Marzano, fior di latte, basil, 68-hour dough.',
                        'price' => '16',
                        'image' => 'dish-pizza-margherita',
                        'order_id' => 'pizza',
                        'alt'   => 'Wood-fired margherita pizza with basil',
                        'badge' => '',
                        'tags'  => ['Vegetarian'],
                    ],
                    [
                        'name'  => 'Bianca con Prosciutto',
                        'desc'  => 'Stracciatella, Prosciutto di Parma 24 months, rocket.',
                        'price' => '21',
                        'image' => 'dish-pizza-bianca',
                        'alt'   => 'White pizza with Prosciutto di Parma and rocket',
                        'badge' => "Chef's choice",
                        'tags'  => [],
                    ],
                ],
            ],

            'mains' => [
                'label'   => 'Main Courses',
                'italian' => 'Secondi',
                'items'   => [
                    [
                        'name'  => 'Guancia di Manzo',
                        'desc'  => 'Braised in Barolo for six hours, polenta, gremolata.',
                        'price' => '29',
                        'image' => 'dish-guancia',
                        'order_id' => 'guancia',
                        'alt'   => 'Braised beef cheek on polenta with gremolata',
                        'badge' => '',
                        'tags'  => [],
                    ],
                    [
                        'name'  => "Branzino all’Acqua Pazza",
                        'desc'  => 'Sea bass, datterini tomatoes, Taggiasca olives, basil.',
                        'price' => '31',
                        'image' => 'dish-branzino',
                        'alt'   => 'Sea bass fillet with tomatoes and olives',
                        'badge' => '',
                        'tags'  => [],
                    ],
                ],
            ],

            'desserts' => [
                'label'   => 'Desserts',
                'italian' => 'Dolci',
                'items'   => [
                    [
                        'name'  => 'Tiramisù del Cortile',
                        'desc'  => 'Mascarpone, espresso from Modena, bitter cocoa.',
                        'price' => '12',
                        'image' => 'dish-tiramisu',
                        'order_id' => 'tiramisu',
                        'alt'   => 'Tiramisù with cocoa and espresso',
                        'badge' => "Chef's choice",
                        'tags'  => ['Vegetarian'],
                    ],
                    [
                        'name'  => 'Panna Cotta alla Vaniglia',
                        'desc'  => 'Bourbon vanilla, wild berries, lemon thyme.',
                        'price' => '11',
                        'image' => 'dish-pannacotta',
                        'alt'   => 'Vanilla panna cotta with wild berries',
                        'badge' => '',
                        'tags'  => ['Vegetarian'],
                    ],
                ],
            ],

            'wine' => [
                'label'   => 'Wine',
                'italian' => 'Cantina',
                'items'   => [
                    [
                        'name'  => 'Barolo Riserva 2018',
                        'desc'  => 'Nebbiolo, Piedmont. Glass 14 · Bottle 78. Decanted at the table.',
                        'price' => '14',
                        'image' => 'wine-barolo',
                        'alt'   => 'A glass of Barolo on a travertine surface',
                        'badge' => 'Sommelier',
                        'tags'  => [],
                        'feature' => true,
                    ],
                ],
            ],

            'cocktails' => [
                'label'   => 'Cocktails',
                'italian' => 'Aperitivo',
                'items'   => [
                    [
                        'name'  => 'Negroni del Cortile',
                        'desc'  => 'Gin, bitter, vermouth — stirred, orange peel, one large ice.',
                        'price' => '13',
                        'image' => 'cocktail-negroni',
                        'alt'   => 'Negroni cocktail with orange peel on a marble table',
                        'badge' => '',
                        'tags'  => [],
                        'feature' => true,
                    ],
                ],
            ],

        ],
    ],

    /* ---------------------------------------------------------------------
     * 6. CHEF
     * ------------------------------------------------------------------ */
    'chef' => [
        'eyebrow'   => '03 — Lo chef',
        'name'      => 'Luca Marchesi',
        'role'      => 'Chef & co-fondatore',
        'portrait'  => 'chef',
        'quote'     => 'A plate should taste of a place, not of a technique.',
        'body'      => [
            'Luca grew up between the kitchen of his grandmother Ida and the fields outside Parma, where a pot of broth was always on the stove. He trained in Modena and Copenhagen, then came home — because, as he puts it, "the ingredients were better here".',
            'He still folds every tortello himself in the morning, before service. The menu changes with the market; his way of cooking never does.',
        ],
        'signature' => 'Luca',
        'caption'   => 'In the kitchen, 11:00',
    ],

    /* ---------------------------------------------------------------------
     * 7. SIGNATURE DISH
     * ------------------------------------------------------------------ */
    'signature' => [
        'eyebrow'   => '04 — Il piatto',
        'name'      => "Tortelli d’Erbette",
        'kicker'    => 'The dish we are known for',
        'body'      => 'Forty tortelli, folded by hand each morning, filled with ricotta and wild herbs, finished with brown butter, sage from the courtyard and Parmigiano Reggiano aged thirty-six months.',
        'meta'      => ['Vegetarian', '€24', 'Wine pairing — Malvasia dei Colli di Parma'],
        'image'     => 'signature',
        'alt'       => "Tortelli d’Erbette served on a handmade ceramic plate",
    ],

    /* ---------------------------------------------------------------------
     * 8. GALLERY  (opening order = lightbox order)
     * ------------------------------------------------------------------ */
    'gallery' => [
        'eyebrow' => '05 — La galleria',
        'title'   => 'Moments,<br>in the <em>light</em>.',
        'items'   => [
            ['src' => 'hero',          'alt' => 'The dining room of Cortile in the afternoon light',   'caption' => 'La sala',       'shape' => 'wide'],
            ['src' => 'terrace',       'alt' => 'Olive trees and linen tables on the terrace',           'caption' => 'Il cortile',    'shape' => 'tall'],
            ['src' => 'pasta-making',  'alt' => 'Tagliatelle nests on a marble worktop',                  'caption' => 'Le mani',       'shape' => 'square'],
            ['src' => 'dish-tagliolini','alt' => 'Tagliolini with black truffle',                          'caption' => 'Il tartufo',    'shape' => 'wide'],
            ['src' => 'chef',          'alt' => 'Chef Luca Marchesi in the kitchen',                       'caption' => 'Lo chef',       'shape' => 'tall'],
            ['src' => 'signature',     'alt' => "Tortelli d’Erbette with sage butter",                     'caption' => 'La firma',      'shape' => 'square'],
        ],
    ],

    /* ---------------------------------------------------------------------
     * 9. RESERVATION
     * ------------------------------------------------------------------ */
    'reservation' => [
        'eyebrow'  => '06 — Prenotazione',
        'title'    => 'Your table<br>in the <em>courtyard</em>.',
        'lead'     => 'We keep a few tables each evening for walk-ins, but the courtyard fills quickly — especially on Fridays and Saturdays.',
        'seating'  => ['Sala', 'Cortile', 'Terrazza'],
        'services' => ['Lunch', 'Dinner'],
        'note'     => 'For parties of nine or more, please call us at +39 0521 24 18 90.',
        'cutoff'   => 'Reservations are confirmed within two hours.',
    ],

    /* ---------------------------------------------------------------------
     * 10. ONLINE ORDER (front-end simulation only)
     * ------------------------------------------------------------------ */
    'order' => [
        'eyebrow' => '07 — A casa',
        'title'   => 'Cortile,<br>at your <em>table</em>.',
        'lead'    => 'The same kitchen, the same hands. Delivered across Parma in thirty-five minutes, or ready to collect in twenty.',
        'modes'   => [
            'delivery' => [
                'label'  => 'Delivery',
                'note'   => '25 — 35 min · Parma city',
                'fee'    => 4.90,
                'free'   => 45.00,
            ],
            'takeaway' => [
                'label'  => 'Take away',
                'note'   => '15 — 20 min · Via Farini 12',
                'fee'    => 0.00,
                'free'   => 0.00,
            ],
        ],
        'items' => [
            ['id' => 'tortelli',  'name' => "Tortelli d’Erbette",      'desc' => 'Brown butter, sage, Parmigiano 36 months', 'price' => 24.00, 'image' => 'signature'],
            ['id' => 'tagliolini','name' => 'Tagliolini al Tartufo',   'desc' => 'Black truffle, butter emulsion',           'price' => 32.00, 'image' => 'dish-tagliolini'],
            ['id' => 'burrata',   'name' => 'Burrata di Andria',       'desc' => 'Heirloom tomatoes, basil oil',              'price' => 18.00, 'image' => 'dish-burrata'],
            ['id' => 'pizza',     'name' => 'Margherita Sbagliata',    'desc' => 'San Marzano, fior di latte, basil',         'price' => 16.00, 'image' => 'dish-pizza-margherita'],
            ['id' => 'guancia',   'name' => 'Guancia di Manzo',        'desc' => 'Barolo, polenta, gremolata',                'price' => 29.00, 'image' => 'dish-guancia'],
            ['id' => 'tiramisu',  'name' => 'Tiramisù del Cortile',    'desc' => 'Mascarpone, espresso, cocoa',               'price' => 12.00, 'image' => 'dish-tiramisu'],
        ],
    ],

    /* ---------------------------------------------------------------------
     * 11. TESTIMONIALS
     * ------------------------------------------------------------------ */
    'testimonials' => [
        'eyebrow' => '08 — Ospiti',
        'title'   => 'What our guests<br><em>remember</em>.',
        'items'   => [
            [
                'quote'  => 'We came for dinner and stayed three hours without noticing. The tortelli are the best I have eaten outside my mother\'s kitchen.',
                'name'   => 'Elena Rossi',
                'meta'   => 'Milano · September 2025',
                'source' => 'Google',
                'stars'  => 5,
            ],
            [
                'quote'  => 'The courtyard at sunset is worth the trip alone. Service that anticipates everything, and a wine list made with real love.',
                'name'   => 'James Whitmore',
                'meta'   => 'London · June 2025',
                'source' => 'Tripadvisor',
                'stars'  => 5,
            ],
            [
                'quote'  => 'Discreet, luminous, precise. We celebrated our anniversary here and left feeling we had been invited to someone\'s home.',
                'name'   => 'Chiara e Marco Bellini',
                'meta'   => 'Parma · April 2025',
                'source' => 'Google',
                'stars'  => 5,
            ],
            [
                'quote'  => 'The kind of restaurant that makes you reconsider your plans for the rest of the evening. The Negroni alone is a reason to return.',
                'name'   => 'Sofia Lindqvist',
                'meta'   => 'Stockholm · October 2025',
                'source' => 'Google',
                'stars'  => 5,
            ],
        ],
    ],

    /* ---------------------------------------------------------------------
     * 12. FAQ
     * ------------------------------------------------------------------ */
    'faq' => [
        'eyebrow' => '09 — Domande',
        'title'   => 'Good to<br><em>know</em>.',
        'lead'    => 'A few things guests often ask us before their first visit. Anything else — simply call.',
        'items'   => [
            [
                'q' => 'Do you have a dress code?',
                'a' => 'None at all. Most of our guests come as they are after work or a walk through the city. The courtyard is gravel in places, so we would only suggest avoiding very thin heels.',
            ],
            [
                'q' => 'Where can I park?',
                'a' => 'Piazza della Pilotta car park is a four-minute walk away, and there is metered parking along Via Farini after 19:00. We can call a taxi for you at the end of the evening.',
            ],
            [
                'q' => 'Can you accommodate allergies and dietary needs?',
                'a' => 'Yes. Tell us when you book — our kitchen prepares vegetarian, vegan and gluten-free versions of most dishes. Please note that our pasta is made with flour and eggs in the same kitchen.',
            ],
            [
                'q' => 'Are children welcome?',
                'a' => 'Very much so. We have high chairs, a smaller menu on request, and the courtyard is enclosed, so parents can relax a little.',
            ],
            [
                'q' => 'Can we bring our dog?',
                'a' => 'Of course. Well-behaved dogs are welcome in the courtyard and in the sala; we will bring a bowl of water without being asked.',
            ],
            [
                'q' => 'Can I book the restaurant for a private event?',
                'a' => 'The whole courtyard can be reserved for up to forty-two guests, and the sala for smaller dinners of ten to twenty. Write to ciao@cortileparma.it and we will design the menu with you.',
            ],
        ],
    ],

    /* ---------------------------------------------------------------------
     * 13. FOOTER
     * ------------------------------------------------------------------ */
    'footer' => [
        'newsletter_title' => 'Letters from the courtyard',
        'newsletter_text'  => 'Four times a year: new menus, harvest dinners, and the occasional recipe.',
        'columns' => [
            [
                'title' => 'Explore',
                'links' => [
                    ['label' => 'Menu',        'href' => '#menu'],
                    ['label' => 'Our Story',   'href' => '#story'],
                    ['label' => 'Gallery',     'href' => '#gallery'],
                    ['label' => 'Reservation', 'href' => '#reservation'],
                ],
            ],
            [
                'title' => 'Visit',
                'links' => [
                    ['label' => 'Delivery',    'href' => '#order'],
                    ['label' => 'Contact',     'href' => '#contact'],
                    ['label' => 'FAQ',         'href' => '#faq'],
                    ['label' => 'Private events', 'href' => '#contact'],
                ],
            ],
        ],
        'credits' => 'Site design & development — prototype',
    ],

];
