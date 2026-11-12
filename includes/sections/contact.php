<?php
/**
 * CONTACT — details, hours and a hand-drawn stylised map (pure SVG).
 */
?>
<section class="contact section" id="contact">
    <div class="container contact__grid">

        <div class="contact__info">
            <p class="eyebrow" data-reveal>10 — Contatti</p>
            <h2 class="section-title" data-reveal>Find us<br>in <em>Parma</em>.</h2>

            <address class="contact__block" data-reveal>
                <span class="label">Address</span>
                <p><?= e(site('contact.street')) ?><br>
                   <?= e(site('contact.postcode')) ?> <?= e(site('contact.city')) ?>, <?= e(site('contact.region')) ?></p>
                <span class="contact__hint">Behind the unmarked door on the left — ring the brass bell.</span>
            </address>

            <div class="contact__block" data-reveal>
                <span class="label">Reservations</span>
                <p>
                    <a href="tel:<?= e(site('contact.phone_href')) ?>"><?= e(site('contact.phone')) ?></a><br>
                    <a href="mailto:<?= e(site('contact.email')) ?>"><?= e(site('contact.email')) ?></a>
                </p>
            </div>

            <div class="contact__actions" data-reveal>
                <a class="btn btn--primary js-magnetic" href="tel:<?= e(site('contact.phone_href')) ?>">
                    <span>Call</span>
                    <?= icon('phone') ?>
                </a>
                <a class="btn btn--outline" href="<?= e(site('contact.maps')) ?>" target="_blank" rel="noopener">
                    <span>Get directions</span>
                    <?= icon('arrow-up-right') ?>
                </a>
            </div>

            <div class="contact__hours" data-reveal>
                <span class="label">Opening hours</span>
                <ul class="hours">
                    <?php foreach (site('hours') as $row): ?>
                        <li class="hours__row<?= !empty($row['closed']) ? ' is-closed' : '' ?>">
                            <span class="hours__days"><?= e($row['days']) ?></span>
                            <span class="hours__time"><?= e($row['time']) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Stylised map: illustrative, not geographic -->
        <div class="contact__map" data-reveal>
            <div class="map">
                <svg viewBox="0 0 620 720" class="map__svg" role="img" aria-label="Stylised map showing Cortile on Via Farini in Parma">
                    <rect width="620" height="720" fill="#F2EEE8"/>

                    <!-- blocks -->
                    <g fill="#E9E2D6">
                        <rect x="34" y="46" width="150" height="120" rx="4"/>
                        <rect x="212" y="46" width="120" height="92" rx="4"/>
                        <rect x="360" y="46" width="98" height="120" rx="4"/>
                        <rect x="482" y="46" width="112" height="70" rx="4"/>
                        <rect x="34" y="204" width="112" height="140" rx="4"/>
                        <rect x="176" y="176" width="156" height="86" rx="4"/>
                        <rect x="356" y="196" width="76" height="148" rx="4"/>
                        <rect x="462" y="150" width="132" height="112" rx="4"/>
                        <rect x="34" y="382" width="132" height="96" rx="4"/>
                        <rect x="196" y="298" width="136" height="180" rx="4"/>
                        <rect x="356" y="380" width="98" height="98" rx="4"/>
                        <rect x="482" y="300" width="112" height="178" rx="4"/>
                        <rect x="34" y="512" width="118" height="130" rx="4"/>
                        <rect x="182" y="516" width="150" height="126" rx="4"/>
                        <rect x="360" y="516" width="94" height="126" rx="4"/>
                        <rect x="482" y="516" width="112" height="90" rx="4"/>
                    </g>

                    <!-- park + river -->
                    <path d="M470 660c40-30 74-34 118-22v82H470z" fill="#DDE3D5"/>
                    <path d="M-20 630c90-20 150 6 226 22 88 18 150-6 210-40" fill="none" stroke="#D6DED4" stroke-width="26" stroke-linecap="round"/>

                    <!-- streets -->
                    <g stroke="#FAF8F5" stroke-width="16" stroke-linecap="round">
                        <path d="M4 186h612"/>
                        <path d="M4 362h612"/>
                        <path d="M4 496h612"/>
                        <path d="M166 4v712"/>
                        <path d="M344 4v712"/>
                        <path d="M464 4v712"/>
                    </g>
                    <g stroke="#FAF8F5" stroke-width="8" stroke-linecap="round" opacity=".9">
                        <path d="M4 278h612"/>
                        <path d="M264 4v712"/>
                        <path d="M540 4v712"/>
                    </g>

                    <!-- piazza -->
                    <circle cx="404" cy="428" r="54" fill="#FAF8F5"/>
                    <circle cx="404" cy="428" r="40" fill="none" stroke="#E0D7C8" stroke-width="1.4" stroke-dasharray="3 4"/>
                    <circle cx="404" cy="428" r="7" fill="#C9BFAE"/>

                    <!-- walking route -->
                    <path d="M404 428c-44 6-58 44-80 60-16 12-34 14-48 12" fill="none" stroke="#B9925B" stroke-width="2" stroke-dasharray="1 7" stroke-linecap="round"/>

                    <!-- pin -->
                    <g transform="translate(276 500)">
                        <ellipse cx="0" cy="46" rx="26" ry="6" fill="#B9925B" opacity=".16"/>
                        <path d="M0 44S-22 18-22 4A22 22 0 0 1 22 4c0 14-22 40-22 40z" fill="#B9925B"/>
                        <circle cx="0" cy="3" r="11" fill="#FAF8F5"/>
                        <path d="M-4 8V2.5a4 4 0 0 1 8 0V8" fill="none" stroke="#B9925B" stroke-width="1.1"/>
                        <path d="M-6 8H6" stroke="#B9925B" stroke-width="1.1"/>
                        <circle class="map__pulse" cx="0" cy="4" r="30" fill="none" stroke="#B9925B" stroke-width="1" opacity=".5"/>
                        <circle cx="0" cy="4" r="42" fill="none" stroke="#B9925B" stroke-width="1" opacity=".22"/>
                    </g>

                    <!-- labels -->
                    <g fill="#8C8171" font-family="Manrope, sans-serif" font-size="9" letter-spacing="1.4">
                        <text x="34" y="196">VIA FARINI</text>
                        <text x="404" y="420" text-anchor="middle" font-size="8">PIAZZA</text>
                        <text x="404" y="432" text-anchor="middle" font-size="8">GARIBALDI</text>
                        <text x="486" y="704" font-size="8">PARCO DUCALE</text>
                        <text x="30" y="708" font-size="8">PARMA</text>
                        <text x="472" y="250" font-size="8" transform="rotate(-90 472 250)">STRADA DELLA REPUBBLICA</text>
                    </g>

                    <!-- scale -->
                    <g transform="translate(494 660)" stroke="#8C8171" stroke-width="1.2">
                        <path d="M0 0h60M0 -4v8M60 -4v8"/>
                        <text x="30" y="18" fill="#8C8171" font-family="Manrope, sans-serif" font-size="8" text-anchor="middle" stroke="none">200 m</text>
                    </g>
                </svg>

                <div class="map__card">
                    <span class="map__eyebrow">Cortile · Ristorante</span>
                    <span class="map__address">Via Farini 12, Parma</span>
                    <span class="map__meta">5 min from Piazza Garibaldi</span>
                </div>

                <span class="map__compass" aria-hidden="true">
                    <svg viewBox="0 0 40 40" fill="none">
                        <circle cx="20" cy="20" r="18" stroke="currentColor" stroke-width=".7" opacity=".4"/>
                        <path d="M20 6l4 14-4 14-4-14z" fill="currentColor" opacity=".55"/>
                    </svg>
                    <span>N</span>
                </span>
            </div>
        </div>
    </div>
</section>
