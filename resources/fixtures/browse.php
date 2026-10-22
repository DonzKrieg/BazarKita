<?php

return (static function (): array {
    // Additional published examples for Task 05; admin fixtures remain independent.
    $base = require __DIR__.'/frontend.php';
    $events = array_values(array_filter($base['events'], fn ($event) => $event['status'] === 'published'));
    foreach ([['bazar-sukajadi', 'Temu Kreatif Sukajadi', 'Sukajadi, Bandung', 0], ['bazar-coblong', 'Pasar Komunitas Coblong', 'Coblong, Bandung', 100000], ['bazar-cikutra', 'Pekan Usaha Cikutra', 'Cikutra, Bandung', 140000]] as [$id, $name, $location, $amount]) {
        $event = $base['events'][0];
        $event['id'] = $id;
        $event['name'] = $name;
        $event['location']['label'] = $location;
        [$event['location']['latitude'], $event['location']['longitude']] = match ($id) {
            'bazar-sukajadi' => [-6.889, 107.598],
            'bazar-coblong' => [-6.8868, 107.6133],
            default => [-6.898, 107.638],
        };
        $event['organizer'] = 'Panitia '.$name.' — Contoh';
        $event['offer']['id'] = 'offer-'.$id;
        $event['offer']['source_amount'] = $amount;
        $event['offer']['daily_amount'] = $amount;
        $event['offer']['price_label'] = 'Rp'.number_format($amount, 0, ',', '.').'/hari';
        $event['offer']['mandatory_fees'] = [];
        $event['offer']['fees_label'] = 'Tidak ada biaya wajib menurut keterangan contoh.';
        if ($id === 'bazar-coblong') {
            $event['offer'] = $base['events'][3]['offer'];
            $event['offer']['id'] = 'offer-'.$id;
            $event['ends_on'] = '2026-11-09';
            $event['date_label'] = '7–9 November 2026';
        }
        if ($id === 'bazar-cikutra') {
            $event['offer']['basis'] = 'variable';
            $event['offer']['daily_rates'] = [['date' => '2026-11-07', 'amount' => 100000], ['date' => '2026-11-08', 'amount' => 140000]];
            $event['offer']['price_label'] = 'Rp100.000–Rp140.000/hari';
            $event['offer']['rental_days'] = 2;
            $event['offer']['commitment_label'] = 'Wajib sewa 2 hari';
        }
        $events[] = $event;
    }
    foreach ($events as &$event) {
        $event['contact'] = $event['id'] === 'bazar-dago' ? 'penyelenggara@example.test' : null;
        $event['deadline'] = null;
        if ($event['id'] === 'bazar-cikutra') {
            $event['source']['checked_at'] = '2026-10-20T02:00:00Z';
        }
    }
    unset($event);
    usort($events, fn ($a, $b) => [$a['starts_on'], $a['id']] <=> [$b['starts_on'], $b['id']]);

    return $events;

})();
