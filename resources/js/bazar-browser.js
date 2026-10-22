import profilePreview, { validateProfile } from './profile-preview';

const origins = { 'coblong, bandung': [-6.8868, 107.6133], 'dago, bandung': [-6.883, 107.613], 'braga, bandung': [-6.917, 107.609] };
const radians = degrees => degrees * Math.PI / 180;
export function distance(origin, location) {
    if (!origin || !location || location.latitude == null || location.longitude == null) return null;
    const [lat, lon] = origin;
    const a = Math.sin(radians(location.latitude - lat) / 2) ** 2 + Math.cos(radians(lat)) * Math.cos(radians(location.latitude)) * Math.sin(radians(location.longitude - lon) / 2) ** 2;
    return 6371 * 2 * Math.asin(Math.sqrt(Math.min(1, a)));
}
export function dailyPrice(offer) {
    if (offer.basis === 'package') return offer.source_amount != null && offer.rental_days > 0 ? offer.source_amount / offer.rental_days : null;
    if (offer.basis === 'variable') return offer.daily_rates?.length ? Math.max(...offer.daily_rates.map(rate => rate.amount)) : null;
    return offer.daily_amount;
}
export default (events, fixture, role, home = false) => ({
    events, home, role, query: '', category: '', start: '', end: '', budget: '', radius: '', facility: '', origin: '', scenario: 'auto', profile: null,
    init() {
        const preview = profilePreview(fixture, role);
        preview.init();
        this.profile = preview.form;
        if (role !== 'guest') this.origin = this.profile.location;
    },
    get originPoint() { return origins[this.origin.trim().toLocaleLowerCase('id-ID')] ?? null; },
    km(event) { return distance(this.originPoint, event.location); },
    get filterError() {
        if (this.start && this.end && this.end < this.start) return 'Tanggal selesai tidak boleh sebelum tanggal mulai.';
        if (this.budget !== '' && (!Number.isSafeInteger(Number(this.budget)) || Number(this.budget) < 0)) return 'Batas sewa harus berupa rupiah bulat minimal 0.';
        if (this.radius !== '' && (!Number.isFinite(Number(this.radius)) || Number(this.radius) <= 0)) return 'Jarak maksimal harus lebih dari 0 km.';
        return '';
    },
    match(event, personal = false) {
        const p = this.profile;
        const category = personal ? p.category : this.category;
        const start = personal ? p.start : this.start;
        const end = personal ? p.end : this.end;
        const budget = personal ? p.rent : this.budget;
        const radius = personal ? p.radius : this.radius;
        const facilities = personal ? p.facilities : (this.facility ? [this.facility] : []);
        let unknown = false;
        if (event.status !== 'published' || event.ends_on < '2026-11-01') return 'no';
        if (!personal && this.query.trim() && !`${event.name} ${event.location.label}`.toLocaleLowerCase('id-ID').includes(this.query.trim().toLocaleLowerCase('id-ID'))) return 'no';
        if (category) {
            if (!event.categories) unknown = true;
            else if (!event.categories.includes(category)) return 'no';
        }
        if (event.offer.basis === 'daily' && event.offer.rental_days === 1) {
            // One-day offers need one available day; packages require the entire commitment.
            if (start && event.ends_on < start) return 'no';
            if (end && event.starts_on > end) return 'no';
        } else {
            if (start && event.starts_on < start) return 'no';
            if (end && event.ends_on > end) return 'no';
        }
        if (personal && event.registration_status !== 'open') {
            if (event.registration_status === 'closed') return 'no';
            unknown = true;
        }
        if (budget !== '') {
            const price = dailyPrice(event.offer);
            if (price == null) unknown = true;
            else if (event.offer.basis === 'package' ? event.offer.source_amount > Number(budget) * event.offer.rental_days : price > Number(budget)) return 'no';
        }
        if (radius !== '') {
            const km = this.km(event);
            if (km == null) unknown = true;
            else if (km > Number(radius)) return 'no';
        }
        if (facilities.length) {
            if (event.facilities == null) unknown = true;
            else if (!facilities.every(facility => event.facilities.includes(facility))) return 'no';
        }
        return unknown ? 'unknown' : 'yes';
    },
    get fallback() { return this.role === 'guest' || !this.profile || Object.keys(validateProfile(this.profile)).length > 0 || this.scenario === 'incomplete'; },
    get title() { return this.fallback ? 'Bazar Mendatang' : 'Pilihan untuk Usaha Anda'; },
    get selected() {
        if (this.fallback) return this.events.slice(0, 3);
        const candidates = this.events.filter(event => this.match(event, true) === 'yes');
        // Deterministic local preview; missing product-price evidence contributes nothing.
        const score = event => Math.round((45 + 20 * Math.max(0, 1 - this.km(event) / Number(this.profile.radius)) + 20 * (Number(this.profile.rent) === 0 ? 1 : Math.max(0, 1 - dailyPrice(event.offer) / Number(this.profile.rent)))) * 100) / 100;
        candidates.sort((a, b) => score(b) - score(a) || a.starts_on.localeCompare(b.starts_on) || a.id.localeCompare(b.id));
        return candidates.slice(0, this.scenario === 'auto' ? 3 : Math.min(3, Number(this.scenario)));
    },
    get matching() { return this.filterError ? [] : this.events.filter(event => this.match(event) === 'yes'); },
    get uncertain() { return this.filterError ? [] : this.events.filter(event => this.match(event) === 'unknown'); },
    visible(id, group = 'yes') { return (this.home ? this.selected : group === 'yes' ? this.matching : this.uncertain).some(event => event.id === id); },
    reset() { this.query = ''; this.category = ''; this.start = ''; this.end = ''; this.budget = ''; this.radius = ''; this.facility = ''; },
});
