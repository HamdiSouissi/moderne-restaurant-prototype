<?php
/**
 * RESERVATION — front-end only simulation (no backend, no database).
 */
$reservation = site('reservation');

$times = [
    '12:30', '13:00', '13:30', '14:00',
    '19:00', '19:30', '20:00', '20:30', '21:00', '21:30',
];
?>
<section class="reservation section" id="reservation">
    <div class="container reservation__grid">

        <div class="reservation__aside">
            <p class="eyebrow" data-reveal><?= e($reservation['eyebrow']) ?></p>
            <h2 class="section-title" data-reveal><?= $reservation['title'] ?></h2>
            <p class="lead" data-reveal><?= e($reservation['lead']) ?></p>

            <ul class="reservation__info" data-reveal>
                <li>
                    <?= icon('clock') ?>
                    <div>
                        <span class="label">Service</span>
                        <p><?= e(site('hours_short')) ?> · Monday closed</p>
                    </div>
                </li>
                <li>
                    <?= icon('phone') ?>
                    <div>
                        <span class="label">Prefer to call?</span>
                        <p><a href="tel:<?= e(site('contact.phone_href')) ?>"><?= e(site('contact.phone')) ?></a></p>
                    </div>
                </li>
                <li>
                    <?= icon('pin') ?>
                    <div>
                        <span class="label">Where</span>
                        <p><?= e(site('contact.street')) ?>, <?= e(site('contact.city')) ?></p>
                    </div>
                </li>
            </ul>

            <p class="reservation__note" data-reveal><?= e($reservation['note']) ?></p>

            <div class="reservation__image" data-reveal aria-hidden="true">
                <?= img('terrace', [
                    'alt'    => '',
                    'sizes'  => '(max-width: 900px) 90vw, 30vw',
                    'width'  => 1023,
                    'height' => 1537,
                ]) ?>
                <span class="reservation__image-tag">Il cortile</span>
            </div>
        </div>

        <form class="reservation__form card" data-reservation novalidate>
            <div class="form__head">
                <h3>Reserve your table</h3>
                <p><?= e($reservation['cutoff']) ?></p>
            </div>

            <div class="form__grid">
                <div class="field">
                    <label class="field__label" for="res-name">Name <span aria-hidden="true">*</span></label>
                    <input class="field__input" id="res-name" name="name" type="text" autocomplete="name"
                           placeholder="Your name" required data-validate="text">
                    <span class="field__error" data-error></span>
                </div>

                <div class="field">
                    <label class="field__label" for="res-phone">Phone <span aria-hidden="true">*</span></label>
                    <input class="field__input" id="res-phone" name="phone" type="tel" autocomplete="tel"
                           placeholder="+39" required data-validate="phone">
                    <span class="field__error" data-error></span>
                </div>

                <div class="field field--full">
                    <label class="field__label" for="res-email">Email <span aria-hidden="true">*</span></label>
                    <input class="field__input" id="res-email" name="email" type="email" autocomplete="email"
                           placeholder="you@example.com" required data-validate="email">
                    <span class="field__error" data-error></span>
                </div>

                <div class="field">
                    <label class="field__label" for="res-guests">Guests</label>
                    <div class="field__select">
                        <select class="field__input" id="res-guests" name="guests" required>
                            <?php for ($i = 1; $i <= 8; $i++): ?>
                                <option value="<?= $i ?>"<?= $i === 2 ? ' selected' : '' ?>>
                                    <?= $i === 1 ? '1 guest' : $i . ' guests' ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                        <?= icon('chevron-down') ?>
                    </div>
                </div>

                <div class="field">
                    <label class="field__label" for="res-date">Date <span aria-hidden="true">*</span></label>
                    <input class="field__input" id="res-date" name="date" type="date" required data-validate="date">
                    <span class="field__error" data-error></span>
                </div>

                <div class="field field--full">
                    <label class="field__label" for="res-time">Time <span aria-hidden="true">*</span></label>
                    <div class="field__select">
                        <select class="field__input" id="res-time" name="time" required>
                            <option value="" selected disabled>Choose a time</option>
                            <optgroup label="Lunch">
                                <?php foreach (array_slice($times, 0, 4) as $time): ?>
                                    <option value="<?= e($time) ?>"><?= e($time) ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                            <optgroup label="Dinner">
                                <?php foreach (array_slice($times, 4) as $time): ?>
                                    <option value="<?= e($time) ?>"><?= e($time) ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                        <?= icon('chevron-down') ?>
                    </div>
                    <span class="field__error" data-error></span>
                </div>

                <fieldset class="field field--full seating">
                    <legend class="field__label">Room</legend>
                    <div class="seating__options">
                        <?php foreach ($reservation['seating'] as $index => $room): ?>
                            <label class="seating__option">
                                <input type="radio" name="room" value="<?= e($room) ?>"<?= $index === 1 ? ' checked' : '' ?>>
                                <span class="seating__box">
                                    <span class="seating__name"><?= e($room) ?></span>
                                    <span class="seating__detail"><?= $index === 1 ? 'Open-air' : ($index === 0 ? 'Main room' : 'Garden side') ?></span>
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </fieldset>

                <div class="field field--full">
                    <label class="field__label" for="res-notes">Notes <span class="field__optional">— optional</span></label>
                    <textarea class="field__input field__input--area" id="res-notes" name="notes" rows="3"
                              placeholder="Allergies, celebrations, a particular table…"></textarea>
                </div>
            </div>

            <button class="btn btn--primary btn--full js-magnetic" type="submit">
                <span>Reserve now</span>
                <?= icon('arrow-up-right') ?>
            </button>

            <p class="form__foot">
                <span aria-hidden="true"><?= icon('check') ?></span>
                No prepayment. You will receive a confirmation by email.
            </p>
        </form>
    </div>
</section>
